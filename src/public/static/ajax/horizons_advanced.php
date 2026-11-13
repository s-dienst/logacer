<?php
require_once("../../../variables.php");
require_once("../../../layout/functions2.php");
require_once("../../../layout/functions_database.php");
require_once("../../../layout/functions_html.php");
require_once("../../../layout/functions_statistic.php");
require_once("../../../layout/errors.php");
require_once("../../../layout/thesaurus.php");
require_once("../../../horizons_advanced/functions_horizons_advanced.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérification que la requête est bien AJAX
if (
    !isset($_SERVER['HTTP_X_REQUESTED_WITH']) ||
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest'
) {
    http_response_code(403);
    exit('Accès interdit');
}

require("../../../users/catch_language.php");

// Décodage du JSON
$params = json_decode(file_get_contents("php://input"), true);
$id_project = intval($params["project_id"]);
if (!defined('PROJECT')) {
    define('PROJECT', Project::find_by_id($id_project));
}

// Initialisation de la première variable
$function = $params['function'] ?? false;

switch ($function) {
    // Changement d'un lien entre horizon et type
    case 'change_link_horizon_type':
        // Initialisation des variables spécifiques
        $change_to      = $params['changeTo'];
        $type_id        = (int) $params['typeId'];
        $horizon_id     = $params['horizonId'];
        if (!Horizon::find_by_id($horizon_id)) {
            $result = false;
            $error = "ERREUR";
        } elseif (!Horizon::find_by_id($horizon_id)->contributor_rights()) {
            $result = false;
            $error = "ERREUR";
        } else {
            // Chercher lien
            $actual_link = Type::find_by_id($type_id)->is_linked($horizon_id);
            // Changer lien
            $result = Type::find_by_id($type_id)->change_link_horizon($horizon_id, $change_to);
        }
        // Réponse
        $json_response = ['changed' => $result];
        break;
    case 'comparison_with_horizon':
        // Récupération des paramètres
        $code_facies        = $params['facies'];
        $codes_horizons     = $params['horizons'];
        $phases_or_contexts = $params['mode'];
        $codes_selected     = $params['selectedItems'];
        $counting_method_id = intval($params['countingMethod']); // 0, 1, 2, 3 ou vide
        $links_information  = $params['linkParams']; // clé EN avec color (n°, y-compris 0) et include (1 ou rien)
        if ($counting_method_id === 1) {
            $counting_parts = $params['countingParts']; // n_rim, n_wall...
        }
        // liste des clés des liens
        $list_links_for_table = [];
        foreach ($links_information as $key => $value) {
            $list_links_for_table[$key] = 0;
        }
        $error = "";
        if (empty($code_facies) || empty($codes_horizons) || empty($phases_or_contexts) || empty($codes_selected) || empty($links_information)) {
            // Code à afficher pour indiquer erreur
            $error = "ERREUR";
        } elseif (!in_array($phases_or_contexts, ['phases', 'contexts'])) {
            $error = "ERREUR";
        } else {
            // Création du facies
            $facies = Facies::find_by_code($code_facies);
            if (!$facies) {
                $error = "ERREUR";
            } else {
                $facies_id = $facies->id();
                // Création de la liste de contextes (si facies OK)
                $context_ids = [];
                foreach ($codes_selected as $c) {
                    if ($phases_or_contexts === "phases") {
                        $phase = Phase::find_by_site_code(Site::find_by_name($c['site'])->id(), $c['code']);
                        if ($phase) {
                            $contexts = Context::find_by_parent($phase->id());
                            foreach ($contexts as $context) {
                                $context_ids[] = $context->id();
                            }
                        } else {
                            $error = "ERREUR";
                        }
                    } else {
                        $context = Context::find_by_site_code(Site::find_by_name($c['site'])->id(), $c['code']);
                        if ($context) {
                            $context_ids[] = $context->id();
                        } else {
                            $error = "ERREUR";
                        }
                    }
                }
            }
        }
        // Vérification que les comptages sont OK
        if (isset($counting_parts)) {
            if (count($counting_parts) === 0) {
                $error = "ERREUR";
            }
            foreach ($counting_parts as $cp) {
                if (!in_array($cp, ['n_rim', 'n_bottom', 'n_handle', 'n_wall'])) {
                    $error = "ERREUR";
                }
            }
        }
        // Création du squelette du tableau principal
        $table_results = [];
        if (strlen($error) === 0) {
            // On récupère les ID des horizons sélectionnés et on s'assure que l'horizon principal soit en dernier
            $list_horizons_id = [];
            foreach ($codes_horizons as $c) {
                $horizon = Horizon::find_by_facies_code($facies_id, $c);
                if (!$horizon) {
                    $error = "ERREUR";
                } else {
                    $horizon_id = $horizon->id();
                        // S'il y a des sous-horizons, on les mets avant
                    foreach ($codes_horizons as $c2) {
                        $horizon_checked = Horizon::find_by_facies_code($facies_id, $c2);
                        if (!$horizon_checked) {
                            $error = "ERREUR";
                            // Deux conditions : pas encore présent, et l'horizon est superhorizon du sous-horizon
                        } elseif (!in_array($horizon_checked->id(), $list_horizons_id) && $horizon_checked->superhorizon() && $horizon_checked->superhorizon()->id() === $horizon_id) {
                            $table_results[$horizon_checked->id()] = ['position' => 1, 'links' => $list_links_for_table, 'cumul' => 0];
                            $list_horizons_id[] = $horizon_checked->id();
                        }
                    }
                    if (!in_array($horizon_id, $list_horizons_id)) {
                        // Une fois ajouté les sous-horizons, on peut mettre l'horizon
                        $table_results[$horizon_id] = ['position' => 0, 'links' => $list_links_for_table, 'cumul' => 0];
                        $list_horizons_id[] = $horizon_id;
                    }
                }
            }
        }
        // Incrémentation des données
        $sum_objects = 0;
        foreach ($context_ids as $c_id) {
            // D'abord, check comptage nécessaire si choix du NR pour ce contexte
            if ($counting_method_id === 3) {
                $countings = Counting::linked('counting', 'site', Context::find_by_id($c_id)->related_phase()->related_site()->id(), true);
                $has_nr = false;
                $has_bfap = false;
                foreach ($countings as $c) {
                    if ($c->id() === 1) {
                        $has_bfap = true;
                    } elseif ($c->id() === 3) {
                        $has_nr = true;
                    }
                }
                if ($has_bfap && !$has_nr) {
                    $by_nr = true;
                } else {
                    $by_nr = false;
                }
            }
            // On check également si le contexte appartient à un des horizons
            $check_hor = Context::find_by_id($c_id)->related_phase()->horizon();
            $cont_hor_id = false;
            if ($check_hor) {
                if ($check_hor->facies()->code() === $code_facies) {
                    $cont_hor_id = $check_hor->id();
                }
            }
            $objects = ObjectTable::find_by_parent($c_id);
            foreach ($objects as $object) {
                // On extrait la valeur à additionner
                $count = 0;
                if ($counting_method_id === 1) {
                    // Par type de partie
                    foreach ($counting_parts as $cp) {
                        $count += $object->$cp();
                    }
                } elseif ($counting_method_id === 2) {
                    // NMI
                    $count = $object->n_mni();
                } elseif ($counting_method_id === 3) {
                    // NR
                    if ($by_nr) {
                        $count = $object->n_sherd();
                    } else {
                        foreach (['n_rim', 'n_bottom', 'n_handle', 'n_wall'] as $cp) {
                            $count += $object->$cp();
                        }
                    }
                } else {
                    // Nombre d'occurence ou valeur erronée
                    $count = 1;
                }
                $type = $object->type_link();
                // Cumul : peut être fait qu'une fois
                $auth_cumul = true;
                // S'il y a un type, que ce n'est pas une variante ni un type peu sûr (ce dernier point, à réfléchir)
                if ($type && !$object->type_var() && !$object->type_doubt()) {
                    foreach ($table_results as $h_id => $content) {
                        $link = $type->is_linked($h_id);
                        // 3 solutions : false, null ou lien
                        if ($link === false) {
                            $link = 'not_linked';
                            // On ajoute à la clé not_linked
                        } elseif ($link === null) {
                            $link = 'undescribed';
                            // On ajoute à la clé undescribed
                        } elseif ($cont_hor_id === $h_id) {
                            // Autre option : si nombre d'objets sûrs avec ce type dans l'horizon = nombre d'objets sûrs avec ce type dans le contexte, pas de lien
                            if ($type->check_objects_context_horizon($c_id, $h_id)) {
                                $link = 'not_linked';
                            }
                        }
                        // On ajoute à la bonne clé
                        $table_results[$h_id]['links'][$link] += $count;
                        // On ajoute au cumul, si paramétré
                        if ($links_information[$link]['include'] && $auth_cumul) {
                            $table_results[$h_id]['cumul'] += $count;
                            $auth_cumul = false;
                        }
                    }
                } else {
                    // On ajoute à not_linked
                    foreach ($table_results as $h_id => $content) {
                        $table_results[$h_id]['links']['not_linked'] += $count;
                        if ($links_information['not_linked']['include'] && $auth_cumul) {
                            $table_results[$h_id]['cumul'] += $count;
                            $auth_cumul = false;
                        }
                    }
                }
                // Incrémentation de la somme
                $sum_objects += $count;
            }
        }

        // Check si la somme est bien supérieure à 0
        if ($sum_objects > 0) {
            // Création de la table
            $table_html = "<table class='table table-sm' id='site_table' style='font-size:small'>
                <thead><tr>";
                // Header horizon
            $table_html .= "<th>" . ucfirst(thesaurus('horizons')) . "</th>";
            // Headers liens
            foreach ($links_information as $key => $value) {
                $table_html .= "<th style='width:80px;'>" . ucfirst(th_h_a_link_type($key)) . "</th>";
            }
            // Header cumul
            $table_html .= "<th style='width:80px;'>Cumul</th>";
            $table_html .= "</tr></thead><tbody>";
            // Nombre d'objets déjà cumulés
            $val_cumul = 0;
            // Lignes par horizon
            foreach ($table_results as $h_id => $content) {
                $table_html .= "<tr>";
                // Code horizon
                if ($content['position']) {
                    $table_html .= "<td>" . Horizon::find_by_id($h_id)->code() . "</td>";
                } else {
                    $table_html .= "<td><b>" . Horizon::find_by_id($h_id)->code() . "</b></td>";
                }
                // Valeurs liens
                foreach ($content['links'] as $key => $value_link) {
                    $val = round($value_link * 100 / $sum_objects, 2);
                    $table_html .= "<td>" . $val . " %</td>";
                }
                // Valeurs cumul
                $val_cumul += $content['cumul'];
                $val = round($val_cumul * 100 / $sum_objects, 2);
                $table_html .= "<td>" . $val . " % </td>";
                $table_html .= "</tr>";
            }
            $table_html .= "</tbody></table>";

            /* Création du graphique */
                // Dimensions
                $width = 1000;
                $height = 600;

                $margin_left = 80;
                $margin_right = 80;
                $margin_bottom = 100;
                $margin_top = 100;

                $graph_low_limit = $height - $margin_bottom;
                $graph_high_limit = $margin_top;
                $graph_right_limit = $width - $margin_right;
                $graph_left_limit = $margin_left;
                $graph_width = $graph_right_limit - $graph_left_limit;
                $graph_height = $graph_low_limit - $graph_high_limit;

                // Création des codes pour l'axe horizontal et des variables nécessaires
                $codes_horizon = [];
                foreach ($table_results as $h_id => $content) {
                    $codes_horizon[] = Horizon::find_by_id($h_id)->code();
                }

                // Titre du graphique
                $graphic_html = "<text x='"  . ($width / 2). "' y='" . ($margin_bottom - 60) . "' text-anchor='middle' font-size='18'>" . ucfirst(thesaurus("compare_contexts_hs")) . thesaurus(":") . "</text>";
                $graphic_html .= "<text x='"  . ($width / 2). "' y='" . ($margin_bottom - 30) . "' text-anchor='middle' font-size='24'>" . $facies->codename() . "</text>";

                // Création des axes horizontaux, vertical gauche et vertical droit
                $graphic_html .= "<line x1='" . $graph_left_limit  . "' y1='" . $graph_low_limit  . "' x2='" . $graph_right_limit . "' y2='" . $graph_low_limit . "' stroke='black' />";
                $graphic_html .= "<line x1='" . $graph_left_limit  . "' y1='" . $graph_high_limit . "' x2='" . $graph_left_limit  . "' y2='" . $graph_low_limit . "' stroke='black' />";
                $graphic_html .= "<line x1='" . $graph_right_limit . "' y1='" . $graph_high_limit . "' x2='" . $graph_right_limit . "' y2='" . $graph_low_limit . "' stroke='black' />";

                // Graduation des axes verticaux
                for ($i = 0; $i <= 100; $i += 10) {
                    $y = $graph_low_limit - ($i/100) * ($graph_low_limit - $graph_high_limit);
                    $graphic_html .= "<line x1='" . ($graph_left_limit - 5) . "' y1='" . $y . "' x2='" . $graph_left_limit        . "' y2='" . $y . "' stroke='black' />";
                    $graphic_html .= "<line x1='" . $graph_right_limit      . "' y1='" . $y . "' x2='" . ($graph_right_limit + 5) . "' y2='" . $y . "' stroke='black' />";
                    if ($i > 0) {
                        $graphic_html .= "<line x1='" . $graph_left_limit   . "' y1='" . $y . "' x2='" . $graph_right_limit       . "' y2='" . $y . "' stroke='lightgray' stroke-dasharray='2,2' />";
                    }
                    $graphic_html .= "<text x='"  . ($graph_left_limit - 10). "' y='" . ($y + 4) . "' text-anchor='end' font-size='12'>" . $i . "%</text>";
                    $graphic_html .= "<text x='"  . ($graph_right_limit + 10). "' y='" . ($y + 4) . "' text-anchor='start' font-size='12'>" . $i . "%</text>";
                }

                // Codes des horizons et graduation de l'axe horizontal
                $n = count($codes_horizon);
                $spacing = ($graph_width) / ($n);
                $begin_spacing = $spacing / 2;

                for ($j = 0; $j < $n; $j++) {
                    $x = $graph_left_limit + $j * $spacing + $begin_spacing;
                    $graphic_html .= "<line x1='" . $x . "' y1='" . $graph_low_limit . "' x2='" . $x . "' y2='" . ($graph_low_limit + 5) . "' stroke='black' />";
                    $graphic_html .= "<text x='" . $x . "' y='" . ($graph_low_limit + 15). "' text-anchor='end' font-size='12' transform='rotate(-60 " . $x . " " . ($graph_low_limit + 15) . ")'>" . $codes_horizon[$j] . "</text>";
                }

                // Ajout des rectangles de données
                // Création de la variable avec couleurs et données
                $rect_info = [];
                $order = [];
                $num_order = 0;
                foreach ($links_information as $link => $content) {
                    $color = intval($content['color']);
                    if ($color > 0) {
                        // Si pas encore présent, on doit l'ajouter, et lui attribuer un numéro d'ordre
                        if (!isset($order[$color])) {
                            $order[$color] = $num_order;
                            $rect_info[$num_order] = ['color' => COLORS_HORIZONS_ADVANCED_1[$color]['rgb'], 'links' => [$link]];
                            $num_order++;
                        } else {
                            array_push($rect_info[$order[$color]]['links'], $link);
                        }
                    }
                }

                // Ajout des rectangles proprement dits
                $num_hor = 0;
                foreach ($table_results as $h_id => $content) {
                    // Position horizontale centrale :
                    $x_center = $graph_left_limit + $num_hor * $spacing + $begin_spacing;
                    // Largeur relative de la barre :
                    $rect_width = $spacing * 0.6;
                    // Point de départ vertical de la barre
                    $current_y = $graph_low_limit;

                    foreach ($rect_info as $r_info) {
                        // Calcul des variables $rect_color et $rect_height
                        $rect_color = $r_info['color'];
                        $sum = 0;
                        foreach ($r_info['links'] as $link) {
                            $sum += $content['links'][$link];
                        }
                        // Règle de 3
                        $rect_height = $sum / $sum_objects * $graph_height;

                        // Calcul de la position verticale supérieure
                        $y_top = $current_y - $rect_height;

                        // Code rectangle
                        $graphic_html .= "<rect x='" . ($x_center - $rect_width / 2) . "' y='" . $y_top . "' width='" . $rect_width . "' height='" . $rect_height . "' fill='" . $rect_color . "' stroke='black' stroke-width='0.5' />";

                        // Mise à jour du point de départ du prochain rectangle
                        $current_y = $y_top;
                    }
                    $num_hor++;
                }

                // Ajout de la courbe de cumul
                $num_hor = 0;
                $sum_cumul = 0;
                $graphic_html_squares = "";
                foreach ($table_results as $h_id => $content) {
                    // Calcul des valeurs
                    $old_sum_cumul = $sum_cumul;
                    $sum_cumul += $content['cumul'];
                    // Règle de 3
                    $cumul_old_height = $old_sum_cumul / $sum_objects * $graph_height;
                    $cumul_height = $sum_cumul / $sum_objects * $graph_height;

                    // Position horizontale centrale :
                    $x_center = $graph_left_limit + $num_hor * $spacing + $begin_spacing;

                    // Largeur du carré :
                    $sq_dim = $spacing * 0.25;
                    // Couleur du carré :
                    $sq_color = '#144e17ff';
                    // Couleur de la ligne :
                    $line_color = '#1e8b24ff';
                    
                    // Ligne (si pas premier horizon)
                    if ($num_hor > 0) {
                        $graphic_html .= "<line x1='" . ($x_center - $spacing) . "' y1='" . ($graph_low_limit - $cumul_old_height) . "' x2='" . $x_center . "' y2='" . ($graph_low_limit - $cumul_height) . "' stroke='" . $line_color . "' />";
                    }
                    // Rectangle
                    $graphic_html_squares .= "<rect x='" . ($x_center - $sq_dim / 2) . "' y='" . ($graph_low_limit - $sq_dim / 2 - $cumul_height) . "' width='" . $sq_dim . "' height='" . $sq_dim . "' fill='" . $sq_color . "' />";

                    $num_hor++;
                }

                $graphic_html .= $graphic_html_squares;

                // Légende
                // Fonction de gestion du texte
                function svg_wrap_text($text, $x, $rect_center_y, $font_size, $max_width_px) {
                    $avg_char_width = 0.48 * $font_size;
                    $max_chars = floor($max_width_px / $avg_char_width);

                    // Découper en mots
                    $words = explode(' ', $text);
                    $lines = [];
                    $current_line = '';

                    foreach ($words as $word) {
                        if (strlen($current_line . ' ' . $word) > $max_chars) {
                            $lines[] = trim($current_line);
                            $current_line = $word;
                        } else {
                            $current_line .= ' ' . $word;
                        }
                    }
                    if ($current_line !== '') {
                        $lines[] = trim($current_line);
                    }

                    $line_height = $font_size + 4;
                    $num_lines = count($lines);
                    $block_height = $num_lines * $line_height;

                    // Calcul du point de départ pour centrer le bloc
                    $first_line_y = $rect_center_y - ($block_height / 2) + $font_size;

                    // Générer le SVG
                    $svg = '';
                    foreach ($lines as $i => $line) {
                        $y = $first_line_y + $i * $line_height;
                        $svg .= "<text x='" . $x . "' y='" . $y . "' font-size='" . $font_size . "'>" . $line . "</text>";
                    }
                    return $svg;
                }
                // Position et dimensions du cadre de légende
                $legend_x = $graph_left_limit;
                $legend_y = $height; // par exemple, 100px au-dessous du bas
                $legend_width = $graph_width;
                $legend_height = 0;

                // Titre
                $graphic_html_legend = "<text x='" . ($legend_x+10) . "' y='" . ($legend_y+20) . "' font-size='16' font-weight='bold'>" . ucfirst(thesaurus("legend")) . "</text>";

                // Boucle sur les couleurs
                $line_y = $legend_y + 50;
                // Valeurs initialisation (taille des rectangles, centrage vertical, taille de police)
                $font_size = 12;
                $leg_rect_height = 20;
                $leg_rect_width = 30;
                // Légendes par couleurs
                foreach ($rect_info as $r_info) {
                    $rect_color = $r_info['color'];

                    // Centre vertical du rectangle
                    $rect_center_y = $line_y - 15 + $leg_rect_height / 2;

                    // Petit rectangle coloré
                    $graphic_html_legend .= "<rect x='" . ($legend_x + 10) . "' y='" . ($line_y-15) . "' width='" . $leg_rect_width . "' height='" . $leg_rect_height . "' fill='" . $rect_color . "' stroke='black' />";

                    // Texte
                    $links_list = implode(', ', $r_info['links']); // ou tu peux calculer un résumé
                    for ($i = 0; $i < count($r_info['links']); $i++) {
                        if ($i === 0) {
                            $links_list = th_h_a_link_type($r_info['links'][$i], 'multiple');
                        } else {
                            if ($i === (count($r_info['links']) - 1)) {
                                $links_list .= " " . thesaurus('and') . " ";
                            } else {
                                $links_list .= ", ";
                            }
                            $links_list .= th_h_a_link_type($r_info['links'][$i], 'multiple');
                        }
                    }
                    if (isset($counting_parts)) {
                        // On donne info
                        for ($i = 0; $i < count($counting_parts); $i++) {
                            if ($i === 0) {
                                $quantification = thesaurus($counting_parts[$i]);
                            } else {
                                if ($i === (count($counting_parts) - 1)) {
                                    $quantification .= " " . thesaurus('and') . " ";
                                } else {
                                    $quantification .= ", ";
                                }
                                $quantification .= thesaurus($counting_parts[$i]);
                            }
                        }
                    } elseif ($counting_method_id === 0) {
                        $quantification = thesaurus('occurence number');
                    } else {
                        $quantification = Counting::find_by_id($counting_method_id)->name();
                    }
                    $text = ucfirst(thesaurus("artifact_prop_(")) . $quantification . thesaurus(")_of_the") . thesaurus($phases_or_contexts) . thesaurus("compared_are_types") . $links_list . ucfirst("of_regional_horizon");

                    // Création du texte via la fonction
                    $graphic_html_legend .= svg_wrap_text($text, $legend_x + $leg_rect_width + 20, $rect_center_y, $font_size, $legend_width - $leg_rect_width - 30);

                    $line_y += $leg_rect_height + 20; // espace entre lignes
                }
                // Légende de la courbe cumulative
                // D'abord, ligne
                $graphic_html_legend .= "<line x1='" . ($legend_x + 10) . "' y1='" . ($line_y - 15 + $leg_rect_height / 2) . "' x2='" . ($legend_x + 10 + $leg_rect_width) . "' y2='" . ($line_y - 15 + $leg_rect_height / 2) . "' stroke='" . $line_color . "' />";
                // Ensuite, carré
                $graphic_html_legend .= "<rect x='" . ($legend_x + 10 + ($leg_rect_width / 2) - $sq_dim / 2) . "' y='" . ($line_y - 15 + $leg_rect_height / 2 - $sq_dim / 2) . "' width='" . $sq_dim . "' height='" . $sq_dim . "' fill='" . $sq_color . "' />";
                // Texte
                $text = ucfirst(thesaurus("artifact_prop_(")) . $quantification . thesaurus(")_of_the") . thesaurus($phases_or_contexts) . thesaurus("compared_appeared");
                // Création du texte via la fonction
                $graphic_html_legend .= svg_wrap_text($text, $legend_x + $leg_rect_width + 20, $line_y - 15 + $leg_rect_height / 2, $font_size, $legend_width - $leg_rect_width - 30);

                $line_y += $leg_rect_height + 20; // espace entre lignes

                // Cadre
                $legend_height = $line_y - $legend_y -20;
                $graphic_html .= "<rect x='" . $legend_x . "' y='" . $legend_y . "' width='" . $legend_width . "' height='" . $legend_height . "' fill='none' stroke='black' />";

                $graphic_html .= $graphic_html_legend;

                // On rajoute la liste des phases ou contextes
                // D'abord, légende
                $graphic_html .= "<text x='" . ($legend_x) . "' y='" . $line_y . "' font-size='" . ($font_size + 2) . "'>" . ucfirst(thesaurus('compared_' . $phases_or_contexts)) . thesaurus(':') . "</text>";
                $line_y += $font_size + 6;

                // Puis la liste
                foreach ($codes_selected as $c) {
                    $site = Site::find_by_name($c['site']);
                    if ($phases_or_contexts === "phases") {
                        $item_name = Phase::find_by_site_code($site->id(), $c['code'])->codename();
                    } else {
                        $item_name = Context::find_by_site_code($site->id(), $c['code'])->codename;
                    }
                    $text = "- " . $item_name .  " (" . thesaurus('site') . thesaurus(':') . ' ' . $site->name() . ')';
                    $graphic_html .= "<text x='" . ($legend_x + 10) . "' y='" . $line_y . "' font-size='" . $font_size . "'>" . $text . "</text>";
                    $line_y += $font_size + 4;
                }
                // Initialisation du SVG
                $graphic_html = "<svg xmlns='http://www.w3.org/2000/svg' width='" . $width . "' height='" . ($line_y + 50) . "'>" . $graphic_html . "</svg>";
        } else {
            $error = "ERREUR";
        }

        // Envoi des contenus HTML
        $json_response = [
            'graphic' => $graphic_html,
            'table'   => $table_html
        ];
        break;
    case "save_config_seriation":
        // Fonction de normalisation de la couleur
        function normalize_color($color) {
            // Cas 1 : identifiant numérique
            if (is_numeric($color)) { return $color; }
            // Cas 2 : déjà hexadécimal
            if (strpos($color, '#') === 0) { return strtolower($color); }
            // Cas 3 : format rgb(...)
            if (strpos($color, 'rgb') === 0) {
                // Nettoie la chaîne
                $color = str_replace('rgba', '', $color);
                $color = str_replace(['rgb', '(', ')', ' '], '', $color);
                $parts = explode(',', $color); // [r, g, b[, a]]
                if (count($parts) >= 3) {
                    $r = (int)$parts[0];
                    $g = (int)$parts[1];
                    $b = (int)$parts[2];
                    return sprintf("#%02x%02x%02x", $r, $g, $b);
                }
            }
            // Cas non reconnu
            return false;
        }

        // Initialisation des variables spécifiques
        $mode        = $params['mode'];
        $config_name = $params['configName'];
        $config_id   = $params['configId'];
        $list_items  = $params['listItems']; // Pour phases/contexts : site/code/color, pour types : used=>[group=>[codes]]/nonUsed[codes]

        // Vérification du mode
        if (in_array($mode, ['phases', 'contexts', 'types'])) {
            // Création ou modification de la configuration
            $config = new ConfigHorizon(['id'=>$config_id, 'name'=>$config_name, 'type'=>$mode]);
            if ($config->contributor_rights()) {
                $success = $config->save();
            } else {
                $success = false;
                $error = "ERREUR"; // Pas les droits
            }
            if ($success) {
                // Besoins différents selon le cadre
                if ($mode === 'phases') {
                    $linkeds = Phase::linked('config_horizon', 'phase_or_context', $config->id());
                    // Création d'une array associative id->phase
                    $linked_phases = [];
                    foreach ($linkeds as $l) {
                        $linked_phases[$l->id()] = $l;
                    }
                    // On gère d'abord les phases de la liste
                    foreach ($list_items as $item) {
                        // On change la couleur
                        $color = normalize_color($item['color']);
                        // Phase 
                        $site = Site::find_by_name($item['site']);
                        $phase = Phase::find_by_site_code($site->id(), $item['code']);
                        if ($phase) {
                            // On vérifie si présent
                            if (isset($linked_phases[$phase->id()])) {
                                // On met à jour la couleur
                                if ((string) $config->color($phase->id()) !== (string) $color) {
                                    $config->update_color($phase->id(), $color);
                                }
                                // On enlève la phase de $linked_phases
                                unset($linked_phases[$phase->id()]);
                            } else {
                                // On crée le lien
                                $config->create_link($phase->id(), $color);
                            }
                        } else {
                            $error = "ERREUR";
                        }
                    }
                    // Ensuite, on doit supprimer les liens qui ne sont plus d'actualité
                    foreach ($linked_phases as $phase) {
                        DatabaseObject::delink('config_horizon', 'phase_or_context', $config->id(), $phase->id());
                    }
                } elseif ($mode === 'contexts') {
                    $linkeds = Context::linked('config_horizon', 'phase_or_context', $config->id());
                    // Création d'une array associative id->context
                    $linked_contexts = [];
                    foreach ($linkeds as $l) {
                        $linked_contexts[$l->id()] = $l;
                    }
                    // On gère d'abord les contextes de la liste
                    foreach ($list_items as $item) {
                        // On change la couleur
                        $color = normalize_color($item['color']);
                        // Phase 
                        $site = Site::find_by_name($item['site']);
                        $context = Context::find_by_site_code($site->id(), $item['code']);
                        if ($context) {
                            // On vérifie si présent
                            if (isset($linked_contexts[$context->id()])) {
                                // On met à jour la couleur
                                if ((string) $config->color($context->id()) !== (string) $color) {
                                    $config->update_color($context->id(), $color);
                                }
                                // On enlève la phase de $linked_phases
                                unset($linked_contexts[$context->id()]);
                            } else {
                                // On crée le lien
                                $config->create_link($context->id(), $color);
                            }
                        } else {
                            $error = "ERREUR";
                        }
                    }
                    // Ensuite, on doit supprimer les liens qui ne sont plus d'actualité
                    foreach ($linked_contexts as $context) {
                        DatabaseObject::delink('config_horizon', 'phase_or_context', $config->id(), $phase->id());
                    }
                } else {
                    // Fonctions utilitaires
                    function delink_supertype($type, $linked) {
                        global $already_linked_types;
                        $supertype = $type->supertype();
                        if ($supertype) {
                            // D'abord, on le delink, si présent
                            if ($already_linked_types[$supertype->code()]) {
                                DatabaseObject::delink('config_horizon_type', 'type', $already_linked_types[$supertype->code()], $supertype->id());
                                unset($already_linked_types[$supertype->code()]);
                            }
                            // Ensuite, on fait la même chose avec le supertype
                            delink_supertype($supertype);
                        }
                    }
                    function delink_children($type) {
                        global $already_linked_types;
                        $subtypes = Type::subtypes($type->id());
                        foreach ($subtypes as $sub) {
                            // D'abord, on le delink, si présent
                            if ($already_linked_types[$sub->code()]) {
                                DatabaseObject::delink('config_horizon_type', 'type', $already_linked_types[$sub->code()], $sub->id());
                                unset($already_linked_types[$sub->code()]);
                            }
                            // Ensuite, on fait la même chose avec le subtype
                            delink_children($sub);
                        }
                    }
                    // Vérification si c'est pour la totalité ou non
                    $is_full = $params['full'];
                    // On récupère les groups
                    $lg = ConfigHorizonType::find_by_parent($config->id());
                    // Création d'une array associative id->group
                    $linked_groups = []; // Groupes déjà liés par id
                    $already_linked_types = []; // Types déjà liés par code (et id groupe)
                    foreach ($lg as $g) {
                        $linked_groups[$g->id()] = $g;
                        // On doit aussi créer une array associative de référencement type=>group pour l'existant
                        $types = Type::linked('config_horizon_type', 'type', $g->id());
                        foreach ($types as $t) {
                            $already_linked_types[$t->code()] = $g->id();
                        }
                    }
                    // On gère d'abord les groupes de la liste
                    $used_groups = $list_items['used'];
                    $non_used_types = $list_items['nonUsed'];
                    $used_types = [];
                    // On crée une array associative de référencement type=>groupe pour l'input
                    foreach ($used_groups as $group_name=>$types) {
                        foreach ($types as $type) {
                            $used_types[$type] = $group_name;
                        }
                    }
                    foreach ($used_groups as $group_name=>$types) {
                        $group = ConfigHorizonType::find_by_config_name($config->id(), $group_name);
                        if ($group) {
                            // On cherche les types déjà liés
                            $already_linked = Type::linked('config_horizon_type', 'type', $group->id());
                            if ($is_full) {
                                // Si full : on enlève et on rajoute ensuite
                                foreach ($already_linked as $l) {
                                    DatabaseObject::delink('config_horizon_type', 'type', $group->id(), $l->id());
                                    unset($already_linked_types[$l->code()]);
                                }
                                foreach ($types as $code) {
                                    $t = Type::find_by_code($code);
                                    if ($t) {
                                        $group->create_link($t->id());
                                    } else {
                                        $error = "ERREUR";
                                    }
                                }
                            } else {
                                // Sinon, d'abord on check s'il y a des types présents dans le groupe qui ne doivent pas l'être
                                foreach ($already_linked as $t) {
                                    // Si ils sont dans non-utilisés, ils ne doivent pas l'être
                                    if (in_array($t->code(), $non_used_types)) {
                                        DatabaseObject::delink('config_horizon_type', 'type', $group->id(), $t->id());
                                        unset($already_linked_types[$t->code()]);
                                    }
                                }
                                // Ensuite, on récupère la liste des types à ajouter
                                foreach ($types as $code) {
                                    $t = Type::find_by_code($code);
                                    if ($t) {
                                        // On vérifie si présent ou non
                                        $to_add = true;
                                        foreach ($already_linked as $l) {
                                            if ($l->id() === $t->id()) {
                                                $to_add = false;
                                                break;
                                            }
                                        }
                                        // Si c'est présent, on a globalement rien à faire. Sinon :
                                        if ($to_add) {
                                            // L'ajout d'un nouveau type implique :
                                            // - La suppression du type ailleurs
                                            // - La suppression des types hiérarchiquement liés ailleurs
                                            // D'abord, on check si le type est dans un autre groupe
                                            if ($already_linked_types[$t->code()]) {
                                                // Si oui, on doit le supprimer
                                                DatabaseObject::delink('config_horizon_type', 'type', $already_linked_types[$t->code()], $t->id());
                                                // On l'enlève aussi de la liste
                                                unset($already_linked_types[$t->code()]);
                                            }
                                            // Ensuite, on regarde la hiérarchie
                                            delink_supertype($t);
                                            delink_children($t);
                                            // Enfin, on l'ajoute
                                            $group->create_link($t->id());
                                        }
                                    }
                                }
                            }
                            // On enlève le groupe de $linked_groups
                            unset($linked_groups[$group->id()]);
                        } else {
                            // On crée le groupe
                            $new_group = new ConfigHorizonType([
                                'config_horizon'=>$config->id(),
                                'name'=>$group_name
                            ]);
                            $success = $new_group->save();
                            if ($success) {
                                // On crée le lien avec les types
                                foreach ($types as $code) {
                                    $t = Type::find_by_code($code);
                                    if ($t) {
                                        if (!$is_full) {
                                            // L'ajout d'un nouveau type dans ce cas implique :
                                            // - La suppression du type ailleurs
                                            // - La suppression des types hiérarchiquement liés ailleurs
                                            // D'abord, on check si le type est dans un autre groupe
                                            if ($already_linked_types[$t->code()]) {
                                                // Si oui, on doit le supprimer
                                                DatabaseObject::delink('config_horizon_type', 'type', $already_linked_types[$t->code()], $t->id());
                                                // On l'enlève aussi de la liste
                                                unset($already_linked_types[$t->code()]);
                                            }
                                            // Ensuite, on regarde la hiérarchie
                                            delink_supertypes($t);
                                            delink_children($t);
                                        }
                                        // Enfin, quoi qu'il arrive, on l'ajoute
                                        $new_group->create_link($t->id());
                                    } else {
                                        $error = "ERREUR";
                                    }
                                }
                            } else {
                                $error = "ERREUR";
                            }
                        }
                    }
                    // Ensuite, on récupère tous les groupes liés non traités
                    foreach ($linked_groups as $group) {
                        if ($is_full) {
                            // Si full : simplement supprimer
                            $group->delete();
                        } else {
                            // On vérifie les types
                            $types = Type::linked('config_horizon_type', 'type', $group->id());
                            $keep = false;
                            foreach ($types as $t) {
                                if (in_array($t->code(), $non_used_types)) {
                                    DatabaseObject::delink('config_horizon_type', 'type', $group->id(), $t->id());
                                    unset($already_linked_types[$t->code()]);
                                } else {
                                    $keep = true;
                                }
                            }
                            if (!$keep) {
                            // Si plus de types dans le groupe, on le supprime
                            $group->delete();
                            }
                        }
                    }
                }
            } else {
                if (!isset($error)) {
                    $error = "ERREUR";
                }
            }
        } else {
            $error = "ERREUR";
        }
        // Envoi de la réponse
        $json_response = [
            'id'   => $config->id(),
            'name' => $config_name
        ];
        break;
    case "delete_config_seriation":
        // Initialisation des variables spécifiques
        $config_id   = $params['configId'];

        $config = ConfigHorizon::find_by_id($config_id);
        if ($config) {
            if ($config->owner_rights()) {
                $success = $config->delete(false);
            } else {
                $success = false;
                $error = "ERREUR"; // Pas les droits
            }
        } else {
            $success = false;
            $error = "ERREUR"; // N'existe pas
        }
        // Envoi de la réponse
        $json_response = [
            'success' => $success,
        ];
        break;
    case "load_config_seriation":
        // Initialisation des variables spécifiques
        $type       = $params['type'];
        $config_id = $params['configId'];
        $config = ConfigHorizon::find_by_id($config_id);
        if ($config) {
            if ($config->contributor_rights()) {
                // Gestion distincte entre les types
                if ($type === 'inventory') {
                    $list_items = [];
                    $config_type = $config->type();
                    if ($config_type === 'phases') {
                        // On va chercher tous les items
                        $phases = Phase::linked('config_horizon', 'phase_or_context', $config->id());
                        foreach ($phases as $phase) {
                            if ($phase->contributor_rights()) {
                                $list_items[] = ['site'=>$phase->related_site()->name(), 'code'=>$phase->code(), 'color'=>$config->color($phase->id())];
                            }
                        }
                    } elseif ($config_type === 'contexts') {
                        // On va chercher tous les items
                        $contexts = Context::linked('config_horizon', 'phase_or_context', $config->id());
                        foreach ($contexts as $context) {
                            if ($context->contributor_rights()) {
                                $list_items[] = ['site'=>$context->related_phase()->related_site()->name(), 'code'=>$context->code(), 'color'=>$config->color($context->id())];
                            }
                        }
                    }
                    // Préparation réponse
                    $json_response = [
                        'configType' => $config_type,
                        'listItems'  => $list_items,
                        'error'      => false
                    ];
                } elseif ($type === 'types') {
                    $list_groups = [];
                    // On récupère tous les groupes liés
                    $groups = ConfigHorizonType::find_by_parent($config->id());
                    foreach ($groups as $g) {
                        $group = [
                            'name'  => $g->name(),
                            'types' => []
                        ];
                        $types = Type::linked('config_horizon_type', 'type', $g->id());
                        foreach ($types as $t) {
                            if (!isset($group['typology'])) {
                                $group['typology'] = $t->typology()->code();
                            }
                            $group['types'][] = ['code' => $t->code(), 'name' => $t->name()];
                        }
                        $list_groups[] = $group;
                    }
                    // Préparation réponse
                    $json_response = [
                        'listGroups' => $list_groups,
                        'error'      => false
                    ];
                } else {
                    $error = "ERREUR";
                }
            } else {
                $error = "ERREUR";
            }
        } else {
            $error = "ERREUR";
        }

        if (!isset($json_response)) {
            // Envoi de la réponse
            $json_response = [
                'error' => $error,
            ];
        }
        break;
    case "update_types_showed":
        // Initialisation des variables spécifiques
        $mode       = $params['mode'];
        $list_items = $params['listItems'];
        $listing    = [];
        $nodes      = []; // Utilisé pour cacher des références vers les noeuds déjà créés
        $types_code = [];
        // Parcourt la liste des phases ou contextes
        foreach ($list_items as $item) {
            // Initialisation distincte selon phase ou contexte
            $contexts = [];
            $site = Site::find_by_name($item['site']);
            if ($site && $mode === 'phases') {
                $phase = Phase::find_by_site_code($site->id(), $item['code']);
                if ($phase) {
                    $c = Context::find_by_parent($phase->id());
                    if ($c) {
                        $contexts = $c;
                    }
                }
            } elseif ($site && $mode === 'contexts') {
                $context = Context::find_by_site_code($site->id(), $item['code']);
                if ($context) {
                    $contexts = [$context];
                }
            }
            // Par contexte
            foreach ($contexts as $c) {
                $objects = ObjectTable::find_by_parent($c->id());
                // On parcourt les objets
                error_log(count($objects));
                foreach ($objects as $o) {
                    $type = $o->type_link();
                    // Si le type existe sans variante ou doute, on l'ajoute aux identifiants
                    if ($type && !$o->type_var() && !$o->type_doubt()) {
                        if (!isset($types_code[$type->code()])) {
                            $types_code[$type->code()] = 1;
                        } else {
                            $types_code[$type->code()] += 1;
                        }
                    }
                }
            }
        }
        // Une fois qu'on a la liste des ID, on peut recréer la liste
        foreach ($types_code as $code => $count) {
            $type = Type::find_by_code($code);
            if (!$type) {
                error_log("Type introuvable : " . $code);
                continue;
            }
            // D'abord, la typologie
            $typology = $type->typology();
            $typology_code = $typology->code();
            if (!isset($listing[$typology_code])) {
                $listing[$typology_code] = [
                    'name' => $typology->codename(),
                    'types' => []
                ];
                $nodes[$typology_code] = &$listing[$typology_code];
            }
            // Ensuite, le type
            // On remonte la hiérarchie
            $current = $type;
            $parent_node = &$listing[$typology_code]['types'];
            $path = [];
            while ($current) {
                $path[] = $current;
                $current = $current->supertype();
            }

            // On parcourt la hiérarchie à l'envers et on la crée si besoin
            foreach (array_reverse($path) as $i => $t) {
                $code_type = $t->code();
                if (!isset($parent_node[$code_type])) {
                    $parent_node[$code_type] = [
                        'name'  => $t->name(),
                        'types' => []
                    ];
                    $nodes[$code_type] = &$parent_node[$code_type];
                }
                // Ajouter le count uniquement au type initial
                if ($i === count($path) - 1) {
                    $parent_node[$code_type]['count'] = $types_code[$t->code()];
                }
                // Descendre d'un niveau
                $parent_node = &$parent_node[$code_type]['types'];
            }
        }
        // Envoi de la réponse
        $json_response = [
            'typeList' => $listing,
        ];
        break;
    case "make_seriation":
        // Fonction récursive pour check types avec hiérarchie
        function is_type_in_group($type) {
            global $types_groups;
            // Si pas de type, on arrête
            if (!$type) { return false; }
            // Vérifie si le code du type est dans $types_groups
            if (isset($types_groups[$type->code()])) { return $type->code(); }
            // Sinon, on remonte au supertype
            return is_type_in_group($type->supertype(), $types_groups);
        }
        // Récupération des données spécifiques
        // phases ou contexts
        $mode = $params['mode'];
        // Liste des phases ou contextes, avec clés "site" (nom), code et color (identifiant ou RGB spécifique)
        $list_items = $params['listItems'];
        usort($list_items, function($a, $b) {
            // On compare d'abord par 'site'
            $cmp = strcmp($a['site'], $b['site']);
            if ($cmp === 0) {
                // Si les sites sont identiques, on compare par 'code'
                return strcmp($a['code'], $b['code']);
            }
            return $cmp;
        });
        // Clé = nom des types, avec en valeur le groupe
        $types_groups = $params['usedTypesWithGroup'];
        // Array du nom des groupes
        $groups = $params['groups'];
        sort($groups);
        // Valeur prise par la méthode de comptage
        $counting_method_id = intval($params['countingMethod']);
        // n_rim, n_wall...
        if ($counting_method_id === 1) {
            $counting_parts = $params['countingParts']; // n_rim, n_wall...
        }

        // Premier objectif : récupérer une liste des contextes ou phases avec organisation par type présent
        // La sous-liste par contexte ou phase doit être standardisée
        // On crée aussi la liste des groupes
        $list_groups = [];
        $groups_info = [];
        $index = 0;
        foreach ($groups as $g) {
            $list_groups[$g] = 0;
            $groups_info[$g] = ['index' => $index, 'total' => 0];
            $index++;
        }

        // Initialisation du tableau
        $table_results = [];

        // On parcourt ensuite la liste des phases ou contextes pour créer le tableau
        $index = 0;
        foreach ($list_items as $item) {
            if (ctype_digit($item['color'])) {
                $cval = strval($item['color']);
                $color = COLORS_HORIZONS_ADVANCED_1[$cval]['rgb'];
            } else {
                $color = $item['color'];
            }
            // On prépare l'array
            $array_item = [
                'site'  => $item['site'],
                'code'  => $item['code'],
                'mode'  => $mode,
                'index' => $index,
                'color' => $color,
                'total' => 0,
                'types' => $list_groups
            ];
            // Initialisation distincte selon phase ou contexte
            $contexts = [];
            $site = Site::find_by_name($item['site']);
            if ($site && $mode === 'phases') {
                $phase = Phase::find_by_site_code($site->id(), $item['code']);
                if ($phase && ($phase->public() || $phase->contributor_rights())) {
                    $item_id = $phase->id();
                    $context = Context::find_by_parent($phase->id());
                    foreach ($context as $c) {
                        if ($c && ($c->public() || $c->contributor_rights())) {
                            $contexts[] = $c;
                        }
                    }
                }
            } elseif ($site && $mode === 'contexts') {
                $context = Context::find_by_site_code($site->id(), $item['code']);
                if ($context && ($context->public() || $context->contributor_rights())) {
                    $item_id = $context->id();
                    $contexts = [$context];
                }
            }
            // Par contexte
            foreach ($contexts as $c) {
                // D'abord, check comptage nécessaire si choix du NR pour ce contexte
                if ($counting_method_id === 3) {
                    $countings = Counting::linked('counting', 'site', $site->id(), true);
                    $has_nr = false;
                    $has_bfap = false;
                    foreach ($countings as $c) {
                        if ($c->id() === 1) {
                            $has_bfap = true;
                        } elseif ($c->id() === 3) {
                            $has_nr = true;
                        }
                    }
                    if ($has_bfap && !$has_nr) {
                        $by_nr = true;
                    } else {
                        $by_nr = false;
                    }
                }
                $objects = ObjectTable::find_by_parent($c->id());
                // On parcourt les objets
                error_log(count($objects));
                foreach ($objects as $o) {
                    $type = is_type_in_group($o->type_link());
                    // Si le type est compris dans ceux choisis sans variante ou doute, on effectue le comptage
                    if ($type && !$o->type_var() && !$o->type_doubt()) {
                        // On extrait la valeur à additionner
                        $count = 0;
                        if ($counting_method_id === 1) {
                            // Par type de partie
                            foreach ($counting_parts as $cp) {
                                $count += $o->$cp();
                            }
                        } elseif ($counting_method_id === 2) {
                            // NMI
                            $count = $o->n_mni();
                        } elseif ($counting_method_id === 3) {
                            // NR
                            if ($by_nr) {
                                $count = $o->n_sherd();
                            } else {
                                foreach (['n_rim', 'n_bottom', 'n_handle', 'n_wall'] as $cp) {
                                    $count += $o->$cp();
                                }
                            }
                        } else {
                            // Nombre d'occurence ou valeur erronée
                            $count = 1;
                        }
                        // On ajoute au compte du type
                        $array_item['types'][$types_groups[$type]] += $count;
                        // On ajoute au compte de l'item
                        $array_item['total'] += $count;
                        // On ajoute au compte du group
                        $groups_info[$types_groups[$type]]['total'] += $count;
                    }
                }
            }
            // Enfin, on l'ajoute à l'array générale
            if ($item_id) {
                $table_results[$index] = $array_item;
            }
            $index++;
        }

        // Sériation par calcul des barycentres
        $is_changed = true;
        $go_types = false;
        while ($is_changed) {
            if ($go_types) {
                $results = barycentre_types($table_results, $groups_info);
                $go_types = false;
                $groups_info = $results['groups_info'];
            } else {
                $results = barycentre_inventory($table_results, $groups_info);
                $go_types = true;
                $table_results = $results['table_results'];
            }
            $is_changed = $results['changes'];
        }

        // On trie le groupe par rapport à l'index
        uasort($groups_info, function($a, $b) {
            return $a['index'] <=> $b['index']; // opérateur spaceship
        });

        // Création de la table
        $table_html = "<table class='table table-sm table-bordered' id='seriation_table' style='font-size:small'>
            <thead><tr>";
        // Header items
        $table_html .= "<th style='position: sticky; top: 0; left:0; background: white; z-index: 3;'>" . ucfirst(thesaurus($mode)) . "</th>";
        // Header types
        foreach ($groups_info as $name => $content) {
            $table_html .= "<th class='vertical-header' style='position: sticky; top: 0; background: white; z-index: 2;'>" . $name . "</th>";
        }
        // Header barycentre
            $table_html .= "<th style='position: sticky; top: 0; background: white; z-index: 2;'>Barycentre</th>";
        // Fin header
        $table_html .= "</tr></thead><tbody>";
        // Ligne par phase ou contexte
        foreach ($table_results as $el) {
            $table_html .= "<tr style='background:" . $el['color'] . "'>";
            // Nom de la phase ou contexte
            $table_html .= "<td style='position: sticky; left: 0; background:" . $el['color'] . "; z-index: 1;'><b>" . $el['code'] . "</b></td>";
            foreach ($groups_info as $name => $content) {
                $type_count = $el['types'][$name];
                if ($type_count === 0) {
                    $table_html .= "<td style='text-align:center'>-</td>";
                } else {
                    $table_html .= "<td style='text-align:center'>" . $type_count . "</td>";
                }
            }
            // On ajoute le barycentre
            $table_html .= "<td>" . $el['barycentre'] . "</td>";
            $table_html .= "</tr>";
        }
        // On ajoute la ligne des barycentres
        $table_html .= "<tr><td>Barycentres types</td>";
        foreach ($groups_info as $content) {
            $table_html .= "<td style='writing-mode:vertical-rl; transform:rotate(180deg); text-align:end;'>" . $content['barycentre'] . "</td>";
        }
        $table_html .= "<td>/</td></tr>";
        $table_html .= "</tbody></table>";

        // Réponse donnée
        $json_response = [
            'tableResults' => $table_results,
            'tableHTML'    => $table_html,
            'groupsInfo'   => $groups_info
        ];
        break;
    case "seriation_reverse":
        // Récupération des données spécifiques
        $mode            = $params['mode'];
        $table_results   = $params['tableItems'];
        $groups_info_old = $params['groupsInfo'];

        // On retourne l'info des groupes pour initier un basculement
        $groups_info = array_reverse($groups_info_old, true);
        $reindex = 0;
        foreach ($groups_info as $name => $content) {
            $groups_info[$name]['index'] = $reindex;
            $reindex++;
        }

        // Sériation par calcul des barycentres
        $is_changed = true;
        $go_types = false;
        while ($is_changed) {
            if ($go_types) {
                $results = barycentre_types($table_results, $groups_info);
                $go_types = false;
                $groups_info = $results['groups_info'];
            } else {
                $results = barycentre_inventory($table_results, $groups_info);
                $go_types = true;
                $table_results = $results['table_results'];
            }
            $is_changed = $results['changes'];
        }

        // On trie le groupe par rapport à l'index
        uasort($groups_info, function($a, $b) {
            return $a['index'] <=> $b['index']; // opérateur spaceship
        });

        // Création de la table
        $table_html = "<table class='table table-sm table-bordered' id='seriation_table' style='font-size:small'>
            <thead><tr>";
        // Header items
        $table_html .= "<th style='position: sticky; top: 0; left: 0; background: white; z-index: 3;'>" . ucfirst(thesaurus($mode)) . "</th>";
        // Header types
        foreach ($groups_info as $name => $content) {
            $table_html .= "<th class='vertical-header' style='position: sticky; top: 0; background: white; z-index: 2;'>" . $name . "</th>";
        }
        // Header barycentre
        $table_html .= "<th class='vertical-header' style='position: sticky; top: 0; background: white; z-index: 2;'>Barycentre</th>";
        // Fin header
        $table_html .= "</tr></thead><tbody>";
        // Ligne par phase ou contexte
        foreach ($table_results as $el) {
            $table_html .= "<tr style='background:" . $el['color'] . "'>";
            // Nom de la phase ou contexte
            $table_html .= "<td style='position: sticky; left: 0; background:" . $el['color'] . "; z-index: 1;'><b>" . $el['code'] . "</b></td>";
            foreach ($groups_info as $name => $content) {
                $type_count = $el['types'][$name];
                if ($type_count === 0) {
                    $table_html .= "<td style='text-align:center'>-</td>";
                } else {
                    $table_html .= "<td style='text-align:center'>" . $type_count . "</td>";
                }
            }
            // On ajoute le barycentre
            $table_html .= "<td>" . $el['barycentre'] . "</td>";
            $table_html .= "</tr>";
        }
        // On ajoute la ligne des barycentres
        $table_html .= "<tr><td>Barycentres types</td>";
        foreach ($groups_info as $content) {
            $table_html .= "<td style='writing-mode:vertical-rl; transform:rotate(180deg); text-align:end;'>" . $content['barycentre'] . "</td>";
        }
        $table_html .= "<td>/</td></tr>";
        $table_html .= "</tbody></table>";
        // Réponse donnée
        $json_response = [
            'tableResults' => $table_results,
            'tableHTML'    => $table_html,
            'groupsInfo'   => $groups_info
        ];
        break;
    case "correspondence_analysis":
        // Récupération des données spécifiques
        $table_results = $params['tableItems'];
        $groups_info   = $params['groupsInfo'];
        $mode          = $params['mode'];

        // On enlève les cas où le total est égal à 0 (crée des erreurs)
        foreach ($table_results as $key=>$value) {
            if ($table_results[$key]['total'] === 0) {
                unset($table_results[$key]);
            }
        }
        foreach ($groups_info as $key=>$value) {
            if ($groups_info[$key]['total'] === 0) {
                unset($groups_info[$key]);
            }
        }

        // Calcul du total
        $total_count = 0;
        foreach ($groups_info as $key=>$value) {
            $total_count += $value['total'];
        }

        // Calcul des masses et profils des items et types
        // Les masses sont les proportions de chaque item ou type par rapport au total général
        // Les profils sont les proportions de chaque cellule de ligne ou colonne (item ou type) par rapport à son total
        foreach ($table_results as $key=>$value) {
            $table_results[$key]['row_mass'] = $value['total'] / $total_count;
            foreach ($value['types'] as $type=>$count) {
                $table_results[$key]['types'][$type] = [
                    'count'          => $count,
                    'row_profile'    => $count / $value['total'],
                    'column_profile' => $count / $groups_info[$type]['total']
                ];
            }
        }
        foreach ($groups_info as $key=>$value) {
            $groups_info[$key]['column_mass'] = $value['total'] / $total_count;
        }

        // Calcul d'une table de khi-deux des items
        // Le Khi-deux est calculé en aditionnant les carrés des distances entre chaque profil de types des deux items comparés, chaque carré divisé par la masse du type
        // Cela permet d'avoir une mesure sur l'éloignement de chaque item par rapport à un autre item
        $khi2_items = [];
        $khi2_max = 0;
        $khi2_sum = 0;
        // Double sélection des tables de résultats pour la comparaison entre elles
        foreach ($table_results as $key1 => $value1) {
            $khi2_items[$value1['code']] = [];
            foreach ($table_results as $key2 => $value2) {
                // Calcul d'un khi-2 sur les deux lignes i et j
                $khi2 = 0;
                foreach ($groups_info as $type=>$value) {
                    $difference = $value1['types'][$type]['row_profile'] - $value2['types'][$type]['row_profile'];
                    $khi2 += $difference * $difference / $value['column_mass'];
                }
                // Intégration à la table des khi-2
                $khi2_items[$value1['code']][$value2['code']] = $khi2;
                // Modification du maximal et de la somme (pour moyenne)
                if ($khi2 > $khi2_max) { $khi2_max = $khi2; }
                $khi2_sum += $khi2;
            }
        }
        // Calcul de la moyenne
        $khi2_mean = $khi2_sum / (count($table_results) * count($table_results));

        // Calcul de la matrice centrale
        foreach ($table_results as $key => $content) {
            foreach ($content['types'] as $type => $values) {
                // Expected frequency : On calcule la valeur attendue si le tableau était 100% homogène (en fonction des tailles de types et colonnes)
                $table_results[$key]['types'][$type]['count_expected'] = $table_results[$key]['row_mass'] * $groups_info[$type]['column_mass'] * $total_count;
                // Raw residual : Ici, on calcule l'effectif en plus ou en moins (résidu brut)
                $table_results[$key]['types'][$type]['raw_residual']   = $table_results[$key]['types'][$type]['count'] - $table_results[$key]['types'][$type]['count_expected'];
                // Relative frequency : On calcule la proportion que représente cette case par rapport au total
                $table_results[$key]['types'][$type]['proportion']     = $table_results[$key]['types'][$type]['count'] / $total_count;
                // Expected proportion : Valeur attendue en proportion si tableau homogène
                $table_results[$key]['types'][$type]['prop_expected']  = ($table_results[$key]['row_mass'] * $groups_info[$type]['column_mass']);
                // Proportional residual : Proportion en plus ou en moins (résidu en proportions)
                $table_results[$key]['types'][$type]['prop_residual']  = $table_results[$key]['types'][$type]['proportion'] - $table_results[$key]['types'][$type]['prop_expected'];
                // Enfin, matrice centrale (standardized residual/centralized matrix entry) : proportion résiduelle / racine carrée de ce qui est attendu (dénominateur sert à homogénéiser les échelles)
                $table_results[$key]['types'][$type]['z_matrix']       = $table_results[$key]['types'][$type]['prop_residual'] / sqrt($table_results[$key]['types'][$type]['prop_expected']);
            }
        }

        // Singular Value Decomposition
        // D'abord, produit croisé des colonnes (matrice C)
        // En même temps, on va calculer la trace (somme des diagonales)
        $row_crosstab = [];
        $c_trace = 0;
        // Double sélection des tables de résultats pour la comparaison entre elles
        foreach ($groups_info as $type1 => $value1) {
            $row_crosstab[$type1] = [];
            foreach ($groups_info as $type2 => $value2) {
                // Calcul du produit croisé
                $crosstab = 0;
                foreach ($table_results as $key => $content) {
                    $crosstab += $content['types'][$type1]['z_matrix'] * $content['types'][$type2]['z_matrix'];
                }
                // Intégration à la table des produits croisés
                $row_crosstab[$type1][$type2] = $crosstab;
                // Vérification de si c'est une diagonale
                if ($type1 === $type2) {
                    $c_trace += $crosstab;
                }
            }
        }

        // Ca se complique
        // Fonctions nécessaires
        // Norme euclidienne (longueur du vecteur, pythagore)
        function vec_norm(array $v): float {
            $sum = 0.0;
            foreach ($v as $val) {
                $sum += $val * $val;
            }
            return sqrt($sum);
        }

        // Produit scalaire (somme des multiplications de deux vecteurs de même longueur)
        function vec_dot(array $a, array $b): float {
            $sum = 0.0;
            for ($i = 0; $i < count($a); $i++) {
                $sum += $a[$i] * $b[$i];
            }
            return $sum;
        }

        // Matrice (nxn) × vecteur (n)
        function mat_vec(array $M, array $x): array {
            // On crée une array Y
            $y = array_fill(0, count($M), 0.0);
            $i = 0;
            foreach ($M as $key=>$sub) {
                $sum = 0.0;
                $j = 0;
                foreach ($sub as $key2=>$val) {
                    // Pour chaque ligne de la matrice, on va effectuer le produit scalaire avec le vecteur
                    $sum += $val * $x[$j];
                    $j++;
                }
                // Et on intègre la liste des produits scalaires dans un nouveau vecteur
                $y[$i] = $sum;
                $i++;
            }
            return $y;
        }

        // Normalisation d’un vecteur (sa longueur fera 1)
        function vec_normalize(array $v): array {
            // On prend la norme euclidienne du vecteur
            $nrm = vec_norm($v);
            // Si la somme est nulle, on retourne le vecteur
            if ($nrm == 0.0) {
                return $v;
            }
            for ($i = 0; $i < count($v); $i++) {
                // Sinon, on divise le vecteur par la norme
                $v[$i] /= $nrm;
            }
            return $v;
        }

        // Fonction d'itération de puissance
        function power_iteration (array $row_crosstab, int $max_iter = 1000, float $tol = 1e-8, int $time_limit = 30): array {
            // Point de départ
            $start_time = microtime(true);

            // Vecteur initial (randomisé)
            $x = array_fill(0, count($row_crosstab), rand());
            $x = vec_normalize($x);

            $lambda_prev = 0.0;
            $lambda = 0.0;
            for ($iter = 0; $iter < $max_iter; $iter++) {
                // Vérifie le temps écoulé
                $elapsed = microtime(true) - $start_time;
                if ($elapsed > ($time_limit - 1)) {
                    // On arrête avant de dépasser la limite
                    break;
                }
                
                // y = C x (produit de C par x) (puis normalisation)
                $y = mat_vec($row_crosstab, $x);
                $x_next = vec_normalize($y);

                // Rayleigh quotient lambda = x_next^T C x_next
                $crosstab_x = mat_vec($row_crosstab, $x_next);
                $lambda = vec_dot($x_next, $crosstab_x);

                // Critère d'arrêt (cchangement petit sur x et lambda)
                // Ici, c'est la racine carrée des sommes des carrés des différences entre x_next et x
                $dx = 0.0;
                for ($i = 0; $i < count($x); $i++) {
                    $diff = $x_next[$i] - $x[$i];
                    $dx += $diff * $diff;
                }
                $dx = sqrt($dx);

                if ($dx < $tol && abs($lambda - $lambda_prev) < $tol) {
                    $x = $x_next;
                    break;
                }

                // Mise à jour
                $x = $x_next;
                $lambda_prev = $lambda;
            }

            // Calcul du sigma
            $sigma = sqrt($lambda);

            // Sanity check: ||C v1 - lambda1 v1||
            $res = 0.0;
            $crosstab_v = mat_vec($row_crosstab, $x);
            for ($i = 0; $i < count($x); $i++) {
                $diff = $crosstab_v[$i] - $lambda * $x[$i];
                $res += $diff * $diff;
            }
            $res = sqrt($res);
            // Résultats pour l'axe calculé
            return [
                'lambda'    => $lambda,
                'sigma'     => $sigma,
                'vector'    => $x,
                'residual'  => $res
            ];
        }

        // Déflation (on cherche à comprendre plus tard). D'abord fonctions utilitaires
        // Produit extérieur (outer product) : u v^T
        function outer(array $u, array $v): array {
            $n = count($u);
            $M = array_fill(0, $n, array_fill(0, $n, 0.0));
            for ($i = 0; $i < $n; $i++) {
                for ($j = 0; $j < $n; $j++) {
                    $M[$i][$j] = $u[$i] * $v[$j];
                }
            }
            return $M;
        }

        // Soustraction de matrices
        function mat_sub(array $A, array $B): array {
            $M = $A;
            $i = 0;
            foreach ($M as $key1=>$sub) {
                $j = 0;
                foreach ($sub as $key2=>$content) {
                    $M[$key1][$key2] = $A[$key1][$key2] - $B[$i][$j];
                    $j++;
                }
                $i++;
            }
            return $M;
        }

        // Déflation : C_new = C - lambda * (v v^T)
        function deflate_matrix(array $C, float $lambda, array $v): array {
            $outer = outer($v, $v);
            $n = count($outer);
            // Multiplie chaque élément par lambda
            for ($i = 0; $i < $n; $i++) {
                for ($j = 0; $j < $n; $j++) {
                    $outer[$i][$j] *= $lambda;
                }
            }
            // Soustrait à C
            $C_new = mat_sub($C, $outer);
            return $C_new;
        }

        $max_vectors = 20;
        $n_axes = 1;
        $values_power_iteration = [];
        $C = $row_crosstab;

        if (!isset($time_limit) || $time_limit < 60) {
            $time_limit = 60;
        } elseif ($time_limit > 600) {
            $time_limit = 600;
        }
        $axe_numbers = min($max_vectors, count($groups_info) - 1, count($table_results) -1);
        set_time_limit($time_limit);
        // On fait le nombre de fois maximal (selon règles)
        while ($n_axes < $max_vectors && $n_axes < (count($groups_info) - 1) && $n_axes < (count($table_results) - 1)) {
            $values_power_iteration['axe' . $n_axes] = power_iteration($C, 1000, 1e-8, round($time_limit/$axe_numbers));
            $C = deflate_matrix($C, $values_power_iteration['axe' . $n_axes]['lambda'], $values_power_iteration['axe' . $n_axes]['vector']);
            $n_axes++;
        }
        set_time_limit(30);
        // On en fait un dernier, mais qui n'est peut-être pas pertinent
        $values_power_iteration['axe' . $n_axes] = power_iteration($C);
        // Vérification nécessaire
        if (is_nan($values_power_iteration['axe' . $n_axes]['sigma'])) {
            unset($values_power_iteration['axe' . $n_axes]);
            $n_axes--;
        }
        
        // Calcul des coordonnées symétriques des colonnes et lignes
        // Ainsi que les coordonnées principales

        // On prépare d'abord des infos sur les valeurs max et min des coordonnées
        $info_coord = [];
        foreach ($values_power_iteration as $axe_name => $axe_values) {
            $info_coord[$axe_name] = [
                'coords_sym' => ['min' => 0, 'max' => 0],
                'coords_p' => ['min' => 0, 'max' => 0],
                'coords_p_col' => ['min' => 0, 'max' => 0],
                'coords_p_row' => ['min' => 0, 'max' => 0],
            ];
        }
        
        // Pour chaque axe, on calcule les coordonnées de chaque colonne
        // en multipliant le vecteur par le sigma de l'itération de puissance correspondante
        $j = 0;
        foreach ($groups_info as $type => $col_values) {
            $groups_info[$type]['coords_sym'] = [];
            $groups_info[$type]['coords_p'] = [];
            foreach ($values_power_iteration as $axe_name => $axe_values) {
                $groups_info[$type]['coords_sym'][$axe_name] = $axe_values['vector'][$j] * $axe_values['sigma'];
                // En principal : on divise par la racine carrée de 'column_mass'
                $groups_info[$type]['coords_p'][$axe_name] = $groups_info[$type]['coords_sym'][$axe_name] / sqrt($groups_info[$type]['column_mass']);
                // Principal cologne avec standard lignes
                $groups_info[$type]['coords_p_col'][$axe_name] = $groups_info[$type]['coords_sym'][$axe_name] / sqrt($groups_info[$type]['column_mass']);
                // On vérifie les coordonnées min et max
                if ($info_coord[$axe_name]['coords_sym']['min'] > $groups_info[$type]['coords_sym'][$axe_name]) {
                    $info_coord[$axe_name]['coords_sym']['min'] = $groups_info[$type]['coords_sym'][$axe_name];
                }
                if ($info_coord[$axe_name]['coords_sym']['max'] < $groups_info[$type]['coords_sym'][$axe_name]) {
                    $info_coord[$axe_name]['coords_sym']['max'] = $groups_info[$type]['coords_sym'][$axe_name];
                }
                if ($info_coord[$axe_name]['coords_p']['min'] > $groups_info[$type]['coords_p'][$axe_name]) {
                    $info_coord[$axe_name]['coords_p']['min'] = $groups_info[$type]['coords_p'][$axe_name];
                }
                if ($info_coord[$axe_name]['coords_p']['max'] < $groups_info[$type]['coords_p'][$axe_name]) {
                    $info_coord[$axe_name]['coords_p']['max'] = $groups_info[$type]['coords_p'][$axe_name];
                }
                if ($info_coord[$axe_name]['coords_p_col']['min'] > $groups_info[$type]['coords_p_col'][$axe_name]) {
                    $info_coord[$axe_name]['coords_p_col']['min'] = $groups_info[$type]['coords_p_col'][$axe_name];
                }
                if ($info_coord[$axe_name]['coords_p_col']['max'] < $groups_info[$type]['coords_p_col'][$axe_name]) {
                    $info_coord[$axe_name]['coords_p_col']['max'] = $groups_info[$type]['coords_p_col'][$axe_name];
                }
            }
            $j++;
        }

        // Le calcul des lignes est un peu plus compliqué :
        foreach ($table_results as $index => $content) {
            $table_results[$index]['coords_sym'] = [];
            $table_results[$index]['coords_p'] = [];
            // produit Z x v_k
            foreach ($values_power_iteration as $axe_name => $axe_values) {
                $sum = 0.0;
                $j = 0;
                foreach ($content['types'] as $type => $col_values) {
                    $sum += $col_values['z_matrix'] * $axe_values['vector'][$j];
                    $j++;
                }
                $table_results[$index]['coords_sym'][$axe_name] = $sum;
                // En principal : on divise par la racine carrée de 'row_mass'
                $table_results[$index]['coords_p'][$axe_name] = $sum / sqrt($table_results[$index]['row_mass']);
                // Barycentrique pour principale colonne
                $sum = 0.0;
                foreach ($groups_info as $type => $col_values) {
                    $p_ij = $table_results[$index]['types'][$type]['count'] / $total_count;
                    $sum += ($p_ij / $table_results[$index]['row_mass']) * $groups_info[$type]['coords_p'][$axe_name];
                }
                $table_results[$index]['coords_p_col'][$axe_name] = $sum / $values_power_iteration[$axe_name]['sigma'];
                // On vérifie les coordonnées min et max
                if ($info_coord[$axe_name]['coords_sym']['min'] > $table_results[$index]['coords_sym'][$axe_name]) {
                    $info_coord[$axe_name]['coords_sym']['min'] = $table_results[$index]['coords_sym'][$axe_name];
                }
                if ($info_coord[$axe_name]['coords_sym']['max'] < $table_results[$index]['coords_sym'][$axe_name]) {
                    $info_coord[$axe_name]['coords_sym']['max'] = $table_results[$index]['coords_sym'][$axe_name];
                }
                if ($info_coord[$axe_name]['coords_p']['min'] > $table_results[$index]['coords_p'][$axe_name]) {
                    $info_coord[$axe_name]['coords_p']['min'] = $table_results[$index]['coords_p'][$axe_name];
                }
                if ($info_coord[$axe_name]['coords_p']['max'] < $table_results[$index]['coords_p'][$axe_name]) {
                    $info_coord[$axe_name]['coords_p']['max'] = $table_results[$index]['coords_p'][$axe_name];
                }
                if ($info_coord[$axe_name]['coords_p_col']['min'] > $table_results[$index]['coords_p_col'][$axe_name]) {
                    $info_coord[$axe_name]['coords_p_col']['min'] = $table_results[$index]['coords_p_col'][$axe_name];
                }
                if ($info_coord[$axe_name]['coords_p_col']['max'] < $table_results[$index]['coords_p_col'][$axe_name]) {
                    $info_coord[$axe_name]['coords_p_col']['max'] = $table_results[$index]['coords_p_col'][$axe_name];
                }
            }
        }

        $values_power_iteration['axe' . $n_axes]['lambda'];
        // On prépare le tableau des valeurs propres et pourcentages
        $table_html = "<h5>Table des valeurs propres avec pourcentage<sup>*</sup> expliqué</h5><div class='table-responsive'>";
        // Création de la table
        $table_html .= "<table class='table table-sm table-bordered' id='ca_eigenvalue_table' style='font-size:small'>
            <thead><tr>";
        // Header items
        $table_html .= "<th>" . 'Valeur/Axe' . "</th>";
        // Header types
        foreach ($values_power_iteration as $key => $content) {
            $table_html .= "<th>" . str_replace('axe', '', $key) . "</th>";
        }
        // Fin header
        $table_html .= "</tr></thead><tbody>";
        // Ligne des valeurs lambda
        $table_html .= "<tr><td><b>" . "Valeurs propres" . "</b></td>";
        $lambda_sum = 0.0;
        foreach ($values_power_iteration as $key => $content) {
            $lambda_sum += $content['lambda'];
            $lambda = round($content['lambda'], 3);
            $table_html .= "<td>" . $lambda . "</td>";
        }
        $table_html .= "</tr>";
        // Ligne des pourcentages
        $table_html .= "<tr><td><b>" . "% du total" . "</b></td>";
        foreach ($values_power_iteration as $key => $content) {
            $percent = round(($content['lambda'] * 100 / $lambda_sum), 2);
            $table_html .= "<td>" . $percent . "%</td>";
        }
        $table_html .= "</tr>";

        // Ligne des pourcentages cumulés
        $table_html .= "<tr><td><b>" . "% cumulé" . "</b></td>";
        $lambda_cumul = 0.0;
        foreach ($values_power_iteration as $key => $content) {
            $lambda_cumul += $content['lambda'];
            $percent = round(($lambda_cumul * 100 / $lambda_sum), 2);
            $table_html .= "<td>" . $percent . "%</td>";
        }
        $table_html .= "</tr>";
        $table_html .= "</tbody></table></div>";
        // Ajout de l'explication
        $table_html .= "<div class='mb-2'><small><sup>*</sup> Le pourcentage est calculé sur les 20 premiers axes au maximum. Dans le cas de sériations complexes, il est surestimé et doit être vu comme un ordre de grandeur.</small></div>";

        // On crée la table des khi-2
        // Création de la table
        $khi2_table = "<div class='table-responsive'><table class='table table-sm table-bordered' id='ca_khi2_table' style='font-size:small'>
            <thead><tr>";
        // Header items
        $khi2_table .= "<th style='position: sticky; top: 0; left:0; background: white; z-index: 3;'>" . ucfirst(thesaurus($mode)) . "</th>";
        // Header types
        foreach ($table_results as $key=>$value) {
            $khi2_table .= "<th class='vertical-header' style='position: sticky; top: 0; background: white; z-index: 2;'>" . $value['code'] . "</th>";
        }
        // Fin header
        $khi2_table .= "</tr></thead><tbody>";
        // Création des lignes
        // Calcul de l'arrondi
        if ($khi2_max >= 50) {
            $round_khi2 = 0;
        } elseif ($khi_max >= 10) {
            $round_khi2 = 1;
        } else {
            $round_khi2 = 2;
        }
        foreach ($table_results as $key1 => $value1) {
            $khi2_table .= "<tr><td style='position: sticky; left: 0; background:white; z-index: 1;'><b>" . $value1['code'] . "</b></td>";
            foreach ($table_results as $key2 => $value2) {
                // Calcul des couleurs
                $khi2 = $khi2_items[$value1['code']][$value2['code']];
                if ($khi2 > $khi2_mean) {
                    // On va vers le rouge. Max = 166/95/93 ou A65F5D
                    $val_r = round(166 + ((($khi2_max - $khi2) / ($khi2_max - $khi2_mean)) * (255 - 166)));
                    $val_g = round(95 + ((($khi2_max - $khi2) / ($khi2_max - $khi2_mean)) * (255 - 95)));
                    $val_b = round(93 + ((($khi2_max - $khi2) / ($khi2_max - $khi2_mean)) * (255 - 93)));
                } else {
                    // On va vers le vert. 0 = 107/166/93 ou 6BA65D
                    $val_r = round(107 + (($khi2 / $khi2_mean) * (255 - 107)));
                    $val_g = round(166 + (($khi2 / $khi2_mean) * (255 - 166)));
                    $val_b = round(93 + (($khi2 / $khi2_mean) * (255 - 93)));
                }
                $back_color = "#" . dechex($val_r) . dechex($val_g) . dechex($val_b);
                $khi2_table .= "<td style='background:" . $back_color . ";'>" . round($khi2_items[$value1['code']][$value2['code']], $round_khi2) . "</td>";
            }
            $khi2_table .= "</tr>";
        }
        $khi2_table .= "</tbody></table></div>";

        $table_html .= "<h5>Table des khi2 (éloignement des ". thesaurus($mode) . " les uns par rapport aux autres)</h5><div class='table-responsive' style='max-height:600px'>" . $khi2_table . "</div>";

        // Réponse donnée
        $json_response = [
            'tableResultsCA' => $table_results,
            'groupsInfoCA'   => $groups_info,
            'limitsCoordCA'  => $info_coord,
            'axeCount'       => $n_axes,
            'tableEigenVal'  => $table_html,
            'modeTranslated' => ucfirst(thesaurus($mode))
        ];
        break;
    default:
        http_response_code(400);
        exit("Incorrect input");
}

// Réponse JSON
header('Content-Type: application/json');
echo json_encode($json_response);
exit;
?>