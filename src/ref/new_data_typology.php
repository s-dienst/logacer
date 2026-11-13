<?php
    $error_message = false;
    $new = true;

    if (!isset($_SESSION['user'])) {
        $error_message = 'no_connexion';
    } elseif ((ISOLATED_WEBSITE || !PROJECT) && !$_SESSION['user']->is_contributor()) {
        $error_message = 'no_contributor_rights';
    } elseif (PROJECT && !ISOLATED_WEBSITE && !PROJECT->contributor_rights()) {
        $error_message = 'not_project_contributor';
    } elseif (isset($params['idtypology'])) {
        /* Récupère les informations de la typologie */
        $typology = Typology::find_by_id($params['idtypology']);
        $new = false;
        if (!$typology) {
            $error_message = 'no_typology';
        } elseif (isset($_POST['object'])) {
            $_POST['object']['id'] = $typology->id();
            $typology = new Typology($_POST['object']);
            /* Initialise le titre */
            $title = ucfirst(thesaurus('modifications')) . thesaurus(":") . $typology->codename();
        } else {
            /* Initialise le titre */
            $title = ucfirst(thesaurus('modifications')) . thesaurus(":") . $typology->codename();
        }
    } elseif (isset($_POST['object'])) {
        $typology = new Typology($_POST['object']);
        $title = ucfirst(thesaurus('new') . ' ' . thesaurus('typology'));
    } else {
        if (isset(PROJECT)) {
            $typology = new Typology(['project'=>PROJECT->id()]);
        } else {
            $typology = new Typology();
        }
        $title = ucfirst(thesaurus('new') . ' ' . thesaurus('typology'));
    }

    if (!$error_message) {
        if (!$typology->contributor_rights()) { $error_message = 'not_contributor'; }
    }

    if ($_POST && !$error_message) {
        $success = $typology->save();
        if ($success) {
            if ($new) {
                header('Location: ' . $typology->url('update_category'));
                exit();
            } else {
                header('Location: ' . $typology->url());
                exit();
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
            <!-- Error message -->
            <?php if ($error_message) { display_fatal_error($error_message); } else {
                
                echo h(2, $title);

                $typology->display_errors();
                
                // Initiate form
                $typology->form('begin');
                    echo '<br>';
                    echo '<h4>' . $typology->input('code', 'typology_code', false);
                    if ($_SESSION['user']->is_beginner()) { echo '</h4><h4>'; }
                    echo $typology->input('name', 'typology_name', false) . '</h4>';
                    $typology->owner(); echo "<br><br>";
                    echo ($typology->input_text('descr', 'typology_descr'));
                    echo (h(4, ucfirst(thesaurus('confidentiality'))));
                    if (PROJECT && !ISOLATED_WEBSITE) {
                        echo p($typology->input_checkbox('public', 'typology_public'));
                    }
                $typology->form('end');
                // Add script
                echo ($typology->input_text('descr', 'typology_descr', true, false, true));
            } ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>