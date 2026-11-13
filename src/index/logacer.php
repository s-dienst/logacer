<?php
    $title = "LOGACer";
?>

<!DOCTYPE html>
<html>
    <?php require_once("../layout/headers.php"); ?>
    <body>
        <?php require_once("../layout/navbars.php"); ?>
        <main class="container-fluid py-5" style="max-width:800px">
            <img src="<?php echo BASE_STATIC; ?>static/logo/Logo-logacer-3.png" style="width:320px;">
            </br></br>
            <?php long_translation("logacer"); ?>
        </main>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>