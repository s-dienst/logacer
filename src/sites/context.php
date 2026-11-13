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
            $error_message = 'not_content_project';
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
                            'total'     => $objects_count
                        ];
                        $objects = ObjectTable::find_by_parent($params_objects['parent_id'], $params_objects['ordering'], $params_objects['limit'], 0);
                        $params_objects['loaded'] = count($objects); 
                        if ($params_objects['loaded'] > 0) {
                            $params_objects['offset'] = end($objects)->id();
                        } else {
                            $params_objects['offset'] = 0;
                        }
                        /* Check si visible */
                        if (!$context->public() && !$context->contributor_rights()) {
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

    if ($_POST && !$error_message) {

        $context->check_post();

        $context->manage_bibliography('back');
        $context->manage_files('back');
        // Gérer la suppression
        if (isset($_POST['typeaction'])) {
            if ($_POST['typeaction'] === 'delete') {
                $context->delete($context->url('parent'), ['objectTable']);
            }
        } elseif (isset($_POST['delete_object'])) {
            $del_obj = ObjectTable::find_by_id($_POST['delete_object']);
            $del_obj->delete($del_obj->url('parent'), ['picture']);
        } elseif (isset($_POST['delete_objects'])) {
            // Suppression de tous les objets
            foreach (ObjectTable::find_by_parent($params_objects['parent_id']) as $del_obj) {
                $del_obj->delete(false, ['picture']);
            }
            // Récupération des objets restants
            $objects = ObjectTable::find_by_parent($params_objects['parent_id'], $params_objects['ordering'], $params_objects['limit'], 0);
            $params_objects['loaded'] = count($objects); 
            if ($params_objects['loaded'] > 0) {
                $params_objects['offset'] = end($objects)->id();
            } else {
                $params_objects['offset'] = 0;
            }
        }
        // Gérer l'ajout de nouveaux objets
        elseif (isset($_POST['objects'])) {
            // Boucle sur tous les objets
            for ($i = 0 ; $i < count($_POST['objects']) ; $i++) {
                // Vérifie si objet complété -> a un numéro d'inventaire
                if ($_POST['objects'][$i]['number']) {
                    $object = $_POST['objects'][$i];
                    $object['related_context'] = $context->id();
                    $object = new ObjectTable($object);
                    $object->save();
                }
            }
            header('Location: ' . $context->url());
            exit();
        }
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

                // Buttons for the phase
                $context->buttons_contrib();

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

                // Affichage erreurs objets
                if (isset($_SESSION['objects_errors'])) {
                    echo "<div class='alert alert-danger'>" .
                        "Certains objets ajoutés ou modifiés n'ont pas pu être bien enregistrés :" . "<ul>";
                    foreach ($_SESSION['objects_errors'] as $number=>$errors) {
                        echo "<li>" . b($number . thesaurus(':')) . "<ul>";
                        foreach ($errors as $error) {
                            echo li($error);
                        }
                        echo "</ul></li>";
                    }
                    echo "</ul></div>";
                    unset($_SESSION['objects_errors']);
                }

                // Navigation tabs
                if ($context->contributor_rights() || $context->description() || count(Bibliography::linked('context', 'bibliography', $context->id())) > 0 || count(File::linked('context', 'file', $context->id())) > 0) {
                    echo nav_tabs(['description', 'inventory']);
                    $nav_tabs = true;
                    echo "<div id='div_1' style='display:block'><br>";
                } else {
                    $nav_tabs = false;
                    echo "<div id='div_1' style='display:none'><br>";
                }

                // Informations about the context
                

                    $context->description('display');

                    // Show and manage bibliography
                    if ($site->unpublished()) {
                        echo h(4, ucfirst(thesaurus("this site")) . " " . thesaurus("is unpublished") . ".");
                    } elseif ($phase->unpublished()) {
                        echo h(4, ucfirst(thesaurus("this phase")) . " " . thesaurus("is unpublished") . ".");
                    } elseif ($context->unpublished()) {
                        echo h(4, ucfirst(thesaurus("this context")) . " " . thesaurus("is unpublished") . ".");
                    } else {
                        echo h(3, ucfirst(thesaurus("bibliography")));
                        $context->manage_bibliography('front');
                    }


                    // Show and manage files
                    $context->manage_files('front');
                
                echo "</div>";

            ?>

                <!-- Display inventory -->
                <?php if ($nav_tabs) { echo "<div id='div_2' style='display:none'><br>"; } else { echo "<div id='div_2' style='display:block'><br>"; }
                    echo h(3, ucfirst(thesaurus('inventory')));
                ?>

                    <!-- Buttons for the inventory, refer to forms ; TO CHANGE -->
                    <?php if ($context->contributor_rights()): ?>
                        <form action='<?php echo $context->url(); ?>' method='post'>
                    <?php endif ?>
                    <div class="btn-group" role="group">
                        <?php if ($context->contributor_rights()): ?>
                            <?php if (count($objects) > 0): ?>
                                <a class="btn btn-outline-secondary" href="<?php echo $context->url('update_objects');  ?>"><?php echo ucfirst(thesaurus('modify') . ' ' . thesaurus('the inventory')); ?></a>
                            <?php endif ?>
                            <a class="btn btn-outline-success" href="<?php echo $context->url('new_object');  ?>"><?php echo ucfirst(thesaurus('add') . ' ' . thesaurus('a object')); ?></a>
                            <?php if (count($objects) > 0): ?>
                                    <button type='submit' class='btn btn-outline-danger' id='delete_objects' name='delete_objects' value='delete_objects'><?php echo ucfirst(thesaurus('delete')) . " " . thesaurus("the inventory"); ?></button>
                            <?php endif ?>
                        <?php endif ?>
                        <?php if (ISOLATED_WEBSITE) { ?>
                            <a class="btn btn-outline-info" href="<?php echo create_url(['sites', 'download', $site->owner_id(), $site->code(), $phase->code(), $context->code()]);  ?>"><?php echo ucfirst(thesaurus('download')); ?></a>
                        <?php } else { ?>
                            <a class="btn btn-outline-info" href="<?php echo create_url([PROJECT->code(), 'sites', 'download', $site->owner_id(), $site->code(), $phase->code(), $context->code()]);  ?>"><?php echo ucfirst(thesaurus('download')); ?></a>
                        <?php }; ?>
                    </div>
                    <?php if ($context->contributor_rights()): ?>
                        </form>
                    <?php endif ?>
                    <br>

                    <!-- Table of objects -->
                    <?php
                    if (count($objects) > 0 || $context->contributor_rights()) {
                        $cols = ['number', 'category', 'function', 'type', 'fabric'];
                        // Gestion des comptages pour que les choix du site et des utilisateurs soient reflétés
                        $countings = [];
                        $countings2 = [];
                        $countings_obj = Counting::linked('counting', 'site', $site->id(), true);
                        if (isset($_SESSION['user'])) {
                            $countings_obj2 = Counting::linked('counting', 'user', $_SESSION['user']->id(), true);
                        } else {
                            $countings_obj2 = Counting::find_all();
                        }
                        foreach ($countings_obj as $count) {
                            $countings[] = $count->id();
                        }
                        foreach ($countings_obj2 as $count) {
                            $countings2[] = $count->id();
                        }
                        if (in_array(1, $countings) && in_array(1, $countings2)) { array_push($cols, 'n_rim', 'n_bottom', 'n_handle', 'n_wall'); }
                        if (in_array(2, $countings) && in_array(2, $countings2)) { array_push($cols, 'n_mni'); }
                        if (in_array(3, $countings) && in_array(3, $countings2)) { array_push($cols, 'n_sherd'); }
                        array_push($cols, "diameter", "stamp", "comment", "picture");
                        if ($context->owner_rights()) { array_push($cols, "del_obj"); }
                        // Ajout de la liste des colonnes dans les paramètres
                        $params_objects['cols'] = $cols;
                            echo "<form action='" . $context->url() . "' method='post'>";
                                require("table_inventory.php");
                                // Buttons to add objects
                                if ($context->contributor_rights()) {
                                echo "<div id='manage_objects'>";
                                    echo ucfirst(thesaurus("add")) . " " . "<input type='number' name='add_objects_number' id='add_objects_number' min=1 max=100 placeholder='max 100'>" . " " . thesaurus("objects") . " ";
                                    echo "<button type='button' class='btn btn-success btn-sm' id='add_objects'>" . ucfirst(thesaurus('add')) . " " . thesaurus("the objects") . "</button>";
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
let activated = false;
document.addEventListener('DOMContentLoaded', function () {
    if (document.getElementById('add_objects')) {
        document.getElementById('add_objects').onclick = function() {
            let number_new_lines = Number(document.getElementById("add_objects_number").value);
            let table = document.getElementById("inventory_table");
            let cols = <?php echo json_encode($cols); ?>;

            let input_text = ["number", "category_abbr", "category_litt", "function_name", "function_litt", "type_name", "type_litt", "type_var", "type_doubt", "fabric_code", "fabric_litt", "diameter", "stamp", "comment"];
            let input_integer = ["n_rim", "n_bottom", "n_handle", "n_wall", "n_mni", "n_sherd"];
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
                        'comment'=>[['name'=>'comment', 'placeholder'=>thesaurus('comment')]],
                        'picture'=>false, 'del_obj'=>[['name'=>'del_object']]];
            if (in_array(1, $countings)) {
                $content['n_rim'] = [['name'=>'n_rim', 'placeholder'=>thesaurus('n_rim')]];
                $content['n_bottom'] = [['name'=>'n_bottom', 'placeholder'=>thesaurus('n_bottom')]];
                $content['n_handle'] = [['name'=>'n_handle', 'placeholder'=>thesaurus('n_handle')]];
                $content['n_wall'] = [['name'=>'n_wall', 'placeholder'=>thesaurus('n_wall')]];
            } if (in_array(2, $countings)) {
                $content['n_mni'] = [['name'=>'n_mni', 'placeholder'=>thesaurus('n_mni')]];
            } if (in_array(3, $countings)) {
                $content['n_sherd'] = [['name'=>'n_sherd', 'placeholder'=>thesaurus('n_sherd')]];
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
                            } else if (input['name'] == 'del_object') {
                                html += "<button type='button' class='btn btn-light btn-sm' onclick='deleteRow(this)'>X</button>";
                            }
                        }
                    }
                    newCel.innerHTML = html;
                }
            }
            number_ancient_lines = number_ancient_lines + number_new_lines;
            /* Fin de la création de lignes */

            /* Ajout du formulaire et les boutons de validation */
            if (!activated) {
                let buttons = document.getElementById("manage_objects");
                let html = "<p><div class='btn-group' role='group'>"
                    + "<input class='btn btn-success' type='submit' value='" + "<?php echo ucfirst(thesaurus('create')) ?>" + "'>"
                    + "<a class ='btn btn-secondary' href='" + "<?php echo $context->url() ?>" + "'>" + "<?php echo ucfirst(thesaurus('give up')) ?>" + "</a>" + "</div></p>";
                buttons.insertAdjacentHTML('beforeend', html);
            }
            activated = true;
        }
    }
});
function deleteRow(button) {
    // Ligne du bouton
    let row = button.parentNode.parentNode;
    // Table du bouton
    let table = row.parentNode;
    // Index de la ligne du bouton
    let rowIndex = row.rowIndex;
    // Effectuer la suppression de la ligne actuelle, jusqu'à ce qu'elle ne soit plus remplacée par la ligne suivante
    while (table.rows.length > rowIndex) {
        table.deleteRow(rowIndex);
    }
}

// Alerte suppression de tous les objets
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('delete_objects').onclick = function () {
        const validation = confirm('<?php echo thesaurus('deletion_all_objets'); ?>');
        if (validation == true) {
            return true;
        }
        else {
            return false;
        }
    };
});

</script>
                    <?php } else {
                        echo "<p class='no-info'>" . ucfirst(thesaurus("no_object_context")) . "</p>";
                    }
                echo "<br>";
                echo "</div>";

                // Commentaires liés
                if (PROJECT->setting_notes()) {
                    $comment_class = 'Context';
                    $comment_id = $context->id();
                    require_once('../users/comments.php');
                }

                // Infos to cite page
                $context->cite_page();
             } ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>

    </body>
</html>