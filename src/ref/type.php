<?php
    /* Récupère les données de la typologie */
    $error_message = false;
    $typology = Typology::find_by_id($params['idtypology']);

    // Prépare l'url de recherche (utilisée à différents endroits)
    if (ISOLATED_WEBSITE) {
        $search_url = create_url(['search', 'results']);
    } elseif (PROJECT) {
        $search_url = create_url([PROJECT->code(), 'search', 'results']);
    } else {
        $search_url = create_url(['logacer', 'search', 'results']);
    }

    if ($typology) {
        if (!$typology->public() && !$typology->contributor_rights()) {
            $error_message = 'non_public_typology';
        } elseif (PROJECT && !in_array($typology, Typology::linked_with_project())) {
            $error_message = 'no_typology';
        } elseif (!PROJECT && $typology->project()) {
            $error_message = 'not_global_typology';
        } else {
            /* Récupère les données du type */
            $type = Type::find_by_code(dec_sl($params['codetype']));

            if ($type && $type->typology() == $typology) {
                /* Initialise le titre */
                $title = $type->codename();

                $categories = Category::linked('typology', 'category', $typology->id());
                $conditions_ns = "";
                foreach ($categories as $category) {
                    if (strlen($conditions_ns) > 0) {
                        $conditions_ns .= " OR ";
                    }
                    $conditions_ns .= "category_abbr = '" . $category->abbreviation() . "'";
                }
                if (strlen($conditions_ns) > 0) {
                    $conditions_ns = [$conditions_ns];
                } else {
                    $conditions_ns = false;
                }
                if (PROJECT) {
                    $conditions = ['type_name'=>html_entity_decode($type->name()), "site.project"=>PROJECT->id()];
                    $objects_count = ObjectTable::count_public(['type_name'=>html_entity_decode($type->name()), "site.project"=>PROJECT->id()], false, [], [], $conditions_ns);
                    $params_objects = [
                        'mode'          => 'find_public',
                        'conditions'    => $conditions,
                        'left_join'     => false,
                        'binds'         => [],
                        'ordering'      => [],
                        'conditions_ns' => $conditions_ns,
                        'limit'         => ROWS_PER_PAGE,
                        'total'         => $objects_count
                    ];
                    $objects = ObjectTable::find_public($params_objects['conditions'], $params_objects['left_join'], $params_objects['binds'], $params_objects['ordering'], $params_objects['conditions_ns'], $params_objects['limit'], 0);
                    if ($objects) {
                        $params_objects['offset'] = end($objects)->id();
                        $params_objects['loaded'] = count($objects);
                    } else {
                        $params_objects['offset'] = 0;
                        $params_objects['loaded'] = 0;
                    }
                } else {
                    $conditions = ['type_name'=>html_entity_decode($type->name())];
                    $objects_count = 0;
                    $params_objects = [
                        'mode'          => 'find_public',
                        'conditions'    => $conditions,
                        'left_join'     => false,
                        'binds'         => [],
                        'ordering'      => [],
                        'conditions_ns' => $conditions_ns,
                        'limit'         => ROWS_PER_PAGE,
                        'total'         => $objects_count
                    ];
                    $objects = [];
                    $params_objects['offset'] = 0;
                    $params_objects['loaded'] = 0;
                }


            } else {
                $error_message = 'no_type';
            }
        }
    } else {
        $type = false;
        $error_message = 'no_typology';
    }

    if ($_POST && !$error_message) {

        $type->check_post();

        $type->manage_bibliography('back');
        // Gérer la suppression
        if (isset($_POST['typeaction'])) {
            if ($_POST['typeaction'] === 'delete') {
                $child_types = Type::find_by_property('supertype', $type->id());
                foreach ($child_types as $child_type) {
                    DatabaseObject::connection()->query('UPDATE type SET supertype = NULL WHERE id = ' . $child_type->id() . ' LIMIT 1');
                }
                $type->delete($type->url('parent'));
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
                $type->buttons_contrib();

                // Informations about the horizon
                $type->codename('title');
                if ($type->supertype()) {
                    echo p(ucfirst(thesaurus('typology')) . thesaurus(':') . ' ' . $typology->hyperlink() . ". " . ucfirst(thesaurus('supertype')) . thesaurus(':') . ' ' . $type->supertype()->hyperlink() . ".");
                } else {
                    echo p(ucfirst(thesaurus('typology')) . thesaurus(':') . ' ' . $typology->hyperlink() . ".");
                }
                
                $typology->owner(); $type->owner();

                echo p(ucfirst(thesaurus('number of objects')) . thesaurus(':') . ' ' . $objects_count . '.');

                $type->display_errors();

                if (PROJECT && !$typology->project()) {
                    $type->main_page_project();
                }
                // Navigation tabs
                //if ($show === "objects") { $active = 5; } else { $active = 1; }
                if (PROJECT) {
                    /* temporary */ $active = 1;
                    if (PROJECT->setting_litterature) {
                        echo nav_tabs(['distribution', 'description', 'pictures', 'fabrics', 'inventory', 'correspondances'], $active, 1);
                    } else {
                        echo nav_tabs(['distribution', 'description', 'pictures', 'fabrics', 'inventory'], $active, 1);
                    }

                    // Informations about the type
                    echo "<div id='div_2' style='display:none'><br>";
                } else {
                    echo "<div id='div_2' style='display:block'><br>";
                }


                    // Display subtypes
                    $subtypes = $type->subtypes();
                    if (count($subtypes) > 0 || $type->contributor_rights()) {
                        echo h(3, ucfirst(thesaurus('the subtypes'))) . "<ul>";
                        foreach ($subtypes as $subtype) {
                            echo li($subtype->hyperlink());
                        }
                        if ($type->contributor_rights()) {
                            echo li("<a class ='btn btn-secondary btn-sm' href='" . $type->url('new_subtype') . "'>" . ucfirst(thesaurus("add")) . ' ' . thesaurus("a subtype") . "</a>");
                        }
                        echo "</ul>";
                    }

                    $type->description('display');
                    // Dating
                    $type->description('display', 'dating');

                    // Show and manage bibliography
                    echo h(3, ucfirst(thesaurus("bibliography")));
                    $type->manage_bibliography('front');
                
                echo "</div>";

            if (PROJECT) {
                // Illustrations
                echo "<div id='div_3' style='display:none'><br>";

                    echo h(3, ucfirst(thesaurus('pictures')));

                    require("../sites/pictures.php");
                
                echo "</div>";

                // Fabrics
                echo "<div id='div_4' style='display:none'><br>";
                    //$fabrics = Fabric::find_woc(0, ['type_link'=>$type->id()]);
                    $fabrics = Fabric::find_woc(0, ['type_name'=>html_entity_decode($type->name()), 'site.project'=>PROJECT->id()], false, [], $conditions_ns);

                    echo h(3, ucfirst(thesaurus('fabrics for the type')));

                    echo p(ucfirst(thesaurus('can sort by clicking headers')));
                    // Filtres
                    filter_box(['fabric', 'number_of_objects'], 'fabric_table', false, 150);
                    echo "<table class='table' id='fabric_table'><thead>";
                        // Header
                        table_headers(['fabric', 'number_of_objects'], 'fabric_table');
                    echo "</thead><tbody>";
                    foreach ($fabrics as $fabric) {
                        echo "<tr>";
                            if (!$fabric->id()) {
                                $sorting = '~~'; $hyperlink = ucfirst(thesaurus('no link fabric')); $code='0'; $equal = 'isnull';
                            } else {
                                $sorting = $code = $fabric->code(); $hyperlink = $fabric->hyperlink(); $equal = 'eq';
                            }
                            
                            echo "<td sort-text='" . $sorting . "'>" . $hyperlink . "</td>";
                            echo "<td sort-number='" . $fabric->object_count() . "'>";
                                echo $fabric->object_count() . " (";
                                echo "<a href='" . $search_url . "?in=object&po0=0&k0=typ_code&e0=eq&v0=" . $type->code() . "&pf0=0&j0=and&po1=0&k1=fab_code&e1=". $equal ."&v1=" . $code . "&pf1=0&j1=none' target='_blank'>" . thesaurus('see') . "</a>";
                                echo ")";
                            echo "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody></table>";                
                echo "</div>";

                // Inventory
                if (false /*$show == 'objects'*/) {
                    echo "<div id='div_5' style='display:block'><br>";
                } else {
                    echo "<div id='div_5' style='display:none'><br>";
                }

                //if (count($objects) < MAX_LOADED_OBJECTS) {
                    // Show results
                    if (PROJECT->setting_horizon()) {
                        $cols = ['site', 'phase', 'context', 'horizon', 'number', 'category', 'function', 'type', 'fabric'];
                    } else {
                        $cols = ['site', 'phase', 'context', 'number', 'category', 'function', 'type', 'fabric'];
                    }
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
                //    echo "<div class='alert alert-warning'>" . ucfirst(thesaurus('too much objects-hyperlink') . ' ' . "<a href='" . create_url(['search', 'results']) . "?in=object&po0=0&k0=typ_code&e0=eq&v0=" . $type->code() . "&pf0=0&j0=none' target='_blank' class='alert-link'>" . thesaurus('click here') . '</a>.' ) . "</div>";
                //}
                
                echo "</div>";

                // Correspondances
                if (PROJECT->setting_litterature()) {
                    echo "<div id='div_6' style='display:none'><br>";
                    if ($conditions_ns) {
                        $add_request = " AND (" . $conditions_ns[0] . ")";
                    } else {
                        $add_request = "";
                    }
                    $request = DatabaseObject::$connexion->prepare("SELECT object.type_litt as type_litt, COUNT(object.id) AS object_count FROM object 
                        LEFT JOIN context ON object.related_context = context.id
                        LEFT JOIN phase ON context.related_phase = phase.id
                        LEFT JOIN site ON phase.related_site = site.id
                        WHERE type_name = :typename AND site.project = :idproject AND type_litt IS NOT NULL" . $add_request . " GROUP BY type_litt ORDER BY type_litt");
                    $type_codename = $type->codename();
                    $project_id = PROJECT->id();
                    $request->bindParam(':typename', $type_codename);
                    $request->bindParam(':idproject', $project_id);
                    $request->execute();
                    $loc_types = $request->fetchAll();

                    echo h(3, ucfirst(thesaurus('origin names')));

                    echo p(ucfirst(thesaurus('can sort by clicking headers')));
                    echo "<table class='table' id='type_table'><thead>";
                        // Header
                        table_headers(['type_litt', 'number_of_objects'], 'type_table');
                    echo "</thead><tbody>";
                    foreach ($loc_types as $loc_type) {
                        echo "<tr>";                        
                            echo "<td sort-text='" . $loc_type['type_litt'] . "'>" . $loc_type['type_litt'] . "</td>";
                            echo "<td sort-number='" . $loc_type['object_count'] . "'>";
                                echo $loc_type['object_count'] . " (";

                                echo "<a href='" . $search_url . "?in=object&po0=0&k0=type_code&e0=eq&v0=" . $type->code() . "&pf0=0&j0=and&po1=0&k1=type_litt&e1=eq&v1=" . $loc_type['type_litt'] . "&pf1=0&j1=none' target='_blank'>" . thesaurus('see') . "</a>";
                                echo ")";
                            echo "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody></table>";

                    echo "</div>";
                }

                

// End div from layout
        echo "</div>";

            // Map header
            echo "<div id='map_header' class='maindiv container' style='display:block'>";
                echo h(3, ucfirst(thesaurus('distribution of the type')));
            
                // Button to change between map and tab
                echo "<div class='btn-group'>
                    <button class='btn btn-outline-secondary active' id='show_map'>" . ucfirst(thesaurus('map')) . "</button>
                    <button class='btn btn-outline-secondary' id='show_list'>" . ucfirst(thesaurus('list of the sites')) . "</button>
                </div>";

            echo "</div>";
            
            // Map and contents + script
            // $sites = Site::find_woc(0, ['type_link'=>$type->id()]);
            $sites = Site::find_woc(0, ['type_name'=>html_entity_decode($type->name()), 'site.project'=>PROJECT->id()], false, [], $conditions_ns);
            $map_other_data = ['url_begin'=>"<a href='" . $search_url . "?in=object&po0=0&k0=typ_code&e0=eq&v0=" . $type->code() . "&pf0=0&j0=and&po1=0&k1=site_id&e1=eq&v1=", 'url_end'=>"&pf1=0&j1=none' target='_blank'>" . thesaurus('see') . "</a>"];
            require("../sites/map.php");
            
            // Table
            echo "<div id='list' class='maindiv container' style='display:none'>";

                echo p(ucfirst(thesaurus('can sort by clicking headers')));
                // Filtres
                filter_box(['site', 'number_of_objects'], 'site_table', false, 150);
                echo "<table class='table' id='site_table'><thead>";
                    // Header
                    table_headers(['site', 'number_of_objects'], 'site_table');
                echo "</thead><tbody>";
                foreach ($sites as $site) {
                    echo "<tr>";
                        echo "<td sort-text='" . $site->code() . "'>" . $site->hyperlink() . "</td>";
                        echo "<td sort-number='" . $site->object_count() . "'>";
                            echo $site->object_count() . " (";
                            echo "<a href='" . $search_url . "?in=object&po0=0&k0=typ_code&e0=eq&v0=" . $type->code() . "&pf0=0&j0=and&po1=0&k1=site_id&e1=eq&v1=" . $site->id() . "&pf1=0&j1=none' target='_blank'>" . thesaurus('see') . "</a>";
                            echo ")";
                        echo "</td>";
                    echo "</tr>";
                }
                echo "</tbody></table>";                
            echo "</div>
        <div>";
        echo "<div class='maindiv container'>";
    }

        // Commentaires liés
        if (PROJECT->setting_notes()) {
            $comment_class = 'Type';
            $comment_id = $type->id();
            require_once('../users/comments.php');
        }

        $type->cite_page();
        echo "</div>";
        } ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>

    </body>
</html>