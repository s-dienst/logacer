<?php
    /* Récupère les données du groupe de pâtes */
    $error_message = false;
    $fabric = Fabric::find_by_code(dec_sl(secure(urldecode(urldecode($params['codefabric'])))));

    // Prépare l'url de recherche (utilisée à différents endroits)
    if (ISOLATED_WEBSITE) {
        $search_url = create_url(['search', 'results']);
    } elseif (PROJECT) {
        $search_url = create_url([PROJECT->code(), 'search', 'results']);
    } else {
        $search_url = create_url(['logacer', 'search', 'results']);
    }

    if ($fabric) {
        if (!$fabric->public() && !fabric->contributor_rights()) {
            $error_message = 'non_public_fabric';
        } elseif (PROJECT && !in_array($fabric, Fabric::linked_with_project())) {
            $error_message = 'no_fabric';
        } elseif (!PROJECT && $fabric->project()) {
            $error_message = 'not_global_fabric';
        } else {
            /* Initialise le titre */
            $title = $fabric->codename();

            if (PROJECT) {
                $conditions = ["fabric_code"=>$fabric->code(), "site.project"=>PROJECT->id()];
                $objects_count = ObjectTable::count_public(["fabric_code"=>$fabric->code(), "site.project"=>PROJECT->id()]);
                $params_objects = [
                    'mode'          => 'find_public',
                    'conditions'    => $conditions,
                    'left_join'     => false,
                    'binds'         => [],
                    'ordering'      => [],
                    'conditions_ns' => false,
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
                $conditions = ["fabric_code"=>$fabric->code()];
                $objects_count = 0;
                $params_objects = [
                    'mode'          => 'find_public',
                    'conditions'    => $conditions,
                    'left_join'     => false,
                    'binds'         => [],
                    'ordering'      => [],
                    'conditions_ns' => false,
                    'limit'         => ROWS_PER_PAGE,
                    'total'         => $objects_count
                ];
                $objects = [];
                $params_objects['offset'] = 0;
                $params_objects['loaded'] = 0;
            }
        }
    } else {
        $fabric = false;
        $error_message = 'no_fabric';
    }

    if ($_POST && !$error_message) {

        $fabric->check_post();

        $fabric->manage_bibliography('back');
        $fabric->manage_contributors('back');
        // Gérer la suppression
        if (isset($_POST['typeaction'])) {
            if ($_POST['typeaction'] === 'delete') {
                $child_fabrics = Fabric::find_by_property('superfabric', $fabric->id());
                foreach ($child_fabrics as $child_fabric) {
                    DatabaseObject::connection()->query('UPDATE fabric SET superfabric = NULL WHERE id = ' . $child_fabric->id() . ' LIMIT 1');
                }
                $fabric->delete($fabric->url('parent'));
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

                // Buttons for the fabric
                $fabric->buttons_contrib();

                // Informations about the fabric
                $fabric->codename('title');
                if ($fabric->superfabric()) {
                    echo p(ucfirst(thesaurus('superfabric')) . thesaurus(':') . ' ' . $fabric->superfabric()->hyperlink() . ".");
                }
                
                $fabric->owner();

                echo p(ucfirst(thesaurus('number of objects')) . thesaurus(':') . ' ' . $objects_count . '.');

                $fabric->display_errors();

                    // Show and manage contributors
                    $fabric->manage_contributors('front');

                if (PROJECT && !$fabric->project()) {
                    $fabric->main_page_project();
                }

                // Navigation tabs
                //if ($show === "objects") { $active = 5; } else { $active = 1; }
                if (PROJECT) {
                    /* temporary */ $active = 1;
                    if (PROJECT->setting_litterature()) {
                        echo nav_tabs(['distribution', 'description', 'pictures', 'types', 'inventory', 'correspondances'], $active, 1);
                    } else {
                        echo nav_tabs(['distribution', 'description', 'pictures', 'types', 'inventory'], $active, 1);
                    }

                    // Informations about the fabric
                    echo "<div id='div_2' style='display:none'><br>";
                } else {
                    echo "<div id='div_2' style='display:block'><br>";
                }


                    // Display subfabric
                    $subfabrics = $fabric->subfabrics();
                    if (count($subfabrics) > 0 || $fabric->contributor_rights()) {
                        echo h(3, ucfirst(thesaurus('the subfabrics'))) . "<ul>";
                        foreach ($subfabrics as $subfabric) {
                            echo li($subfabric->hyperlink());
                        }
                        if ($fabric->contributor_rights()) {
                            echo li("<a class ='btn btn-secondary btn-sm' href='" . $fabric->url('new_subfabric') . "'>" . ucfirst(thesaurus("add")) . ' ' . thesaurus("a subfabric") . "</a>");
                        }
                        echo "</ul>";
                    }

                    $fabric->description('display');
                    // Dating
                    $fabric->description('display', 'origin');

                    // Show and manage bibliography
                    echo h(3, ucfirst(thesaurus("bibliography")));
                    $fabric->manage_bibliography('front');
                
                echo "</div>";

            if (PROJECT) {
                // Illustrations
                echo "<div id='div_3' style='display:none'><br>";

                    echo h(3, ucfirst(thesaurus('pictures')));

                    require("../sites/pictures.php");
                
                echo "</div>";

                // Types
                echo "<div id='div_4' style='display:none'><br>";
                    // $types = Type::find_woc(0, ['fabric_link'=>$fabric->id()]);
                    $types = Type::find_woc(0, ['fabric_code'=>$fabric->code(), 'site.project'=>PROJECT->id()]);

                    echo h(3, ucfirst(thesaurus('types for the fabric')));

                    echo p(ucfirst(thesaurus('can sort by clicking headers')));
                    // Filtres
                    filter_box(['type', 'number_of_objects'], 'type_table');
                    echo "<table class='table' id='type_table'><thead>";
                        // Header
                        table_headers(['type', 'number_of_objects'], 'type_table');
                    echo "</thead><tbody>";
                    foreach ($types as $type) {
                        echo "<tr>";
                            if (!$type->id()) {
                                $sorting = '~~'; $hyperlink = ucfirst(thesaurus('no link type')); $code='0'; $equal = 'isnull';
                            } else {
                                $sorting = $code = $type->code(); $hyperlink = $type->hyperlink(); $equal = 'eq';
                            }
                            
                            echo "<td sort-text='" . $sorting . "'>" . $hyperlink . "</td>";
                            echo "<td sort-number='" . $type->object_count() . "'>";
                                echo $type->object_count() . " (";
                                echo "<a href='" . $search_url . "?in=object&po0=0&k0=fab_code&e0=eq&v0=" . $fabric->code() . "&pf0=0&j0=and&po1=0&k1=typ_code&e1=". $equal ."&v1=" . $code . "&pf1=0&j1=none' target='_blank'>" . thesaurus('see') . "</a>";
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
                //    echo "<div class='alert alert-warning'>" . ucfirst(thesaurus('too much objects-hyperlink') . ' ' . "<a href='" . create_url(['search', 'results']) . "?in=object&po0=0&k0=fab_code&e0=eq&v0=" . $fabric->code() . "&pf0=0&j0=none' target='_blank' class='alert-link'>" . thesaurus('click here') . '</a>.' ) . "</div>";
                //}
                
                echo "</div>";

                if (PROJECT->setting_litterature()) {
                    // Correspondances
                    echo "<div id='div_6' style='display:none'><br>";

                    $request = DatabaseObject::$connexion->query("SELECT object.fabric_litt AS fabric_litt, COUNT(object.id) AS object_count FROM object 
                        LEFT JOIN context ON object.related_context = context.id
                        LEFT JOIN phase ON context.related_phase = phase.id
                        LEFT JOIN site ON phase.related_site = site.id
                        WHERE object.fabric_code = '" . $fabric->code() . "' AND site.project = '" . PROJECT->id() . "' AND object.fabric_litt IS NOT NULL GROUP BY object.fabric_litt ORDER BY object.fabric_litt");
                    $loc_fabrics = $request->fetchAll();

                    echo h(3, ucfirst(thesaurus('origin names')));

                    echo p(ucfirst(thesaurus('can sort by clicking headers')));
                    echo "<table class='table' id='fabric_table'><thead>";
                        // Header
                        table_headers(['fabric_litt', 'number_of_objects'], 'fabric_table');
                    echo "</thead><tbody>";
                    foreach ($loc_fabrics as $loc_fabric) {
                        echo "<tr>";                        
                            echo "<td sort-text='" . $loc_fabric['fabric_litt'] . "'>" . $loc_fabric['fabric_litt'] . "</td>";
                            echo "<td sort-number='" . $loc_fabric['object_count'] . "'>";
                                echo $loc_fabric['object_count'] . " (";
                                echo "<a href='" . $search_url . "?in=object&po0=0&k0=fabric_code&e0=eq&v0=" . $fabric->code() . "&pf0=0&j0=and&po1=0&k1=fabric_litt&e1=eq&v1=" . $loc_fabric['fabric_litt'] . "&pf1=0&j1=none' target='_blank'>" . thesaurus('see') . "</a>";
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
                echo h(3, ucfirst(thesaurus('distribution of the fabric')));
            
                // Button to change between map and tab
                echo "<div class='btn-group'>
                    <button class='btn btn-outline-secondary active' id='show_map'>" . ucfirst(thesaurus('map')) . "</button>
                    <button class='btn btn-outline-secondary' id='show_list'>" . ucfirst(thesaurus('list of the sites')) . "</button>
                </div>";

            echo "</div>";
            
            // Map and contents + script
            // $sites = Site::find_woc(0, ['fabric_link'=>$fabric->id()]);
            $sites = Site::find_woc(0, ['fabric_code'=>$fabric->code(), 'site.project'=>PROJECT->id()]);
            $map_other_data = ['url_begin'=>"<a href='" . $search_url . "?in=object&po0=0&k0=fab_code&e0=eq&v0=" . $fabric->code() . "&pf0=0&j0=and&po1=0&k1=site_id&e1=eq&v1=", 'url_end'=>"&pf1=0&j1=none' target='_blank'>" . thesaurus('see') . "</a>"];
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
                            echo "<a href='" . $search_url . "?in=object&po0=0&k0=fab_code&e0=eq&v0=" . $fabric->code() . "&pf0=0&j0=and&po1=0&k1=site_id&e1=eq&v1=" . $site->id() . "&pf1=0&j1=none' target='_blank'>" . thesaurus('see') . "</a>";
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
            $comment_class = 'Fabric';
            $comment_id = $fabric->id();
            require_once('../users/comments.php');
        }

        $fabric->cite_page();
        echo "</div>";
        } ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>

    </body>
</html>