<?php
if (PROJECT) {
    $title = ucfirst(thesaurus('list tutorials'));
} else {
    $title = "LOGACer tutorial";
}
    
?>

<!DOCTYPE html>
<html>
    <?php require_once("../layout/headers.php"); ?>
    <body>
        <?php require_once("../layout/navbars.php"); ?>
        <div class="maindiv container">
            <?php 
            if (!PROJECT) {
                long_translation('tutorial_logacer');
            } else {
                echo h(2, $title);
                echo "<br>";
                $list_tutorials_public = [
                    "tutorial-base",
                ];
                $list_tutorials_private = [
                    "manage-account",
                    "navigation-login",
                    "add-inventory",
                    "add-horizons",
                    "manage-project",
                    "manage-bibliography-files",
                    "manage-classification",
                ];
                echo "<ul>";
                if (ISOLATED_WEBSITE) {
                    foreach ($list_tutorials_public as $tutorial) {
                        echo li(hyperlink(ucfirst(thesaurus($tutorial)), ["tutorials", $tutorial], true) . "<br><br>");
                    }
                    if (isset($_SESSION['user'])) {
                        foreach ($list_tutorials_private as $tutorial) {
                            echo li(hyperlink(ucfirst(thesaurus($tutorial)), ["tutorials", $tutorial], true) . "<br><br>");
                        }
                    }
                } else {
                    foreach ($list_tutorials_public as $tutorial) {
                        echo li(hyperlink(ucfirst(thesaurus($tutorial)), [PROJECT->code(), "tutorials", $tutorial], true) . "<br><br>");
                    }
                    if (isset($_SESSION['user'])) {
                        foreach ($list_tutorials_private as $tutorial) {
                            echo li(hyperlink(ucfirst(thesaurus($tutorial)), [PROJECT->code(), "tutorials", $tutorial], true) . "<br><br>");
                        }
                    }
                }
                echo "</ul>";
            }

            ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>