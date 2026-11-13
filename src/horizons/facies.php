<?php
    /* Récupère les données du faciès */
    $error_message = false;
    if (!PROJECT) {
        $error_message = 'no_project';
    } elseif (!PROJECT->setting_horizon()) {
        $error_message = 'not_in_project';
    } else {
        $facies = Facies::find_by_id($params['idfacies']);
        if ($facies) {
            if (!ISOLATED_WEBSITE && (!$facies->project() || $facies->project()->id() !== PROJECT->id())) {
                $error_message = 'not_content_project';
            } else {
                /* Initialise le titre */
                $title = $facies->codename();

                /* Check si visible */
                if (!$facies->public() && !$facies->contributor_rights()) {
                    $error_message = 'non_public_facies';
                }
            }
        } else {
            $error_message = 'no_facies';
        }

        if ($_POST && !$error_message) {

            $facies->check_post();

            $facies->manage_contributors('back');
            $facies->manage_bibliography('back');
            $facies->manage_regions('back');
            $facies->manage_files('back');
            if (isset($_POST['typeaction'])) {
                if ($_POST['typeaction'] === 'delete') {
                    $facies->delete($facies->url('parent'), ['horizon']);
                }
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

                // Buttons for the facies
                $facies->buttons_contrib();

                // Informations about the facies
                $facies->codename('title');
                $facies->owner();
                echo "<br><br>";
                $facies->display_errors();

                    // Show and manage contributors
                    $facies->manage_contributors('front');

                $facies->manage_regions('front');
                $facies->description('display');

                // Manage horizons
                $horizons = Horizon::find_by_parent($facies->id(), ['code']);
                if (count($horizons) > 0 || $facies->contributor_rights()) {
                    echo h(3, ucfirst(thesaurus('the horizons'))) . "<ol>";
                    foreach ($horizons as $horizon) {
                        if (!$horizon->superhorizon()) {
                            if ($horizon->public()) {
                                echo li($horizon->hyperlink());
                            } elseif ($horizon->contributor_rights()) {
                                echo li($horizon->hyperlink() . ' (' . b(thesaurus('non_public')) . ')');
                            }
                        }
                    }
                    if ($facies->contributor_rights()) {
                        echo li("<a class ='btn btn-secondary btn-sm' href='" . $facies->url('new_horizon') . "'>" . ucfirst(thesaurus("add")) . ' ' . thesaurus("a horizon") . "</a>");
                    }
                    echo "</ol>";
                }

                // Show and manage bibliography
                if ($facies->unpublished()) {
                    echo h(4, ucfirst(thesaurus("this facies")) . " " . thesaurus("is unpublished") . ".");
                } else {
                    echo h(3, ucfirst(thesaurus("bibliography")));
                    $facies->manage_bibliography('front');
                }

                // Show and manage files
                $facies->manage_files('front');

                // Commentaires liés
                if (PROJECT->setting_notes()) {
                    $comment_class = 'Facies';
                    $comment_id = $facies->id();
                    require_once('../users/comments.php');
                }

                $facies->cite_page();

            } ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>