<?php
    /* Vérifie si l'utilisateur est connecté et donc a accès à cette page */
    if (!isset($_SESSION['user'])) {
        $error_message = 'no_connexion';
    } else {
        $title = ucfirst(thesaurus('my typologies'));
        $all_typologies = Typology::linked_with_project();
        $categories = [];
        foreach ($all_typologies as $typology) {
            if ($typology->contributor_rights()) {
                $link_cat = Category::linked('typology', 'category', $typology->id());
                if (count($link_cat) > 0) {
                    foreach ($link_cat as $category) {
                        if (!isset($categories[$category->code()])) {
                            $categories[$category->code()] = [];
                        }
                        $categories[$category->code()][] = $typology;
                    }
                } else {
                    if (!isset($categories["ZZZZZ"])) {
                        $categories["ZZZZZ"] = [];
                    }
                    $categories["ZZZZZ"][] = $typology;
                }        
            }
        }
    }
    ksort($categories);
?>

<!DOCTYPE html>
<html>
    <?php require_once("../layout/headers.php"); ?>
    <body>
        <?php require_once("../layout/navbars.php"); ?>
        <div class="maindiv container">
            <?php require_once("list_typologies.php"); ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>