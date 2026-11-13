<?php
// Check site
$site = Site::find_by_owner_code($params['idowner'], dec_sl($params['codesite']));
if ($site) {
    if (!$site->public() && !$site->contributor_rights()) {
        $site = false;
    } elseif (!ISOLATED_WEBSITE && (!PROJECT || ($site->project() && $site->project()->id() !== PROJECT->id()))) {
        $site = false;
    }
}

if ($site) {
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment;filename=inventory_site_' . $site->name() . '.csv');

    $output = fopen('php://output', 'w');

    // Ligne de titre
    fputcsv($output, template('csv_site'), ",");

    // Check biblio_review
    $biblio_review = false;
    $phases = Phase::find_by_parent($site->id());
    foreach ($phases as $phase) {
        // Chercher les contextes
        $contexts = Context::find_by_parent($phase->id());
        foreach ($contexts as $context) {
            if ($context->biblio_review()) {
                $biblio_review = true;
            }
        }
    }

    // Ligne de titre
    if ($biblio_review && PROJECT->setting_litterature()) {
        fputcsv($output, template('csv_site_full'), ",");
    } else {
        fputcsv($output, template('csv_site'), ",");
    }

    foreach ($phases as $phase) {
        // Chercher les contextes
        $contexts = Context::find_by_parent($phase->id());
        foreach ($contexts as $context) {
            // Chercher les objets
            $objects = ObjectTable::find_by_parent($context->id());
            foreach ($objects as $object) {
                if ($biblio_review && $site()->project()->setting_litterature()) {
                    // Afficher les inventaires
                    fputcsv($output, [
                        $phase->name(),
                        $context->name(),
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
                        $phase->name(),
                        $context->name(),
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
        }
    }

    fclose($output);
} else {
    echo "404 NOT FOUND";
}

?>