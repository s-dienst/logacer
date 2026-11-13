<?php
    /* Vérifie si l'utilisateur est connecté et donc a accès à cette page */
    if (!isset($_SESSION['user'])) {
        $error_message = 'no_connexion';
    } else {
        $title = ucfirst(thesaurus('my sites'));
        list($countries, $no_region) = Site::display_by_loc(0);
    }
?>

<!DOCTYPE html>
<html>
    <?php require_once("../layout/headers.php"); ?>
    <body>
        <?php require_once("../layout/navbars.php"); ?>
        <div class="maindiv container">
            <!-- Error message if not connected -->
            <?php if(isset($error_message)): ?>
                <br><div class="alert alert-danger"><?php echo $error_message ?></div><br>
            <?php else: ?>
                <?php require_once("list_sites.php"); ?>
            <?php endif ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>