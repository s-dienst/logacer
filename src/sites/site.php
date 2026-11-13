<?php
    /* Récupère les données du site */
    $error_message = false;
    $site = Site::find_by_owner_code($params['idowner'], dec_sl($params['codesite']));
    if ($site) {
        if (!PROJECT) {
            $error_message = 'no_project';
        } elseif (!ISOLATED_WEBSITE && (!$site->project() || $site->project()->id() !== PROJECT->id())) {
            $error_message = 'not_content_project';
        } else {
            /* Initialise le titre */
            $title = $site->codename();

            /* Check si visible */
            if (!$site->public() && !$site->contributor_rights()) {
                $error_message = 'non_public_site';
            }
        }
    } else {
        $error_message = 'no_site';
    }

    if ($_POST && !$error_message) {

        $site->check_post();

        $site->manage_contributors('back');
        $site->manage_bibliography('back');
        $site->manage_files('back');
        if (isset($_POST['typeaction'])) {
            if ($_POST['typeaction'] === 'delete') {
                if (Phase::find_by_site_code($site->id(), '00')) {
                    if (count(Context::find_by_parent(Phase::find_by_site_code($site->id(), '00')->id())) > 0) {
                        $error_message_delete = "contexts_in_default_phase";
                        unset($_POST['typeaction']);
                    } else {
                        Phase::find_by_site_code($site->id(), '00')->delete(false, ['context']);
                        $site->delete($site->url('parent'), ['phase']);
                    }
                } else {
                    $site->delete($site->url('parent'), ['phase']);
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html>
    <?php require_once("../layout/headers.php"); ?>
    <!-- If biblio review, special color -->
    <?php if ($site) { $site->biblio_review('body'); } else { echo "<body>"; } ?>
        <?php require_once("../layout/navbars.php"); ?>
        <div class="maindiv container">
            <!-- Error message -->
            <?php if ($error_message) { display_fatal_error($error_message); } else {
                if (isset($error_message_delete)) { display_fatal_error($error_message_delete); }

                // If biblio review, special display
                $site->biblio_review('message');

                // Buttons for the site
                $site->buttons_contrib();

                // Informations about the site
                $site->codename('title');
                $site->owner();
                echo "<br><br>";
                $site->display_errors();

                    // Show and manage contributors
                    $site->manage_contributors('front');

                $site->location();
                $site->description('display');

                // Manage phases
                $phases = Phase::find_by_parent($site->id(), ['code']);
                if (count($phases) > 0 || $site->contributor_rights()) {
                    echo h(3, ucfirst(thesaurus('the phases'))) . "<ol>";
                    foreach ($phases as $phase) {
                        if (!($phase->code() === '00')) {
                            if ($phase->public()) {
                                echo li($phase->hyperlink());
                            } elseif ($phase->contributor_rights()) {
                                echo li($phase->hyperlink() . ' (' . b(thesaurus('non_public')) . ')');
                            }
                        }
                    }
                    $default_phase = Phase::find_by_site_code($site->id(), '00');
                    if ($default_phase) {
                        // Affichage uniquement si contextes ou contributeur
                        if (count(Context::find_by_parent($default_phase->id())) > 0 || $default_phase->contributor_rights()) {
                            if ($default_phase->public()) {
                                echo li($default_phase->hyperlink());
                            } elseif ($default_phase->contributor_rights()) {
                                echo li($default_phase->hyperlink() . ' (' . b(thesaurus('non_public')) . ')');
                            }
                        }
                    }
                    if ($site->contributor_rights()) {
                        echo li("<a class ='btn btn-secondary btn-sm' href='" . $site->url('new_phase') . "'>" . ucfirst(thesaurus("add")) . ' ' . thesaurus("a phase") . "</a>");
                    }
                    echo "</ol>";
                }

                // Show and manage bibliography
                if ($site->unpublished()) {
                    echo h(4, ucfirst(thesaurus("this site")) . " " . thesaurus("is unpublished") . ".");
                } else {
                    echo h(3, ucfirst(thesaurus("bibliography")));
                    $site->manage_bibliography('front');
                }

                // Show and manage files
                $site->manage_files('front');

                // Commentaires liés
                if (PROJECT->setting_notes()) {
                    $comment_class = 'Site';
                    $comment_id = $site->id();
                    require_once('../users/comments.php');
                }

                // Infos to cite page
                $site->cite_page();

            } ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>