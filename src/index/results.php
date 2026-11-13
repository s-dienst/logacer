<?php
    /* Vérifie si l'utilisateur est connecté et donc a accès à cette page */
    $title = ucfirst(thesaurus('results'));
?>

<!DOCTYPE html>
<html>
    <?php require_once("../layout/headers.php"); ?>
    <body>
        <?php require_once("../layout/navbars.php"); ?>
        <div class="maindiv container">
            
            <?php 

            /* Rappel de ce que signifient les éléments :
                * pox : parenthèse ouvrante (0 = rien, 1 = (, 2 = (( )
                * kx : clé
                * ex : évaluateur (eq = =, cont = LIKE, isnull = IS NULL)
                * vx : valeur
                * pfx : parenthèse fermante (0 = rien, 1 = ), 2 = )) )
                * jx : jointure (and, or, none)
                */


            // Récupère les infos (via GET ou POST)
            if (isset($_GET)) {
                $search = $_GET;
            }
            if (isset($_POST) && isset($_POST['element'])) {
                // Création du $search
                $search = ['in'=>$_POST['element']];
                // Pour l'objet
                if ($search['in'] === 'object') {
                    // Nombre endroits où rechercher
                    $search_in = ['number', 'category_abbr', 'function_name', 'type_name', 'fabric_code', 'stamp', 'comment',
                        'cat_name', 'func_code', 'typ_code', 'fab_name'];
                } elseif ($search['in'] == 'site') {
                    // Nombre endroits où rechercher
                    $search_in = ['code', 'name', 'descr'];
                } elseif ($search['in'] == 'phase') {
                    // Nombre endroits où rechercher
                    $search_in = ['code', 'name', 'descr'];
                } elseif ($search['in'] == 'context') {
                    // Nombre endroits où rechercher
                    $search_in = ['code', 'name', 'descr'];
                } else {
                    $search['in'] = false;
                }
                if ($search['in']) {
                    // Incrément pour la création des clés
                    $inc = 0;
                    foreach ($search_in as $s) {
                        // Création des objets
                        $search['po' . $inc] = 0;
                        $search['k' . $inc] = $s;
                        $search['e' . $inc] = 'cont';
                        $search['v' . $inc] = $_POST['query'];
                        $search['pf' . $inc] = 0;
                        if (($inc + 1) < count($search_in)) {
                            $search['j' . $inc] = 'or';
                        } else {
                            $search['j' . $inc] = 'none';
                        }
                        $inc++;
                    }
                }
            }
            // Gestion des différentes valeurs - sauf celles spécifiques aux classes
            // Check parenthèses
            $inc_brackets = 0;
            function openingbrackets($value, $inc) {
                if ($value == 0) {
                    return ["", $inc];
                } elseif ($value == 1) {
                    return ['(', $inc++];
                } elseif ($value == 2) {
                    return ['((', $inc += 2];
                }
            }
            function closingbrackets($value, $inc) {
                if ($value == 0) {
                    return ["", $inc];
                } elseif ($value == 1) {
                    return [')', $inc--];
                } elseif ($value == 2) {
                    return ['))', $inc -= 2];
                }
            }
            function evaluator($value) {
                switch($value) {
                    case 'eq': return '='; break;
                    case 'cont': return 'LIKE'; break;
                    case 'isnull': return 'IS NULL'; break;
                    default: return false; break;
                }
            }
            function jointure($value) {
                switch($value) {
                    case 'and': return 'AND'; break;
                    case 'or': return 'OR'; break;
                    case 'none': return ''; break;
                    default: return false; break;
                }
            }

            if ($search['in'] == 'object') {

                /* Calculation. Description of keys
                * type/fabric = represent code (link) ou local name
                * type/fabric_local = if 0, search local name ; if 1, search link code ; if 2, search both
                */
                // Définition des propriétés des objets et initiation des variables
                $properties = ['number', 'category_abbr', 'function_name', 'type_name', 'fabric_code', 'type_var', 'type_doubt', 'stamp', 'diameter', 'comment'];
                $properties_links = [
                    'site_id'=>['field'=>'site.id', 'joins'=>[]],
                    'site_code'=>['field'=>'site.code', 'joins'=>[]],
                    'site_name'=>['field'=>'site.name', 'joins'=>[]],
                    'phase_code'=>['field'=>'phase.code', 'joins'=>[]],
                    'phase_name'=>['field'=>'phase.name', 'joins'=>[]],
                    'context_code'=>['field'=>'context.code', 'joins'=>[]],
                    'context_name'=>['field'=>'context.name', 'joins'=>[]],
                    'horizon_id'=>['field'=>'phase.horizon', 'joins'=>[]],
                    'horizon_code'=>['field'=>'horizon.code', 'joins'=>['horizon']],
                    'horizon_name'=>['field'=>'horizon.name', 'joins'=>['horizon']],
                    'cat_abbr'=>['field'=>'category.abbreviation', 'joins'=>['category']],
                    'cat_name'=>['field'=>'category.name', 'joins'=>['category']],
                    'func_code'=>['field'=>'function_table.code', 'joins'=>['function']],
                    'func_name'=>['field'=>'function_table.name', 'joins'=>['function']],
                    'typ_code'=>['field'=>'type.code', 'joins'=>['type']],
                    'typ_name'=>['field'=>'type.name', 'joins'=>['type']],
                    'fab_code'=>['field'=>'fabric.code', 'joins'=>['fabric']],
                    'fab_name'=>['field'=>'fabric.name', 'joins'=>['fabric']]];
                $conditions_ns = [''];
                $left_join = "";
                $joins = [];
                $binds = [];
                $increment = 0;
                $request = true;
            } elseif ($search['in'] == 'site') {
                $properties = ['coord_lat', 'coord_long'];
                $properties_links = [
                    'code'=>['field'=>'site.code', 'joins'=>[]],
                    'name'=>['field'=>'site.name', 'joins'=>[]],
                    'descr'=>['field'=>'site.descr', 'joins'=>[]],
                    'public'=>['field'=>'site.public', 'joins'=>[]],
                    'unpublished'=>['field'=>'site.unpublished', 'joins'=>[]],
                    'biblio_review'=>['field'=>'site.biblio_review', 'joins'=>[]]
                ];
                $conditions_ns = [''];
                $left_join = "";
                $joins = [];
                $binds = [];
                $increment = 0;
                $request = true;
            } elseif ($search['in'] == 'phase') {
                $properties = [];
                $properties_links = [
                    'code'=>['field'=>'phase.code', 'joins'=>[]],
                    'name'=>['field'=>'phase.name', 'joins'=>[]],
                    'descr'=>['field'=>'phase.descr', 'joins'=>[]],
                    'public'=>['field'=>'phase.public', 'joins'=>[]],
                    'unpublished'=>['field'=>'phase.unpublished', 'joins'=>[]],
                    'biblio_review'=>['field'=>'phase.biblio_review', 'joins'=>[]]
                ];
                $conditions_ns = [''];
                $left_join = "";
                $joins = [];
                $binds = [];
                $increment = 0;
                $request = true;
            } elseif ($search['in'] == 'context') {
                $properties = [];
                $properties_links = [
                    'code'=>['field'=>'context.code', 'joins'=>[]],
                    'name'=>['field'=>'context.name', 'joins'=>[]],
                    'descr'=>['field'=>'context.descr', 'joins'=>[]],
                    'public'=>['field'=>'context.public', 'joins'=>[]],
                    'unpublished'=>['field'=>'context.unpublished', 'joins'=>[]],
                    'biblio_review'=>['field'=>'context.biblio_review', 'joins'=>[]]
                ];
                $conditions_ns = [''];
                $left_join = "";
                $joins = [];
                $binds = [];
                $increment = 0;
                $request = true;
            } else {
                $request = false;
            }

                /* Description des champs :
                po0 : parenthèse ouvrante
                k0 : propriété
                e0 : évaluateur (=, >, <...)
                v0 : valeur
                pf0 : parenthèse fermante
                j0 : jointure (AND/OR)
                */
            
            if ($request) {
                // Crée les conditions
                while (isset($search['v' . $increment])) {
                    list($po, $inc_brackets) = openingbrackets($search['po' . $increment], $inc_brackets);
                    list($pf, $inc_brackets) = closingbrackets($search['pf' . $increment], $inc_brackets);
                    if (in_array($search['k' . $increment], $properties)) {
                        $k = $search['k' . $increment];
                    } elseif (isset($properties_links[$search['k' . $increment]])) {
                        // Ajoute les left joins à effectuer
                        $k = $properties_links[$search['k' . $increment]]['field'];
                        foreach ($properties_links[$search['k' . $increment]]['joins'] as $join) {
                            if (!in_array($join, $joins)) {
                                $joins[] = $join;
                            }
                        }
                    } else {
                        $request = false; break;
                    }
                    $e = evaluator($search['e' . $increment]);
                    if ($e === false) { $request = false; break; }
                    $v = $search['v' . $increment];
                    // Change la valeur si LIKE ou IS NULL
                    $vbind = ':v' . $increment;
                    if ($e == 'LIKE') { $v = "%" . $v . "%"; } elseif ($e == 'IS NULL') { $vbind = ''; }
                    $j = jointure($search['j' . $increment]);
                    $conditions_ns[0] .= ' ' . $po . $k . ' ' . $e . ' ' . $vbind . $pf . ' ' . $j;
                    if ($e !== 'IS NULL') {
                        $binds['v' . $increment] = $v;
                    }
                    $increment++;
                }
                // Check si il faut rajouter des parenthèses
                if ($inc_brackets > 0) {
                    $conditions_ns .= str_repeat(')', $inc_brackets);
                } elseif ($inc_brackets < 0) {
                    $request = false;
                }
            }
            if ($request) {
                if ($search['in'] == 'object') {
                    // Crée les jointures
                    foreach ($joins as $join) {
                        switch($join) {
                            case 'horizon': $left_join .= ' LEFT JOIN horizon ON phase.horizon = horizon.id'; break;
                            case 'category': $left_join .= ' LEFT JOIN category ON object.category_abbr = category.abbreviation'; break;
                            case 'function': $left_join .= ' LEFT JOIN function_table ON object.function_name = function_table.name'; break;
                            case 'type': $left_join .= ' LEFT JOIN type ON object.type_name = type.name'; break;
                            case 'fabric': $left_join .= ' LEFT JOIN fabric ON object.fabric_code = fabric.code'; break;
                        }
                    }

                    $objects_count = ObjectTable::count_public(false, $left_join, $binds, [], $conditions_ns);
                    $params_objects = [
                        'mode'          => 'find_public',
                        'conditions'    => false,
                        'left_join'     => $left_join,
                        'binds'         => $binds,
                        'ordering'      => [],
                        'conditions_ns' => $conditions_ns,
                        'limit'         => ROWS_PER_PAGE,
                        'total'         => $objects_count
                    ];
                    $objects = ObjectTable::find_public($params_objects['conditions'], $params_objects['left_join'], $params_objects['binds'], $params_objects['ordering'], $params_objects['conditions_ns'], $params_objects['limit'], 0);
                    $params_objects['offset'] = end($objects)->id();
                    $params_objects['loaded'] = count($objects);
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
                    echo h(2, ucfirst(thesaurus('results')));
                    require("../sites/table_inventory.php");
                } elseif ($search['in'] == 'site') {
                    // Crée les jointures
                    // Pas encore pour site

                    // Recherche des sites publics
                    $sites = Site::find_public(false, $left_join, $binds, [], $conditions_ns);
                    // Show results
                    echo h(2, ucfirst(thesaurus('results')));
                    echo "<ul>";
                    foreach ($sites as $site) {
                        echo li($site->hyperlink());
                    }
                    echo "</ul>";
                } elseif ($search['in'] == 'phase') {
                    // Crée les jointures
                    // Pas encore pour phase

                    // Recherche des phases publics
                    $phases = Phase::find_public(false, $left_join, $binds, [], $conditions_ns);
                    // Show results
                    echo h(2, ucfirst(thesaurus('results')));
                    echo "<ul>";
                    foreach ($phases as $phase) {
                        echo li($phase->hyperlink());
                    }
                    echo "</ul>";
                } elseif ($search['in'] == 'context') {
                    // Crée les jointures
                    // Pas encore pour context

                    // Recherche des sites publics
                    $contexts = Context::find_public(false, $left_join, $binds, [], $conditions_ns);
                    // Show results
                    echo h(2, ucfirst(thesaurus('results')));
                    echo "<ul>";
                    foreach ($contexts as $context) {
                        echo li($context->hyperlink());
                    }
                    echo "</ul>";
                }
            } else {
                // SOMETHING WAS WRONG
                display_fatal_error('research not correct');
            }


            ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>