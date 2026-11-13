<?php

function barycentre_inventory ($table_results, $groups_info) {
    $b_list = [];
    // Calcul des barycentres individuels
    foreach ($table_results as $key => $item) {
        $total_types = $item['total'];
        // Sans types repris, barycentre non calculable
        if ($total_types === 0) {
            $b_corr = '/';
        } else {
            $b_sum = 0;
            foreach ($item['types'] as $type => $content) {
                $b_sum += $content * ($groups_info[$type]['index'] + 1);
            }
            $b_corr = $b_sum / $total_types;
        }
        $table_results[$key]['barycentre'] = $b_corr;
        // On récupère les données nécessaires pour les checks
        $b_list[] = $b_corr;
    }
    // On ordonne les valeurs des barycentres par ordre inversé
    rsort($b_list, SORT_NUMERIC);
    // On recrée une array selon les barycentres
    $new_index = 0;
    $new_table = [];
    $is_changed = false;
    // On parcourt tant qu'on n'a pas trouvé le barycentre correct
    while (count($table_results) > 0) {
        // On récupère le dernier barycentre restant
        $b_compare = array_pop($b_list);
        foreach ($table_results as $old_index => $item) {
            if ($item['barycentre'] === $b_compare) {
                // C'est le plus petit, on l'ajoute
                $new_table[$new_index] = $item;
                // On vérifie si le nouvel index est équivalent à l'ancie
                if ($new_index !== $old_index) {
                    // Si non, le tableau a changé
                    $is_changed = true;
                }
                // On retire de la table
                unset($table_results[$old_index]);
                $new_index++;
                break;
            }
        }
    }
    // Enfin, on renvoie le résultat
    return ['table_results' => $new_table, 'changes' => $is_changed];
}

function barycentre_types ($table_results, $groups_info) {
    $b_list = [];
    // Calcul des barycentres individuels
    foreach ($groups_info as $name => $content) {
        $total_items = $content['total'];
        // Sans item repris, barycentre non calculable
        if ($total_items === 0) {
            $b_corr = "/";
        } else {
            $b_sum = 0;
            foreach ($table_results as $index => $item) {
                $b_sum += ($index + 1) * $item['types'][$name];
            }
            $b_corr = $b_sum / $total_items;
        }
        $groups_info[$name]['barycentre'] = $b_corr;
        // On récupère les données nécessaires pour les checks
        $b_list[] = $b_corr;
    }
    // On ordonne les valeurs des barycentres par ordre inversé
    rsort($b_list, SORT_NUMERIC);
    // On recrée une array selon les barycentres
    $new_index = 0;
    $new_group = [];
    $is_changed = false;
    // On parcourt tant qu'on n'a pas trouvé le barycentre correct
    while (count($groups_info) > 0) {
        // On récupère le dernier barycentre restant
        $b_compare = array_pop($b_list);
        foreach ($groups_info as $name => $content) {
            if ($content['barycentre'] === $b_compare) {
                // C'est le plus petit, on l'ajoute
                // Avant, on vérifie l'index, et on le change éventuellement
                $old_index = $content['index'];
                if ($new_index !== $old_index) {
                    // Si non, le tableau a changé et on doit aussi changer l'index
                    $is_changed = true;
                    $content['index'] = $new_index;
                }
                $new_group[$name] = $content;
                // On retire de la table
                unset($groups_info[$name]);
                $new_index++;
                break;
            }
        }
    }
    // Enfin, on renvoie le résultat
    return ['groups_info' => $new_group, 'changes' => $is_changed];
}

?>