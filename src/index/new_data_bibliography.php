<?php
    $error_message = false;

    if (!isset($_SESSION['user'])) {
        $error_message = 'no_connexion';
    } elseif (isset($params['idbiblio'])) {
        /* Récupère les informations de la référence */
        $reference = Bibliography::find_by_id($params['idbiblio']);
        if (!$reference) {
            $error_message = 'no_reference';
        } elseif (isset($_POST['object'])) {
            $_POST['object']['id'] = $reference->id();
            $reference = new Bibliography($_POST['object']);
            /* Initialise le site */
            $title = ucfirst(thesaurus('modifications')) . thesaurus(":") . $reference->codename();
        } else {
            /* Initialise le site */
            $title = ucfirst(thesaurus('modifications')) . thesaurus(":") . $reference->codename();
        }
    } elseif (isset($_POST['object'])) {
        $reference = new Bibliography($_POST['object']);
        $title = ucfirst(thesaurus('new') . ' ' . thesaurus('biblio_reference'));
    } else {
        $reference = new Bibliography();
        $title = ucfirst(thesaurus('new') . ' ' . thesaurus('biblio_reference'));
    }

    if (!$error_message) {
        if (!$reference->contributor_rights()) { $error_message = 'not_contributor'; }
    }

    if ($_POST && !$error_message) {
        if (isset($_POST['object']['onicer_link'])) {
            if (str_contains($_POST['object']['onicer_link'], '/')) {
                $_POST['object']['onicer_link'] = substr($_POST['object']['onicer_link'], strrpos($_POST['object']['onicer_link'], '/') + 1);
            }
        }
        $success = $reference->save();
        if ($success) {
            header('Location: ' . $reference->url());
            exit();
        }
    }
?>

<!DOCTYPE html>
<html>
    <?php require_once("../layout/headers.php"); ?>
    <body>
        <?php require_once("../layout/navbars.php"); ?>
        <div class="maindiv container">
            <!-- Error message -->
            <?php if ($error_message) { display_fatal_error($error_message); } else {
                
                echo h(2, $title);

                $reference->display_errors();
                
                // Initiate form
                $reference->form('begin');
                    echo '<br>';
                    echo h(4, $reference->input('abbreviation', 'biblio_abbreviation'));
                    $reference->owner(); echo "<br><br>";
                    echo ($reference->input_text('reference', 'biblio_reference'));
                    echo p(($reference->input('onicer_link', 'biblio_onicer_link')));
                $reference->form('end');
                // Add script
                echo ($reference->input_text('reference', 'biblio_reference', true, false, true));
            } ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>