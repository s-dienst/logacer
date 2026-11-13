<?php
    /* Récupère les données du site */
    $error_message = false;
    $site = Site::find_by_owner_code($params['idowner'], dec_sl($params['codesite']));

    if ($site) {
        /* Check si visible */
        if (!$site->public() && !$site->contributor_rights()) {
            $error_message = 'non_public_site';
        } elseif (!PROJECT) {
            $error_message = 'no_project';
        } elseif (!ISOLATED_WEBSITE && (!$site->project() || $site->project()->id() !== PROJECT->id())) {
            $error_message = 'not_in_project';
        }  else {
            /* Récupère les données de la phase */
            $phase = Phase::find_by_site_code($site->id(), dec_sl($params['codephase']));

            if ($phase) {
                /* Check si visible */
                if (!$phase->public() && !$phase->contributor_rights()) {
                    $error_message = 'non_public_phase';
                } else {
                    $context = Context::find_by_phase_code($phase->id(), dec_sl($params['codecontext']));

                    if ($context) {
                        /* Initialise le titre */
                        $title = $context->codename();
                        
                        // TODO : Tri objets --> ORDER BY -category.code DESC, -function_table.code DESC, -type.code DESC, object.number
                        $objects_count = ObjectTable::count_by_parent($context->id());
                        $params_objects = [
                            'mode'      => 'find_by_parent',
                            'parent_id' => $context->id(),
                            'ordering'  => [],
                            'limit'     => ROWS_PER_PAGE,
                            'total'     => $objects_count,
                            'biblio_rev'=> $context->biblio_review()
                        ];
                        $objects = ObjectTable::find_by_parent($params_objects['parent_id'], $params_objects['ordering'], $params_objects['limit'], 0);
                        $params_objects['loaded'] = count($objects); 
                        if ($params_objects['loaded'] > 0) {
                            $params_objects['offset'] = end($objects)->id();
                        } else {
                            $params_objects['offset'] = 0;
                        }
                        /* Check si visible */
                        if (!$context->contributor_rights()) {
                            $error_message = 'non_public_context';
                        }
                    } else {
                        $error_message = 'no_context';
                    }
                }
            } else {
                $context = false;
                $error_message = 'no_phase';
            }
        }
    } else {
        $phase = false;
        $context = false;
        $error_message = 'no_site';
    }

    if (!$error_message) {
        if (!$context->contributor_rights()) { $error_message = 'not_contributor'; }
    }

    if ($_POST && !$error_message) {

        $objects_errors = [];
        // Gérer la modification d'objets
        if (isset($_POST['object'])) {
            foreach ($_POST['object'] as $id_object=>$content) {
                $content['related_context'] = $context->id();
                $content['id'] = $id_object;
                $object = new ObjectTable($content);
                $success = $object->save();
                if (!$success) {
                    $objects_errors[ObjectTable::find_by_id($id_object)->number('simple')] = $object->display_errors(true);
                }
            }
        }
        // Gérer l'ajout de nouveaux objets
        if (isset($_POST['objects'])) {
            // Boucle sur tous les objets
            for ($i = 0 ; $i < count($_POST['objects']) ; $i++) {
                // Vérifie si objet complété -> a un numéro d'inventaire
                if ($_POST['objects'][$i]['number']) {
                    $object = $_POST['objects'][$i];
                    $object['related_context'] = $context->id();
                    $object = new ObjectTable($object);
                    $success = $object->save();
                    if (!$success) {
                        $objects_errors[$_POST['objects'][$i]['number']] = $object->display_errors(true);
                    }
                }
            }
        }
        if (count($objects_errors) > 0) {
            $_SESSION['objects_errors'] = $objects_errors;
        }
        header('Location: ' . $context->url());
        exit();
    }
?>

<!DOCTYPE html>
<html>
    <?php require_once("../layout/headers.php"); ?>
    <?php if ($context) { $context->biblio_review('body'); } else { echo "<body>"; } ?>
        <?php require_once("../layout/navbars.php"); ?>
        <div class="maindiv container">
            <!-- Error message if not a valid context -->
            <?php if ($error_message) { display_fatal_error($error_message); } else {
                // If biblio review, special display
                $context->biblio_review('message');

                // Informations about the context
                $context->codename('title');
                echo p(ucfirst(thesaurus('site')) . thesaurus(':') . ' ' . $site->hyperlink() . ". " . ucfirst(thesaurus('phase')) . thesaurus(':') . ' ' . $phase->hyperlink() . ".");
                if (PROJECT && PROJECT->setting_horizon()) {
                    echo $phase->horizon('display');
                }
                $site->owner(); $context->owner();
                echo "<br><br>";
                $context->display_errors();
                if (isset($del_obj)) { $del_obj->display_errors(); }

                    echo h(3, ucfirst(thesaurus('inventory')));
                ?>

                    <!-- Table of objects -->
                    <?php
                    if (count($objects) > 0 || $context->contributor_rights()) {
                        $cols = ['number', 'category', 'function', 'type', 'fabric'];
                        // Gestion des comptages pour que les choix du site et des utilisateurs soient reflétés
                        $countings = [];
                        $countings_obj = Counting::linked('counting', 'site', $site->id(), true);
                        foreach ($countings_obj as $count) {
                            $countings[] = $count->id();
                        }
                        if (in_array(1, $countings)) { array_push($cols, 'n_rim', 'n_bottom', 'n_handle', 'n_wall'); }
                        if (in_array(2, $countings)) { array_push($cols, 'n_mni'); }
                        if (in_array(3, $countings)) { array_push($cols, 'n_sherd'); }
                        //if (in_array(4, $countings)) { array_push($cols, 'eve'); }
                        //if (in_array(5, $countings)) { array_push($cols, 'drawing_or_cat'); }
                        array_push($cols, "diameter", "stamp", "comment");
                        // Ajout de la liste des colonnes dans les paramètres
                        $params_objects['cols'] = $cols;
                            if (ISOLATED_WEBSITE) {
                                $url_form = create_url(['site', 'update_objects', $site->code(), $phase->code(), $context->code()]);
                            } else {
                                $url_form = create_url([PROJECT->code(), 'site', 'update_objects', $site->code(), $phase->code(), $context->code()]);
                            }
                            echo "<form action='" . $url_form . "' method='post'>";
                                echo "<div class='btn-group' role='group'><button type='submit' class='btn btn-success'>" . ucfirst(thesaurus('validate')) . "</button>";
                                echo "<a class='btn btn-danger' href='" . $context->url() . "'>" . ucfirst(thesaurus('give up')) . "</a>";
                                echo "</div><br>";
                                // Bouton pour chargement
                                if (isset($objects_count)) {
                                    if (!isset($params_objects)) {
                                        $params_objects=['mode' => false, 'loaded' => 999999];
                                    }
                                    if ($objects_count > $params_objects['loaded']) {
                                        echo "<br><p>";
                                        echo "<span class='objects-counter'>"
                                            . $params_objects['loaded'] . "/" . $objects_count
                                            . " " . thesaurus('objects loaded') . "</span> ";
                                        echo "<button type='button' class='btn btn-secondary btn-sm btn-load-more'
                                            data-params='" . json_encode($params_objects) . "'>"
                                            . ucfirst(thesaurus('load more')) . "</button>";
                                        echo "</p>";
                                    }
                                }

                                echo "<br>";

                                // Filtres etc.
                                if (isset($context)) { $biblio_review = ($context->biblio_review() || $context->related_phase()->biblio_review() || $context->related_phase()->related_site()->biblio_review()); } else { $biblio_review = false; }
                                filter_box($cols, 'inventory_table', $biblio_review);

                                echo "<br><div style='font-size:small'>" . ucfirst(thesaurus('can sort by clicking headers')) . "</div>";

                                // Table
                                //if (isset($is_small)) {
                                    echo "<table class='table table-sm' id='inventory_table' style='font-size:small'><thead>";
                                //} else {
                                //    echo "<table class='table' id='inventory_table'><thead>";
                                //}
                                    table_headers($cols, 'inventory_table');
                                echo "</thead><tbody>";
                                    foreach ($objects as $object) { echo '<tr>';
                                        // Prepare if biblio_review
                                        if ($biblio_review && $site->project()->setting_litterature()) {
                                            $cat_litt = $object->input('category_litt', 'object_', false, false, true);
                                            $fun_litt = $object->input('function_litt', 'object_', false, false, true);
                                            $typ_litt = $object->input('type_litt', 'object_', false, false, true);
                                            $fab_litt = $object->input('fabric_litt', 'object_', false, false, true);
                                        } else {
                                            $cat_litt = ""; $fun_litt = ""; $typ_litt = ""; $fab_litt = "";
                                        }                                        // Number
                                        // Ajoute codes catégorie et fonction
                                        if ($object->category_link()) {
                                            $cat_sort = $object->category_link()->code();
                                        } else {
                                            $cat_sort = $object->category('simple');
                                        }
                                        if ($object->function_link()) {
                                            $fun_sort = $object->function_link()->code();
                                        } else {
                                            $fun_sort = $object->function('simple');
                                        }                                        echo "<td sort-text='" . $object->number('simple') . "'>" . $object->input('number', 'object_', false, false, true) . "</td>";
                                        // Category
                                        echo "<td sort-text='" . $cat_sort . " " . $object->category('simple') . "'>" .
                                            $object->input('category_abbr', 'object_', false, false, true)
                                            . $cat_litt
                                            . "</td>";
                                        // Function
                                        echo "<td sort-text='" . $fun_sort . " " . $object->function('simple') . "'>" .
                                            $object->input('function_name', 'object_', false, false, true)
                                            . $fun_litt
                                            . "</td>";
                                        // Type
                                        echo "<td sort-text='" . $object->type('simple') . "'>" .
                                            $object->input('type_name', 'object_', false, false, true) .
                                            $object->input('type_var', 'object_', false, false, true) .
                                            $object->input('type_doubt', 'object_', false, false, true)
                                            . $typ_litt
                                            . "</td>";
                                        // Fabric
                                        echo "<td sort-text='" . $object->fabric('simple') . "'>" .
                                            $object->input('fabric_code', 'object_', false, false, true)
                                            . $fab_litt
                                            . "</td>";
                                        // Countings
                                        if (in_array(1, $countings)) {
                                            echo "<td sort-text='" . $object->n_rim() . "'>" . $object->input_number('n_rim', 'object_', 0, "", "", false, false, true) . "</td>";
                                            echo "<td sort-text='" . $object->n_bottom() . "'>" . $object->input_number('n_bottom', 'object_', 0, "", "", false, false, true) . "</td>";
                                            echo "<td sort-text='" . $object->n_handle() . "'>" . $object->input_number('n_handle', 'object_', 0, "", "", false, false, true) . "</td>";
                                            echo "<td sort-text='" . $object->n_wall() . "'>" . $object->input_number('n_wall', 'object_', 0, "", "", false, false, true) . "</td>";
                                        } if (in_array(2, $countings)) {
                                            echo "<td sort-text='" . $object->n_mni() . "'>" . $object->input_number('n_mni', 'object_', 0, "", "", false, false, true) . "</td>";
                                        } if (in_array(3, $countings)) {
                                            echo "<td sort-text='" . $object->n_sherd() . "'>" . $object->input_number('n_sherd', 'object_', 0, "", "", false, false, true) . "</td>";
                                        } /*if (in_array(4, $countings)) {
                                            echo "<td sort-text='" . $object->eve() . "'>" . $object->input_number('eve', 'object_', 0, "", "", false, false, true) . "</td>";
                                        } if (in_array(5, $countings)) {
                                            echo "<td sort-text='" . $object->drawing_or_cat() . "'>" . $object->input_number('drawing_or_cat', 'object_', 0, "", "", false, false, true) . "</td>";
                                        }*/
                                        // Diameter
                                        echo "<td sort-text='" . $object->diameter() . "'>" . $object->input('diameter', 'object_', false, false, true) . "</td>";
                                        // Stamps
                                        echo "<td sort-text='" . $object->stamp() . "'>" . $object->input('stamp', 'object_', false, false, true) . "</td>";
                                        // Comment
                                        echo "<td sort-text='" . $object->comment() . "'>" . $object->input('comment', 'object_', false, false, true) . "</td>";
                                    echo '</tr>'; }
                                echo "</tbody></table>";

                                // Bouton pour chargement
                                if (isset($objects_count)) {
                                    if (!isset($params_objects)) {
                                        $params_objects=['mode' => false, 'loaded' => 999999];
                                    }
                                    if ($objects_count > $params_objects['loaded']) {
                                        echo "<p>";
                                        echo "<span class='objects-counter'>"
                                            . $params_objects['loaded'] . "/" . $objects_count
                                            . " " . thesaurus('objects loaded') . "</span> ";
                                        echo "<button type='button' class='btn btn-secondary btn-sm btn-load-more'
                                            data-params='" . json_encode($params_objects) . "'>"
                                            . ucfirst(thesaurus('load more')) . "</button>";
                                        echo "</p>";
                                    }
                                }
                                // Buttons to add objects
                                if ($context->contributor_rights()) {
                                echo "<div id='manage_objects'>";
                                    echo ucfirst(thesaurus("add")) . " " . "<input type='number' name='add_objects_number' id='add_objects_number' min=1 max=100 placeholder='max 100'>" . " " . thesaurus("objects") . " ";
                                    echo "<button type='button' class='btn btn-success btn-sm' id='add_objects'>" . ucfirst(thesaurus('add')) . " " . thesaurus("the objects") . "</button>";
                                echo "</div>";
                                echo "<br>" . "<div class='btn-group' role='group'><button type='submit' class='btn btn-success'>" . ucfirst(thesaurus('validate')) . "</button>";
                                echo "<a class='btn btn-danger' href='" . $context->url() . "'>" . ucfirst(thesaurus('give up')) . "</a>";
                                echo "</div>";
                            echo "</form>";
                        }
                    ?>
<script>
/* Tri de l'inventaire */
document.addEventListener('DOMContentLoaded', function() {
    sortTable(0, 'inventory_table');
    sortTable(4, 'inventory_table');
    sortTable(3, 'inventory_table');
    sortTable(2, 'inventory_table');
    sortTable(1, 'inventory_table');
})
/* Ce script permet de rajouter de nouvelles lignes au tableau pour ajouter des objets */
let number_ancient_lines = 0;
document.addEventListener('DOMContentLoaded', function () {
    if (document.getElementById('add_objects')) {
        document.getElementById('add_objects').onclick = function() {
            let number_new_lines = Number(document.getElementById("add_objects_number").value);
            let table = document.getElementById("inventory_table");
            let cols = <?php echo json_encode($cols); ?>;

            let input_text = ["number", "category_abbr", "category_litt", "function_name", "function_litt", "type_name", "type_litt", "type_var", "type_doubt", "fabric_code", "fabric_litt", "diameter", "stamp", "comment"];
            let input_integer = ["n_rim", "n_bottom", "n_handle", "n_wall", "n_mni", "n_sherd", "eve", "drawing_or_cat"];
            let maxchars = <?php echo json_encode(ObjectTable::$max_chars); ?>;
            let required = <?php echo json_encode(ObjectTable::$required); ?>;

            /* Début de création de l'objet "contenu" */
            <?php 
            if ($biblio_review && $site->project()->setting_litterature()) {
                $category = [['name'=>'category_abbr', 'placeholder'=>thesaurus('category')], ['name'=>'category_litt', 'placeholder'=>thesaurus('category_litt')]];
                $function_table = [['name'=>'function_name', 'placeholder'=>thesaurus('function')], ['name'=>'function_litt', 'placeholder'=>thesaurus('function_litt')]];
                $type = [['name'=>'type_name', 'placeholder'=>thesaurus('type')], ['name'=>'type_var', 'placeholder'=>thesaurus('type_var')], ['name'=>'type_doubt', 'placeholder'=>thesaurus('type_doubt')], ['name'=>'type_litt', 'placeholder'=>thesaurus('type_litt')]];
                $fabric = [['name'=>'fabric_code', 'placeholder'=>thesaurus('fabric')], ['name'=>'fabric_litt', 'placeholder'=>thesaurus('fabric_litt')]];
            } else {
                $category = [['name'=>'category_abbr', 'placeholder'=>thesaurus('category')]];
                $function_table = [['name'=>'function_name', 'placeholder'=>thesaurus('function')]];
                $type = [['name'=>'type_name', 'placeholder'=>thesaurus('type')], ['name'=>'type_var', 'placeholder'=>thesaurus('type_var')], ['name'=>'type_doubt', 'placeholder'=>thesaurus('type_doubt')]];
                $fabric = [['name'=>'fabric_code', 'placeholder'=>thesaurus('fabric')]];
            }

            $content = ['number'=>[['name'=>'number', 'placeholder'=>thesaurus('number')]],
                        'category'=>$category, 'function'=>$function_table, 'type'=>$type, 'fabric'=>$fabric,
                        'diameter'=>[['name'=>'diameter', 'placeholder'=>thesaurus('diameter')]],
                        'stamp'=>[['name'=>'stamp', 'placeholder'=>thesaurus('stamp')]],
                        'comment'=>[['name'=>'comment', 'placeholder'=>thesaurus('comment')]]];
            if (in_array(1, $countings)) {
                $content['n_rim'] = [['name'=>'n_rim', 'placeholder'=>thesaurus('n_rim')]];
                $content['n_bottom'] = [['name'=>'n_bottom', 'placeholder'=>thesaurus('n_bottom')]];
                $content['n_handle'] = [['name'=>'n_handle', 'placeholder'=>thesaurus('n_handle')]];
                $content['n_wall'] = [['name'=>'n_wall', 'placeholder'=>thesaurus('n_wall')]];
            } if (in_array(2, $countings)) {
                $content['n_mni'] = [['name'=>'n_mni', 'placeholder'=>thesaurus('n_mni')]];
            } if (in_array(3, $countings)) {
                $content['n_sherd'] = [['name'=>'n_sherd', 'placeholder'=>thesaurus('n_sherd')]];
            /*} if (in_array(4, $countings)) {
                $content['eve'] = [['name'=>'eve', 'placeholder'=>thesaurus('eve')]];
            } if (in_array(5, $countings)) {
                $content['drawing_or_cat'] = [['name'=>'drawing_or_cat', 'placeholder'=>thesaurus('drawing_or_cat')]];*/
            } ?>
            let content = <?php echo json_encode($content); ?>;
            /* Fin de la création de l'objet */

            /* Création des lignes supplémentaires */
            let number_lines = number_ancient_lines + number_new_lines;
            for (let i = number_ancient_lines; i < number_lines; i++) {
                let newLine = table.insertRow();
                for (const column of cols) {
                    let newCel = newLine.insertCell();
                    let html = "";
                    let inputs = content[column];
                    if (inputs) {
                        for (const input of inputs) {
                            if (input_text.includes(input['name'])) {
                                html += "<input type='text' name='objects[" + i + "][" + input['name'] + "]' maxlength = '" +  maxchars[input['name']] + "', ";
                                if (required.includes(input['name'])) { html += "required "; }
                                html += "placeholder='" + input['placeholder'] + "'>"; 
                            } else if (input_integer.includes(input['name'])) {
                                html += "<input type='number' name='objects[" + i + "][" + input['name'] + "]' min=0 ";
                                if (required.includes(input['name'])) { html += "required "; }
                                html += "placeholder='" + input['placeholder'] + "'>";
                            }
                        }
                    }
                    newCel.innerHTML = html;
                }
            }
            number_ancient_lines = number_ancient_lines + number_new_lines;
            /* Fin de la création de lignes */
        }
    }
});

document.querySelectorAll('.btn-load-more').forEach(btn => {
    btn.addEventListener('click', async function () {
        let params = JSON.parse(btn.dataset.params);
        params.project_id = <?php if (PROJECT) { echo PROJECT->id(); } else { echo 0; } ?>;

        btn.disabled = true;

        // Envoi en POST JSON
        const result = await fetch('/static/ajax/load_more_objects_edit.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest' },
            body: JSON.stringify(params)
        });

        if (!result.ok) {
            console.error("Erreur serveur", result.status);
            return;
        }

        const data = await result.json();

        // Ajouter les nouvelles lignes dans le tableau
        document.querySelector('#inventory_table tbody')
            .insertAdjacentHTML('beforeend', data.html);

        // Mise à jour de l'offset
        params.offset = data.offset;
        params.loaded = data.loaded;
        // Mise à jour du compteur
        document.querySelectorAll('.objects-counter').forEach(span => {
            span.textContent = params.loaded + "/" + params.total + " objets chargés";
        });
        // Mise à jour du bouton
        document.querySelectorAll('.btn-load-more').forEach(b => {
            b.dataset.params = JSON.stringify(params);

            // Vérifier si on a atteint le total
            if (params.loaded >= params.total) {
                b.remove();
            } else {
                b.disabled = false
            }
        })
    })
})
</script>
                    <?php } else {
                        echo "<p class='no-info'>" . ucfirst(thesaurus("no_object_context")) . "</p>";
                    }
                echo "<br>";
                // Infos to cite page
                $context->cite_page();
             } ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>

    </body>
</html>