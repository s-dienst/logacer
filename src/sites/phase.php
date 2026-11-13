<?php
    /* Récupère les données du site */
    $error_message = false;
    $site = Site::find_by_owner_code($params['idowner'], dec_sl($params['codesite']));

    if ($site) {
        if (!PROJECT) {
            $error_message = 'no_project';
        } elseif (!ISOLATED_WEBSITE && (!$site->project() || $site->project()->id() !== PROJECT->id())) {
            $error_message = 'not_content_project';
        } elseif (!$site->public() && !$site->contributor_rights()) {
            /* Check si visible */
            $error_message = 'non_public_site';
        }  else {
            $phase = Phase::find_by_site_code($site->id(), dec_sl($params['codephase']));

            if ($phase) {
                /* Initialise le titre */
                $title = $phase->codename();

                /* Check si visible */
                if (!$phase->public() && !$phase->contributor_rights()) {
                    $error_message = 'non_public_phase';
                }
            } else {
                $error_message = 'no_phase';
            }
        }
    } else {
        $phase = false;
        $error_message = 'no_site';
    }

    if ($_POST && !$error_message) {

        $phase->check_post();

        $phase->manage_bibliography('back');
        $phase->manage_files('back');
        if (isset($_POST['typeaction'])) {
            if ($_POST['typeaction'] === 'delete') {
                $phase->delete($site->url(), ['context']);
            }
        }
    }
?>

<!DOCTYPE html>
<html>
    <?php require_once("../layout/headers.php"); ?>
    <?php if ($phase) { $phase->biblio_review('body'); } else { echo "<body>"; } ?>
        <?php require_once("../layout/navbars.php"); ?>
        <div class="maindiv container">
            <!-- Error message if not a valid phase -->
            <?php if ($error_message) { display_fatal_error($error_message); } else {
            
                // If biblio review, special display
                $phase->biblio_review('message');

                // Buttons for the phase
                if (!($phase->code() === '00')) {
                    $phase->buttons_contrib();
                }

                // Informations about the phase
                $phase->codename('title');
                echo p(ucfirst(thesaurus('site')) . thesaurus(':') . ' ' . $site->hyperlink() . ".");
                if (!($phase->code() === '00')) {
                    if (PROJECT && PROJECT->setting_horizon()) {
                        echo $phase->horizon('display');
                    }
                    $site->owner(); $phase->owner();
                    echo "<br><br>";    
                    $phase->display_errors();

                    $phase->description('display');
                }

                // Manage contexts
                $contexts = Context::find_by_parent($phase->id(), ['code']);
                if (count($contexts) > 0 || $phase->contributor_rights()) {
                    echo h(3, ucfirst(thesaurus('the contexts'))) . "<ol>";
                    foreach ($contexts as $context) {
                        if ($context->public()) {
                            echo li($context->hyperlink());
                        } elseif ($context->contributor_rights()) {
                            echo li($context->hyperlink() . ' (' . b(thesaurus('non_public')) . ')');
                        }
                    }
                    if ($phase->contributor_rights()) {
                        echo li("<a class ='btn btn-secondary btn-sm' href='" . $phase->url('new_context') . "'>" . ucfirst(thesaurus("add")) . ' ' . thesaurus("a context") . "</a>");
                    }
                    echo "</ol>";
                }

                if (!($phase->code() === '00')) {
                    // Show and manage bibliography
                    if ($site->unpublished()) {
                        echo h(4, ucfirst(thesaurus("this site")) . " " . thesaurus("is unpublished") . ".");
                    } elseif ($phase->unpublished()) {
                        echo h(4, ucfirst(thesaurus("this phase")) . " " . thesaurus("is unpublished") . ".");
                    } else {
                        echo h(3, ucfirst(thesaurus("bibliography")));
                        $phase->manage_bibliography('front');
                    }

                    // Show and manage files
                    $phase->manage_files('front');

                } else {
                    // More manual one
                    echo h(3, ucfirst(thesaurus('associated files'))) . '<ul>';
                    if (ISOLATED_WEBSITE) {
                        echo li(hyperlink(ucfirst(thesaurus('phase_inventory')) . ' ' . $site->codename(), ['sites', 'download', $site->owner_id(), $site->code(), $phase->code()]));
                    } else {
                        echo li(hyperlink(ucfirst(thesaurus('phase_inventory')) . ' ' . $site->codename(), [PROJECT->code(), 'sites', 'download', $site->owner_id(), $site->code(), $phase->code()]));
                    }
                    echo '</ul>';
                }

                // Commentaires liés
                if (PROJECT->setting_notes()) {
                    $comment_class = 'Phase';
                    $comment_id = $phase->id();
                    require_once('../users/comments.php');
                }

                // Infos to cite page
                $phase->cite_page();

            } ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>