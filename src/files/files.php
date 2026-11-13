<?php
    $title = ucfirst(thesaurus('files'));
    $all_files = File::find_all();
    $files = [];
    foreach ($all_files as $file) {
        if (ISOLATED_WEBSITE) {
            $files[] = $file;
        } elseif (PROJECT && $file->project() && $file->project()->id() === PROJECT->id()) {
            $files[] = $file;
        } elseif (!PROJECT && !$file->project()) {
            $files[] = $file;
        }
    }
?>

<!DOCTYPE html>
<html>
    <?php require_once("../layout/headers.php"); ?>
    <body>
        <?php require_once("../layout/navbars.php"); ?>
        <div class="maindiv container">
            <?php 
            if (isset($_SESSION['user'])) {
                if (ISOLATED_WEBSITE) {
                    button_new('file', ['files', 'addfile']);
                } elseif (PROJECT && PROJECT->contributor_rights()) {
                    button_new('file', [PROJECT->code(), 'files', 'addfile']);
                } elseif (!PROJECT && $_SESSION['user']->is_contributor()) {
                    button_new('file', ['logacer', 'files', 'addfile']);
                }
            }
            echo h(2, $title);

            echo "<ul>";
            foreach ($files as $file) {
                $publish = false;
                if ($file->public()) {
                    $publish = true;
                } elseif ($file->contributor_rights()) {
                    $publish = true;
                }
                if ($publish && in_array($file->type(), ['generic', 'both'])) {
                    echo li($file->codename('link'));
                }
            }
            echo "</ul>";
            ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>