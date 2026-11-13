<?php
    $title = ucfirst(thesaurus('other_tools'));
?>
<!DOCTYPE html>
<html>
    <?php require_once("../layout/headers.php"); ?>
    <body>
        <?php require_once("../layout/navbars.php"); ?>
        <main class="container-fluid py-5" style="max-width:800px">
            <?php long_translation("other_tools"); ?>
        </main>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>