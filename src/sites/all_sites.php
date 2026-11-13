<?php
    $title = ucfirst(thesaurus('list of the sites'));
    list($countries, $no_region) = Site::display_by_loc();
?>

<!DOCTYPE html>
<html>
    <?php require_once("../layout/headers.php"); ?>
    <body>
        <?php require_once("../layout/navbars.php"); ?>
        <div class="maindiv container">
            <?php require_once("list_sites.php"); ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>