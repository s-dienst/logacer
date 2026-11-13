<?php require_once("../layout/classes/site.class.php"); ?>
<?php
if (!PROJECT) {
    $error_message = 'no_project';
} elseif (!PROJECT->setting_horizon()) {
    $error_message = 'not_in_project';
} else {
    $title = ucfirst(thesaurus('list of the horizons'));
    list($countries, $no_region) = Facies::display_by_loc();
}
?>

<!DOCTYPE html>
<html>
    <?php require_once("../layout/headers.php"); ?>
    <body>
        <?php require_once("../layout/navbars.php"); ?>
        <div class="maindiv container">
            <?php require_once("list_horizons.php"); ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>