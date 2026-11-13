<?php
// Check site
$site = Site::find_by_owner_code($params['idowner'], dec_sl($params['codesite']));
if ($site) {
    if (!$site->public() && !$site->contributor_rights()) {
        $context = false;
    } elseif (!ISOLATED_WEBSITE && (!PROJECT || ($site->project() && $site->project()->id() !== PROJECT->id()))) {
        $context = false;
    }  else {
        /* Récupère les données de la phase */
        $phase = Phase::find_by_site_code($site->id(), dec_sl($params['codephase']));

        if ($phase) {
            /* Check si visible */
            if (!$phase->public() && !$phase->contributor_rights()) {
                $context = false;
            } else {
                $context = Context::find_by_phase_code($phase->id(), dec_sl($params['codecontext']));

                if ($context) {
                    /* Check si visible */
                    if (!$context->public() && !$context->contributor_rights()) {
                        $context = false;
                    }
                }
            }
        } else {
            $context = false;
        }
    }
} else {
    $context = false;
}

if ($context) {
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment;filename=inventory_context_' . $context->name() . '.csv');

    // BOM pour Excel
    echo "\xEF\xBB\xBF";

    $output = fopen('php://output', 'w');

    // Ligne de titre
    if ($context->biblio_review() && PROJECT->setting_litterature()) {
        fputcsv($output, template('csv_context_full'), ",");
    } else {
        fputcsv($output, template('csv_context'), ",");
    }

    // Chercher les objets
    $objects = ObjectTable::find_by_parent($context->id());
    foreach ($objects as $object) {
        if ($context->biblio_review() && $context->related_phase()->related_site()->project()->setting_litterature()) {
            // Afficher les inventaires
            fputcsv($output, [
                $object->number('simple'),
                $object->category('simple'),
                $object->category_litt(),
                $object->function('simple'),
                $object->function_litt(),
                $object->type('simple'),
                $object->type_litt(),
                $object->fabric('simple'),
                $object->fabric_litt(),
                $object->n_rim(),
                $object->n_bottom(),
                $object->n_handle(),
                $object->n_wall(),
                $object->n_mni(),
                $object->n_sherd(),
                $object->diameter(),
                $object->stamp(),
                $object->comment()
            ], ",");
        } else {
            // Afficher les inventaires
            fputcsv($output, [
                $object->number('simple'),
                $object->category('simple'),
                $object->function('simple'),
                $object->type('simple'),
                $object->fabric('simple'),
                $object->n_rim(),
                $object->n_bottom(),
                $object->n_handle(),
                $object->n_wall(),
                $object->n_mni(),
                $object->n_sherd(),
                $object->diameter(),
                $object->stamp(),
                $object->comment()
            ], ",");
        }
    }

    fclose($output);
} else {
    echo "404 NOT FOUND";
}

?>