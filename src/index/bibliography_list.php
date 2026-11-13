<?php
    /* Vérifie si l'utilisateur est connecté et donc a accès à cette page */
    $title = ucfirst(thesaurus('bibliography'));
?>

<!DOCTYPE html>
<html>
    <?php require_once("../layout/headers.php"); ?>
    <body>
        <?php require_once("../layout/navbars.php"); ?>
        <div class="maindiv container">
            
            <?php 
            // Ajouter référence
            if (isset($_SESSION['user'])) {
                if (ISOLATED_WEBSITE) {
                    button_new('biblio_reference', ['bibliography', 'new']);
                } else {
                    button_new('biblio_reference', ['logacer', 'bibliography', 'new']);
                }
            }

            // Titre
            echo h(2, ucfirst(thesaurus('list of the references')));

            // Liste des références
            $bibliography = Bibliography::find_all(['abbreviation']);
            if (PROJECT || ISOLATED_WEBSITE) {
                $project_bibliography = Bibliography::find_by_project(PROJECT->id());
                $pb_ids = [];
                echo h(4, ucfirst(thesaurus('used_biblio')) . PROJECT->code());
                if (count($project_bibliography) > 0) {
                     echo "<ul>";
                    foreach ($project_bibliography as $reference) {
                        echo li($reference->hyperlink());
                        $pb_ids[] = $reference->id();
                    }
                     echo "</ul>";
                } else {
                    // Message : pas encore de lien avec la bibliographie
                }
                echo h(4, ucfirst(thesaurus('non_used_biblio')) . PROJECT->code());
                echo "<ul>";
                foreach ($bibliography as $reference) {
                    if (!in_array($reference->id(), $pb_ids)) {
                        echo li($reference->hyperlink());
                    }
                }
                echo "</ul>";
            } else {
                echo "<ul>";
                foreach ($bibliography as $reference) {
                    echo li($reference->hyperlink());
                }
                echo "</ul>";
            }
            ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>