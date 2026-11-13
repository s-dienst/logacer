<?php
    $title = ucfirst(thesaurus('list of the countings'));
?>

<!DOCTYPE html>
<html>
    <?php require_once("../layout/headers.php"); ?>
    <body>
        <?php require_once("../layout/navbars.php"); ?>
        <div class="maindiv container">
            <?php
            // New counting - need deep review of code
            /*if (isset($_SESSION['user'])) { if ($_SESSION['user']->is_staff()) {
                button_new('counting', ['counting', 'new']);
                echo "<br>";
            }}*/

            echo h(2, $title);
            $all_countings = Counting::find_all();
            echo "<ul>";
            foreach ($all_countings as $single_counting) {
                    echo li($single_counting->codename() /*. $single_counting->modify_staff()*/);
            }
            echo "</ul>";
            ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>