<?php

if (!PROJECT) {
    $error_message = 'no_project';
} elseif (!PROJECT->setting_horizon()) {
    $error_message = 'not_in_project';
} else {
    if (PROJECT->setting_horizon_adv()) {
        $hor_advanced = true;
    } else {
        $hor_advanced = false;
    }
    if ($hor_advanced) {
        // Fonctions spécifiques
        require_once('/../horizons_advanced/functions_horizons_advanced.php');
    }
    /* Récupère les données du faciès */
    $error_message = false;
    $facies = Facies::find_by_id($params['idfacies']);

    // Prépare l'url de recherche (utilisée à différents endroits)
    $search_url = create_url_proj(['logacer', 'search', 'results']);

    if ($facies) {
        /* Check si visible */
        if (!$facies->public() && !$facies->contributor_rights()) {
            $error_message = 'non_public_facies';
        } elseif (!ISOLATED_WEBSITE && (!$facies->project() || $facies->project()->id() !== PROJECT->id())) {
            $error_message = 'not_content_project';
        }  else {
            /* Récupère les données de l'horizon */
            $horizon = Horizon::find_by_id($params['idhorizon']);

            if ($horizon) {
                /* Check si visible */
                if (!$horizon->public() && !$horizon->contributor_rights()) {
                    $error_message = 'non_public_horizon';
                } else {
                    /* Initialise le titre */
                    $title = $horizon->codename();

                    $objects_count = ObjectTable::count_public(['phase.horizon'=>$horizon->id()]);
                    $params_objects = [
                        'mode'          => 'find_public',
                        'conditions'    => ['phase.horizon'=>$horizon->id()],
                        'left_join'     => false,
                        'binds'         => [],
                        'ordering'      => [],
                        'conditions_ns' => false,
                        'limit'         => ROWS_PER_PAGE,
                        'total'         => $objects_count
                    ];
                    $objects = ObjectTable::find_public($params_objects['conditions'], $params_objects['left_join'], $params_objects['binds'], $params_objects['ordering'], $params_objects['conditions_ns'], $params_objects['limit'], 0);
                    $params_objects['offset'] = end($objects)->id();
                    $params_objects['loaded'] = count($objects);
                }
            } else {
                $error_message = 'no_horizon';
            }
        }
    } else {
        $horizon = false;
        $error_message = 'no_facies';
    }

    if ($_POST && !$error_message) {

        $horizon->check_post();

        $horizon->manage_files('back');
        // Gérer la suppression
        if (isset($_POST['typeaction'])) {
            if ($_POST['typeaction'] === 'delete') {
                $horizon->delete($horizon->url('parent'));
            }
        }
    }

}
?>

<!DOCTYPE html>
<html>
    <?php require_once("../layout/headers.php"); ?>
    <body>
        <?php require_once("../layout/navbars.php"); ?>
        <div class="maindiv container">
            <!-- Error message if not a valid horizon -->
            <?php if ($error_message) { display_fatal_error($error_message); } else {

                // Buttons for the horizon
                $horizon->buttons_contrib();

                // Informations about the horizon
                $horizon->codename('title');
                if ($horizon->superhorizon()) {
                    echo p(ucfirst(thesaurus('facies')) . thesaurus(':') . ' ' . $facies->hyperlink() . ". " . ucfirst(thesaurus('superhorizon')) . thesaurus(':') . ' ' . $horizon->superhorizon()->hyperlink() . ".");
                } else {
                    echo p(ucfirst(thesaurus('facies')) . thesaurus(':') . ' ' . $facies->hyperlink() . ".");
                }
                
                $facies->owner(); $horizon->owner();
                echo p(ucfirst(thesaurus('number of objects')) . thesaurus(':') . ' ' . $objects_count . '.');

                $horizon->display_errors();

                // Navigation tabs
                echo nav_tabs(['description', 'distribution', 'list of the types', 'pictures', 'inventory'], 1, 2);


                // Informations about the horizon
                echo "<div id='div_1' style='display:block'><br>";

                    $horizon->description('display');

                    // Display subhorizons
                    $subhorizons = $horizon->subhorizons();
                    if (count($subhorizons) > 0 || $horizon->contributor_rights()) {
                        echo h(3, ucfirst(thesaurus('the subhorizons'))) . "<ol>";
                        foreach ($subhorizons as $subhorizon) {
                            if ($subhorizon->public()) {
                                echo li($subhorizon->hyperlink());
                            } elseif ($subhorizon->contributor_rights()) {
                                echo li($subhorizon->hyperlink() . ' (' . b(thesaurus('non_public')) . ')');
                            }
                        }
                        if ($horizon->contributor_rights()) {
                            echo li("<a class ='btn btn-secondary btn-sm' href='" . $horizon->url('new_subhorizon') . "'>" . ucfirst(thesaurus("add")) . ' ' . thesaurus("a subhorizon") . "</a>");
                        }
                        echo "</ol>";
                    }

                    // Dating
                    $horizon->description('display', 'dating');

                    // Display phases
                    $phases = Phase::find_woc(0, ['phase.horizon'=>$horizon->id()]);
                    if (count($phases) > 0 || $horizon->contributor_rights()) {
                        echo h(3, ucfirst(thesaurus('the horizon-sites'))) . "<ul>";
                        foreach ($phases as $phase) {
                            if ($phase->public() && $phase->related_site()->public()) {
                                echo li($phase->hyperlink() . ' (' . list_val('horizon_strength', $phase->horizon_strength()) . ')');
                            } else {
                                echo li($phase->hyperlink() . ' (' . list_val('horizon_strength', $phase->horizon_strength()) . ') (' . b(thesaurus('non_public')) . ')');
                            }
                        }
                        echo "</ul>";
                    }

                    // Show and manage files
                    $horizon->manage_files('front');
                
                echo "</div>";


                // Display list of types
                echo "<div id='div_3' style='display:none'><br>";
                    echo h(3, ucfirst(thesaurus('list of the types')));

                    // Add download button : echo "<p><a class='btn btn-outline-info' href='" . BASE_URL . 'inventory/download/q?' . text_secure($query, 3) . "'>Télécharger l'inventaire complet</a></p>

                    // Search list of categories linked to the horizon. TO TEST WITH UNDEFINED (DISTINCT & NULL VALUE)
                    if (count($phases) > 0) {
                        echo p(ucfirst(thesaurus('can sort by clicking headers')));
                        // Filtres
                        if ($hor_advanced) {
                            $cols = ['category', 'type', 'type_link', 'occurence number'];
                        } else {
                            $cols = ['category', 'type', 'occurence number'];
                        }
                        filter_box($cols, 'table_types', false, 150);
                        echo "<table class='table' id='table_types'><thead>";
                        table_headers($cols, 'table_types');
                        echo "</thead><tbody>";

                        if ($hor_advanced) {
                            // Liste des ID des types liés et numéro de la colonne
                            $id_types = [];
                            $col_type_num = 0;
                        }

                        $categories = Category::find_all();
                        $rest = $objects_count;
                        foreach ($categories as $category) {
                            // If there is a category
                            if ($category->id()) {
                                //$types = Type::find_woc(0, ['category_link'=>$category->id(), 'phase.horizon'=>$horizon->id()]);
                                $types = Type::find_woc(0, ['category_abbr'=>$category->abbreviation(), 'phase.horizon'=>$horizon->id()]);
                                foreach ($types as $type) {
                                    echo "<tr>";
                                        if (!$type->id()) {
                                            $sorting = '~~'; $hyperlink = ucfirst(thesaurus('no link type')); $code='0'; $equal = 'isnull';
                                            if ($hor_advanced) {
                                                // Check lien
                                                $link_type = false;
                                            }
                                        } else {
                                            $sorting = $code = $type->code(); $hyperlink = $type->hyperlink(); $equal = 'eq';
                                            if ($hor_advanced) {
                                                // Check lien
                                                $link_type = $type->is_linked($horizon->id());
                                                if ($link_type !== false && !in_array($type->id(), $id_types)) {
                                                    $id_types[] = $type->id();
                                                }
                                            }
                                        }
                                        echo "<td sort-text='" . $category->code() . "'>" . $category->codename() . "</td>";
                                        echo "<td sort-text='" . $sorting . "'>" . $hyperlink . "</td>";
                                        if ($hor_advanced) {
                                            echo "<td id='cell_link_type" . $col_type_num . "' sort-text='" . th_h_a_link_type($link_type) . "'>" . ucfirst(th_h_a_link_type($link_type));
                                            if ($horizon->contributor_rights() && $type->id()) {
                                                echo " (<a href='#' class='edit-link' data-row='" . $col_type_num . "' data-type_id='" . $type->id() . "'>" . ucfirst(thesaurus('modify')) . "</a>)";
                                            }
                                            echo "</td>";
                                        }
                                        echo "<td sort-number='" . $type->object_count() . "'>";
                                            echo $type->object_count() . " (";
                                            echo "<a href='" . $search_url . "?in=object&po0=0&k0=horizon_id&e0=eq&v0=" . $horizon->id() . "&pf0=0&j0=and&po1=0&k1=cat_abbr&e1=eq&v1=" . $category->abbreviation() . "&pf1=0&j1=and&po2=0&k2=typ_code&e2=". $equal ."&v2=" . $code . "&pf2=0&j2=none' target='_blank'>" . thesaurus('see') . "</a>";
                                            echo ")";
                                        echo "</td>";
                                    echo "</tr>";
                                    if ($hor_advanced) {
                                        $col_type_num++;
                                    }
                                    $rest -= $type->object_count();
                                }
                            // If there is no category
                            } else {
                                if (!$hor_advanced) {
                                    // $types = Type::find_woc(0, ['category_link'=>'IS NULL', 'phase.horizon'=>$horizon->id()]);
                                    $cat_abbr = array_map(function($cat) {
                                        return $category->abbreviation();
                                    }, $categories);
                                    $types = Type::find_woc(0, ['category_abbr'=>[0, $cat_abbr], 'phase.horizon'=>$horizon->id()]);
                                    foreach ($types as $type) {
                                        echo "<tr>";
                                            if (!$type->id()) {
                                                $sorting = '~~'; $hyperlink = ucfirst(thesaurus('no link type')); $code='0'; $equal = 'isnull';
                                            } else {
                                                $sorting = $code = $type->code(); $hyperlink = $type->hyperlink(); $equal = 'eq';
                                            }
                                            echo "<td sort-text='~~'>" . ucfirst(thesaurus('no link category')) . "</td>";
                                            echo "<td sort-text='" . $sorting . "'>" . $hyperlink . "</td>";
                                            echo "<td sort-number='" . $type->object_count() . "'>";
                                                echo $type->object_count() . " (";
                                                echo "<a href='" . $search_url . "?in=object&po0=0&k0=horizon_id&e0=eq&v0=" . $horizon->id() . "&pf0=0&j0=and&po1=0&k1=cat_abbr&e1=isnull&v1=0&pf1=0&j1=and&po2=0&k2=typ_code&e2=". $equal ."&v2=" . $code . "&pf2=0&j2=none' target='_blank'>" . thesaurus('see') . "</a>";
                                                echo ")";
                                            echo "</td>";
                                        echo "</tr>";
                                        $rest -= $type->object_count();
                                    }
                                }
                            }
                        }
                        // Without type neither category
                        if ($rest > 0) {
                            echo "<tr><td sort-text='~~'>" . ucfirst(thesaurus('no link category')) . "</td>";
                            echo "<td sort-text='~~'>" . ucfirst(thesaurus('no link type')) . "</td>";
                            if ($hor_advanced) {
                                echo "<td sort-text='~~'>" . ucfirst(th_h_a_link_type(false)) . "</td>";
                            }
                            echo "<td sort-number='" . $rest . "'>" . $rest;
                                echo " (<a href='" . $search_url . "?in=object&po0=0&k0=horizon_id&e0=eq&v0=" . $horizon->id() . "&pf0=0&j0=and&po1=0&k1=cat_abbr&e1=isnull&v1=0&pf1=0&j1=none' target='_blank'>" . thesaurus('see') . "</a>)";
                            echo "</td>";
                            echo "</tr>";
                        }

                        if ($hor_advanced) {
                            // Types not addressed
                            if ($horizon->contributor_rights()) {
                                $linked_types = Type::linked('horizon', 'type', $horizon->id());
                                foreach ($linked_types as $t) {
                                    if (!in_array($t->id(), $id_types)) {
                                        $linked_categories = Category::linked('typology', 'category', $t->typology()->id());
                                        $sort_cat = "";
                                        $categories = "";
                                        foreach ($linked_categories as $c) {
                                            $sort_cat .= $c->code() . " ";
                                            if (strlen($categories) > 0) {
                                                $categories .= ", ";
                                            }
                                            $categories .= $c->codename();
                                        }
                                        if (strlen($sort_cat) === 0) {
                                            $sort_cat = '~~~';
                                        }
                                        $link_type = $t->is_linked($horizon->id());
                                        echo "<tr style='background-color:red'>";
                                        echo "<td sort-text='" . $sort_cat . "'>" . $categories . "</td>";
                                        echo "<td sort-text='" . $t->code() . "'>" . $t->hyperlink() . "</td>";
                                        echo "<td id='cell_link_type" . $col_type_num . "' sort-text='" . th_h_a_link_type($link_type) . "'>"
                                            . ucfirst(th_h_a_link_type($link_type))
                                            . " (<a href='#' class='edit-link' data-row='" . $col_type_num . "' data-type_id='" . $t->id() . "'>" . ucfirst(thesaurus('modify')) . "</a>)"
                                            . "</td>";
                                        echo "<td sort-number='0'>" . ucfirst(thesaurus('no object')) . "</td>";
                                        echo "</tr>";
                                    }
                                }
                            }
                        }
                        
                        echo "</tbody></table>";
                    }

                echo "</div>";

                // Illustrations
                echo "<div id='div_4' style='display:none'><br>";

                    echo h(3, ucfirst(thesaurus('pictures')));
                    require("../sites/pictures.php");
                
                echo "</div>";

                // Inventory
                if (false /*$show == 'objects'*/) {
                    echo "<div id='div_5' style='display:block'><br>";
                } else {
                    echo "<div id='div_5' style='display:none'><br>";
                }

                //if ($objects_count < MAX_LOADED_OBJECTS) {
                    // Show results
                    $cols = ['site', 'phase', 'context', 'horizon', 'number', 'category', 'function', 'type', 'fabric'];
                    $countings = [];
                    /* Countings added depending of the users */
                    if (isset($_SESSION['user'])) {
                        $countings_obj = Counting::linked('counting', 'user', $_SESSION['user']->id(), true);
                    } else {
                        $countings_obj = Counting::find_all();
                    }
                    foreach ($countings_obj as $count) {
                        $countings[] = $count->id();
                    }
                    if (in_array(1, $countings)) { array_push($cols, 'n_rim', 'n_bottom', 'n_handle', 'n_wall'); }
                    if (in_array(2, $countings)) { array_push($cols, 'n_mni'); }
                    if (in_array(3, $countings)) { array_push($cols, 'n_sherd'); }
                    array_push($cols, "diameter", "stamp", "comment", "picture");
                    // Ajout de la liste des colonnes dans les paramètres
                    $params_objects['cols'] = $cols;
                    require("../sites/table_inventory.php");
                //} else {
                //    echo "<div class='alert alert-warning'>" . ucfirst(thesaurus('too much objects-hyperlink') . ' ' . "<a href='" . create_url(['search', 'results']) . "?in=object&po0=0&k0=horizon_id&e0=eq&v0=" . $horizon->id() . "&pf0=0&j0=none' target='_blank' class='alert-link'>" . thesaurus('click here') . '</a>.' ) . "</div>";
                //}
                
                echo "</div>";

// End div from layout
        echo "</div>";

        // Map header
        echo "<div id='map_header' class='maindiv container' style='display:none'>";
            echo h(3, ucfirst(thesaurus('distribution of the horizon')));
        echo "</div>";

        // Map and contents + script
        $sites = $phases;
        $typemarker = 'phase';
        require("../sites/map.php");
        echo "<div>";

        echo "<div class='maindiv container'>";

        // Commentaires liés
        if (PROJECT->setting_notes()) {
            $comment_class = 'Horizon';
            $comment_id = $horizon->id();
            require_once('../users/comments.php');
        }

        $horizon->cite_page();
        echo "</div>";
            } ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
<script>
    // Cache la carte une fois la page chargée (sinon c'est la mouise)
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('map')) {
        document.getElementById('map').style.display = 'none';
    }
})
<?php if ($hor_advanced): ?>

    // Fonction d'édition du contenu de la colonne de type de lien avec le type
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('edit-link')) {
        e.preventDefault();
        let row = e.target.dataset.row;
        let typeId = e.target.dataset.type_id;
        let cell= document.getElementById('cell_link_type' + row);

        // Récupérer le libellé actuel
        let currentText = cell.getAttribute('sort-text');

        // Liste des valeurs
        <?php $list_type_links = [];
        foreach (LINKS_HOR_TYPE as $link_key=>$link_value) {
            $list_type_links[$link_key] = ucfirst(th_h_a_link_type($link_key));
        }
        ?>
        let listTypeLinks = <?php echo json_encode($list_type_links); ?>;

        // Construire les éléments
        let select = document.createElement('select');
        select.className = 'form-select form-select-sm';
        
        Object.entries(listTypeLinks).forEach(([key, label]) => {
            let option = document.createElement('option');
            option.value = key;
            option.textContent = label;
            if (label.toLowerCase().trim() === currentText.toLowerCase().trim()) {
                option.selected = true;
            }
            select.appendChild(option);
        });

        // Boutons
        let validateBtn = document.createElement('button');
        validateBtn.className = 'btn btn-success btn-sm';
        validateBtn.innerHTML = "<i class='bi bi-check'></i>";

        let cancelBtn = document.createElement('button');
        cancelBtn.className = 'btn btn-secondary btn-sm';
        cancelBtn.innerHTML = "<i class='bi bi-x'></i>";

        // Groupe de boutons
        let btnGroup = document.createElement('div');
        btnGroup.className = 'btn-group ms-2';
        btnGroup.appendChild(validateBtn);
        btnGroup.appendChild(cancelBtn);

        // Coteneur flex
        let container = document.createElement('div');
        container.className = 'd-flex align-items-center';
        container.appendChild(select);
        container.appendChild(btnGroup);

        // Remplacer le contenu de la cellule
        cell.innerHTML = '';
        cell.appendChild(container);

        // Action du bouton valider
        validateBtn.addEventListener('click', async function() {
            let selectedKey = select.value;
            let selectedLabel = listTypeLinks[selectedKey];

            // Paramètre pour fonction AJAX
            let params = {
                'function' : 'change_link_horizon_type',
                'changeTo' : selectedKey,
                'typeId'   : typeId,
                'horizonId': <?php echo $horizon->id(); ?>
                project_id: <?php if (PROJECT) { echo PROJECT->id(); } else { echo 0; } ?>
            };

            // Remplacement dans la base de données
            const result = await fetch('/static/ajax/horizons_advanced.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest' },
                body: JSON.stringify(params)
            })

            if (!result.ok) {
                console.error("Erreur serveur", result.status);
                return;
            }

            // Remplacer la valeur dans la cellule
            cell.innerHTML = selectedLabel + " (<a href='#' class='edit-link' data-row='" + row + "' data-type_id='" + typeId + "'><?php echo ucfirst(thesaurus('modify')); ?></a>)";
            cell.setAttribute('sort-text', selectedLabel.toLowerCase());
        });

        // Action du bouton abandonner
        cancelBtn.addEventListener('click', function() {
            cell.innerHTML = currentText.charAt(0).toUpperCase() + currentText.slice(1) + " (<a href='#' class='edit-link' data-row='" + row + "' data-type_id='" + typeId + "'><?php echo ucfirst(thesaurus('modify')); ?></a>)";
        });
    };

})

<?php endif ?>
</script>


    </body>
</html>