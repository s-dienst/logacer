<?php
    /* Récupère les données de la référence */
    $error_message = false;
    $reference = Bibliography::find_by_id($params['idbiblio']);
    if ($reference) {
        /* Initialise le titre */
        $title = $reference->codename();
    } else {
        $error_message = 'no_bibliography';
    }

    if ($_POST && !$error_message) {

        $reference->check_post();

        $reference->manage_files('back');
        if (isset($_POST['typeaction'])) {
            if ($_POST['typeaction'] === 'delete') {
                $reference->delete($reference->url('parent'), [], true);
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
            <!-- Error message -->
            <?php if ($error_message) { display_fatal_error($error_message); } else {

                // Buttons for the reference
                $reference->buttons_contrib();

                // Informations about the reference
                echo h(2, ucfirst(thesaurus('abbreviation')) . thesaurus(':') . ' ' . $reference->codename());
                $reference->owner();
                echo "<br><br>";
                $reference->display_errors();

                $reference->complete_ref('display');
                $reference->onicer_link('display');

            if (ISOLATED_WEBSITE || PROJECT) {
                // List of the sites
                $list_sites = Site::linked('site', 'bibliography', $reference->id(), true);    
                $title = h(3, ucfirst(thesaurus('linked sites'))) . "<ul>";
                $list = false;
                foreach ($list_sites as $site) {
                    if (PROJECT && $site->project()->id() === PROJECT->id()) {
                        if ($site->public() || $site->contributor_rights()) {
                            if (!$list) {
                                $list = true;
                                echo $title;
                            }
                            $html = $site->hyperlink();
                            $pagination_infos = DatabaseObject::connection()->query("SELECT pagination FROM link_site_bibliography WHERE bibliography = " . $reference->id() . " AND site = " . $site->id())->fetch();
                            if ($pagination_infos['pagination']) {
                                $html .= " (" . secure($pagination_infos['pagination']) . ")";
                            }
                            echo li($html);
                        }
                    }
                }
                if ($list) {
                    echo "</ul>";
                }

                // List of the phases
                $list_phases = Phase::linked('phase', 'bibliography', $reference->id(), true);
                $title = h(3, ucfirst(thesaurus('linked phases'))) . "<ul>";
                $list = false;
                foreach ($list_phases as $phase) {
                    if (PROJECT && $phase->related_site()->project()->id() === PROJECT->id()) {
                        if ($phase->public() || $phase->contributor_rights()) {
                            if (!$list) {
                                $list = true;
                                echo $title;
                            }
                            $html = $phase->hyperlink();
                            $pagination_infos = DatabaseObject::connection()->query("SELECT pagination FROM link_phase_bibliography WHERE bibliography = " . $reference->id() . " AND phase = " . $phase->id())->fetch();
                            if ($pagination_infos['pagination']) {
                                $html .= " (" . secure($pagination_infos['pagination']) . ")";
                            }
                            echo li($html);
                        }
                    }
                }
                if ($list) {
                    echo "</ul>";
                }

                // List of the contexts
                $list_contexts = Context::linked('context', 'bibliography', $reference->id(), true);
                $title = h(3, ucfirst(thesaurus('linked contexts'))) . "<ul>";
                $list = false;
                foreach ($list_contexts as $context) {
                    if (PROJECT && $context->related_phase()->related_site()->project()->id() === PROJECT->id()) {
                        if ($context->public() || $context->contributor_rights()) {
                            if (!$list) {
                                $list = true;
                                echo $title;
                            }
                            $html = $context->hyperlink();
                            $pagination_infos = DatabaseObject::connection()->query("SELECT pagination FROM link_context_bibliography WHERE bibliography = " . $reference->id() . " AND context = " . $context->id())->fetch();
                            if ($pagination_infos['pagination']) {
                                $html .= " (" . secure($pagination_infos['pagination']) . ")";
                            }
                            echo li($html);
                        }
                    }
                }
                if ($list) {
                    echo "</ul>";
                }

                // List of the pictures
                $list_pictures = Picture::find_by_property('biblio_reference', $reference->id());
                $title = h(3, ucfirst(thesaurus('linked pictures'))) . "<ul>";
                $list = false;
                foreach ($list_pictures as $picture) {
                    if (PROJECT && $picture->related_object()->related_context()->related_phase()->related_site()->project()->id() === PROJECT->id()) {
                        if ($picture->related_object()->related_context()->public() || $picture->contributor_rights()) {
                            if (!$list) {
                                $list = true;
                                echo $title;
                            }
                            $html = $picture->hyperlink();
                            if ($picture->biblio_emplacement()) {
                                $html .= " (" . $picture->biblio_emplacement() . ")";
                            }
                            echo li($html);
                        }
                    }
                }
                if ($list) {
                    echo "</ul>";
                }

                // List of the facies
                if (!PROJECT || PROJECT->setting_horizon()) {
                    $list_faciess = Facies::linked('facies', 'bibliography', $reference->id(), true);
                    $title = h(3, ucfirst(thesaurus('linked faciess'))) . "<ul>";
                    $list = false;
                    foreach ($list_faciess as $facies) {
                        if (PROJECT && $facies->project()->id() === PROJECT->id()) {
                            if ($facies->public() || $facies->contributor_rights()) {
                                if (!$list) {
                                    $list = true;
                                    echo $title;
                                }
                                $html = $facies->hyperlink();
                                $pagination_infos = DatabaseObject::connection()->query("SELECT pagination FROM link_facies_bibliography WHERE bibliography = " . $reference->id() . " AND facies = " . $facies->id())->fetch();
                                if ($pagination_infos['pagination']) {
                                    $html .= " (" . secure($pagination_infos['pagination']) . ")";
                                }
                                echo li($html);
                            }
                        }
                    }
                    if ($list) {
                        echo "</ul>";
                    }
                }
            }

                // List of the typologies
                $list_typologies = Typology::linked('typology', 'bibliography', $reference->id(), true);
                $title = h(3, ucfirst(thesaurus('linked typologies'))) . "<ul>";
                $list = false;
                foreach ($list_typologies as $typology) {
                    if ((PROJECT && $typology->project() && $typology->project()->id() === PROJECT->id()) || (!PROJECT && !$typology->project())) {
                        if (!PROJECT || $typology->public() || $typology->contributor_rights()) {
                            if (!$list) {
                                $list = true;
                                echo $title;
                            }
                            $html = $typology->hyperlink();
                            $pagination_infos = DatabaseObject::connection()->query("SELECT pagination FROM link_typology_bibliography WHERE bibliography = " . $reference->id() . " AND typology = " . $typology->id())->fetch();
                            if ($pagination_infos['pagination']) {
                                $html .= " (" . secure($pagination_infos['pagination']) . ")";
                            }
                            echo li($html);
                        }
                    }
                }
                if ($list) {
                    echo "</ul>";
                }

                // List of the types
                $list_types = Type::linked('type', 'bibliography', $reference->id(), true);
                $title = h(3, ucfirst(thesaurus('linked types'))) . "<ul>";
                $list = false;
                foreach ($list_types as $type) {
                    if ((PROJECT && $type->typology()->project() && $type->typology()->project()->id() === PROJECT->id()) || (!PROJECT && !$type->typology()->project())) {
                        if (!PROJECT || $type->typology()->public() || $type->contributor_rights()) {
                            if (!$list) {
                                $list = true;
                                echo $title;
                            }
                            $html = $type->hyperlink();
                            $pagination_infos = DatabaseObject::connection()->query("SELECT pagination FROM link_type_bibliography WHERE bibliography = " . $reference->id() . " AND type = " . $type->id())->fetch();
                            if ($pagination_infos['pagination']) {
                                $html .= " (" . secure($pagination_infos['pagination']) . ")";
                            }
                            echo li($html);
                        }
                    }
                }
                if ($list) {
                    echo "</ul>";
                }

                // List of the fabrics
                $list_fabrics = Fabric::linked('fabric', 'bibliography', $reference->id(), true);
                $title = h(3, ucfirst(thesaurus('linked fabrics'))) . "<ul>";
                $list = false;
                foreach ($list_fabrics as $fabric) {
                    if ((PROJECT && $fabric->project() && $fabric->project()->id() === PROJECT->id()) || (!PROJECT && !$fabric->project())) {
                        if (!PROJECT || $fabric->public() || $fabric->contributor_rights()) {
                            if (!$list) {
                                $list = true;
                                echo $title;
                            }
                            $html = $fabric->hyperlink();
                            $pagination_infos = DatabaseObject::connection()->query("SELECT pagination FROM link_fabric_bibliography WHERE bibliography = " . $reference->id() . " AND fabric = " . $fabric->id())->fetch();
                            if ($pagination_infos['pagination']) {
                                $html .= " (" . secure($pagination_infos['pagination']) . ")";
                            }
                            echo li($html);
                        }
                    }
                }
                if ($list) {
                    echo "</ul>";
                }

                // Show and manage files
                $reference->manage_files('front');

            } ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>