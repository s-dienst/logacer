<?php
    /* Vérifie si l'utilisateur est connecté et donc a accès à cette page */
    if (!isset($_SESSION['user'])) {
        $error_message = 'no_connexion';
    } else {
        $title = ucfirst(thesaurus('my fabrics'));
        $all_fabrics = Fabric::linked_with_project();
        $fabrics = [];
        foreach ($all_fabrics as $fabric) {
            if ($fabric->contributor_rights() && !$fabric->superfabric()) {
                $fabrics[] = $fabric;
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
            <?php require_once("list_fabrics.php"); ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>