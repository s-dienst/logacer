<?php
    $error_message = false;

    if (!PROJECT) {
        $error_message = "no_project";
    } else {
        $project = PROJECT;
        $pn = $params['pagename'];
        /* Initialise le titre */
        $title = $project->code() . thesaurus(':') . thesaurus($pn . "_page");

        /* Check si visible */
        if (!$project->contributor_rights()) {
            $error_message = 'not_project_contributor';
        } elseif (!in_array($pn, ["welcome", "about_us", "gdpr", "legals", "footer", "other_databases", "other_tools", "partnerships"])) {
            $error_message = 'not_existing_page';
        }
    }
?>

<!DOCTYPE html>
<html>
    <?php require_once("../layout/headers.php"); ?>
    <body>
        <?php require_once("../layout/navbars.php"); ?>
        <div class="maindiv container">
            <!-- Error message if not a valid phase -->
            <?php if ($error_message) { display_fatal_error($error_message); } else {
            
                echo h(2, ucfirst(thesaurus($pn . "_page")));

                echo "<div class='accordion'>";
                foreach ($project->langs() as $lang) {
                    echo "<div class='accordion-item'><h2 class='accordion-header'>
                        <button class='accordion-button' type='button' data-bs-toggle='collapse' data-bs-target='#collapse_" . $lang . "' aria-expanded='true' aria-controls='collapse_" . $lang . "'>"
                        . array_search($lang, SUPPORTED_LANGUAGES) . 
                        "</button></h2>";
                    echo "<div id='collapse_" . $lang . "' class='accordion-collapse collapse show'><div class='accordion-body'>";
                    $display = AppText::find_lang($pn, $lang, $project->id());
                    if ($display) {
                        $display->display();
                        $display->buttons_contrib();
                    } else {
                        echo ucfirst(thesaurus("not_modified_text"));
                        // Bouton ajouter
                        if (ISOLATED_WEBSITE) {
                            button_new('text', ['page', $pn, 'update', $lang]);
                        } elseif (PROJECT) {
                            button_new('text', [$project->code(), 'page', $pn, 'update', $lang]);
                        }
                    }
                    echo "</div></div></div>";
                }
                echo "</div>";

            } ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>