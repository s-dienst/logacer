<?php
    $tutorial = dec_sl($params['tutorial']);
    $list_tutorials = [
        "tutorial-base",
        "manage-account",
        "navigation-login",
        "add-inventory",
        "add-horizons",
        "manage-project",
        "manage-bibliography-files",
        "manage-classification",
    ];
    if (in_array($tutorial, $list_tutorials)) {
        $title = ucfirst(thesaurus($params['tutorial']));
        $find = true;
    } else {
        $title = "404 not found";
        $find = false;
        // TO ADD
    }
?>

<!DOCTYPE html>
<html>
    <?php require_once("../layout/headers.php"); ?>
    <body class= "body_tutorial" data-bs-spy="scroll" data-bs-target="#sidebarMenu" data-bs-offset="0" tabindex="0">
        <?php /*require_once("../layout/navbars.php");*/ ?>
        <div class="maindiv container">
            <?php
            if (PROJECT) {
                $return_list = "<p><a href='" . create_url_proj(['tutorials']) . "'>Retourner à la liste des tutoriaux</a></p>";
                // langue : pour l'instant, juste FR ; après, changer
                $tutorial_file = File::find_by_properties(['name'=>$tutorial . '-' . LANGUAGE . '.pdf', 'type'=>'tutorial', 'project'=>PROJECT->id()]);
                $tuto_button = "";
                if (!$tutorial_file) {
                    $tutorial_file = File::find_by_properties(['name'=>$tutorial . '-' . LANGUAGE, 'type'=>'tutorial', 'project'=>PROJECT->id()]);
                }
                if ($tutorial_file) {
                    $tuto_button = "<a href='". create_url_proj(['files', 'download', $tutorial_file[0]->id()]) . "' class='btn btn-info'>" . ucfirst(thesaurus('download_tutorial')) . "</a>";
                }
                if ($find) {
                    // langue : pour l'instant, juste FR ; après, changer
                    require_once($tutorial . "-" . LANGUAGE . ".php");
                } else {
                    echo $return_list;
                    display_fatal_error("no_tutorial"); // Ajouter thésaurus
                }
            } else {
                display_fatal_error("no_project");
            }

            ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>