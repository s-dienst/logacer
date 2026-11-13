<?php
    /* Récupère les données du groupe de pâtes */
    $error_message = false;
    $fabric = dec_sl(secure(urldecode(urldecode($params['fabric']))));

    // Prépare l'url de recherche (utilisée à différents endroits)
    if (ISOLATED_WEBSITE) {
        $search_url = create_url(['search', 'results']);
    } elseif (PROJECT) {
        $search_url = create_url([PROJECT->code(), 'search', 'results']);
    }

    if ($fabric && PROJECT) {
        /* Initialise le titre */
        $title = ucfirst(thesaurus('unreferenced fabric')) . thesaurus(':') . " " . $fabric;

        $conditions = ["fabric_code"=>$fabric, "site.project"=>PROJECT->id()]
        $objects_count = ObjectTable::count_public(["fabric_code"=>$fabric, 'site.project'=>PROJECT->id()]);
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
        $fabric = false;
        if (!PROJECT) {
            $error_message = 'no_project';
        } else {
            $error_message = 'no_fabric';
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

                // Informations about the fabric
                echo h(2, $title);

                echo p(ucfirst(thesaurus('number of objects')) . thesaurus(':') . ' ' . $objects_count . '.');

                // Navigation tabs
                $active = 1;
                if (PROJECT && PROJECT->setting_litterature()) {
                    echo nav_tabs(['distribution', 'pictures', 'types', 'inventory', 'correspondances'], $active, 1);
                } else {
                    echo nav_tabs(['distribution', 'pictures', 'types', 'inventory'], $active, 1);
                }

                // Illustrations
                echo "<div id='div_2' style='display:none'><br>";

                    echo h(3, ucfirst(thesaurus('pictures')));

                    require("../sites/pictures.php");
                
                echo "</div>";

                // Types
                echo "<div id='div_3' style='display:none'><br>";
                    $types = Type::find_woc(0, ['fabric_code'=>$fabric, 'site.project'=>PROJECT->id()]);

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
                                echo "<a href='" . $search_url . "?in=object&po0=0&k0=fab_code&e0=eq&v0=" . $fabric . "&pf0=0&j0=and&po1=0&k1=typ_code&e1=". $equal ."&v1=" . $code . "&pf1=0&j1=none' target='_blank'>" . thesaurus('see') . "</a>";
                                echo ")";
                            echo "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody></table>";                
                echo "</div>";

                // Inventory
                echo "<div id='div_4' style='display:none'><br>";

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
                
                echo "</div>";

                if (PROJECT->setting_litterature()) {
                    // Correspondances
                    echo "<div id='div_5' style='display:none'><br>";

                    $request = DatabaseObject::$connexion->query("SELECT object.fabric_litt as fabric_litt, COUNT(object.id) AS object_count FROM object 
                        LEFT JOIN context ON object.related_context = context.id
                        LEFT JOIN phase ON context.related_phase = phase.id
                        LEFT JOIN site ON phase.related_site = site.id
                        WHERE fabric_code = '" . $fabric . "' AND site.project = " . PROJECT->id() . " AND fabric_litt IS NOT NULL GROUP BY fabric_litt ORDER BY fabric_litt");
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
                                echo "<a href='" . $search_url . "?in=object&po0=0&k0=fabric_code&e0=eq&v0=" . $fabric . "&pf0=0&j0=and&po1=0&k1=fabric_litt&e1=eq&v1=" . $loc_fabric['fabric_litt'] . "&pf1=0&j1=none' target='_blank'>" . thesaurus('see') . "</a>";
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
            $sites = Site::find_woc(0, ['fabric_code'=>$fabric, 'site.project'=>PROJECT->id()]);
            $map_other_data = ['url_begin'=>"<a href='" . $search_url . "?in=object&po0=0&k0=fab_code&e0=eq&v0=" . $fabric . "&pf0=0&j0=and&po1=0&k1=site_id&e1=eq&v1=", 'url_end'=>"&pf1=0&j1=none' target='_blank'>" . thesaurus('see') . "</a>"];
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
                            echo "<a href='" . $search_url . "?in=object&po0=0&k0=fab_code&e0=eq&v0=" . $fabric . "&pf0=0&j0=and&po1=0&k1=site_id&e1=eq&v1=" . $site->id() . "&pf1=0&j1=none' target='_blank'>" . thesaurus('see') . "</a>";
                            echo ")";
                        echo "</td>";
                    echo "</tr>";
                }
                echo "</tbody></table>";                
            echo "</div>
        <div>";
        echo "<div class='maindiv container'>";
        echo "</div>";
        } ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>

    </body>
</html>