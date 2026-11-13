<?php
    $error_message = false;

    if (!isset($_SESSION['user'])) {
        $error_message = 'no_connexion';
    } elseif (!PROJECT) {
        $error_message = 'no_project';
    } elseif (!PROJECT->setting_horizon()) {
        $error_message = 'not_in_project';
    } elseif (isset($params['idfacies'])) {
        /* Récupère les informations du faciès */
        $facies = Facies::find_by_id($params['idfacies']);
        if (!$facies) {
            $error_message = 'no_facies';
        } elseif (!ISOLATED_WEBSITE && (!$facies->project() || $facies->project()->id() !== PROJECT->id())) {
            $error_message = 'not_content_project';
        } elseif (isset($_POST['object'])) {
            $_POST['object']['id'] = $facies->id();
            $facies = new Facies($_POST['object']);
            /* Initialise le titre */
            $title = ucfirst(thesaurus('modifications')) . thesaurus(":") . $facies->codename();
        } else {
            /* Initialise le titre */
            $title = ucfirst(thesaurus('modifications')) . thesaurus(":") . $facies->codename();
        }
    } elseif (isset($_POST['object'])) {
        $facies = new Facies($_POST['object']);
        $title = ucfirst(thesaurus('new') . ' ' . thesaurus('facies'));
    } else {
        if (isset($params['idproject'])) {
            $facies = new Facies(['project'=>$params['idproject']]);
        } else {
            $facies = new Facies();
        }
        $title = ucfirst(thesaurus('new') . ' ' . thesaurus('facies'));
    }

    if (!$error_message) {
        if (!$facies->contributor_rights()) { $error_message = 'not_contributor'; }
    }

    if ($_POST && !$error_message) {
        $success = $facies->save();
        if ($success) {
            header('Location: ' . $facies->url());
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

                $facies->display_errors();
                
                // Initiate form
                $facies->form('begin');
                    echo '<br>';
                    echo '<h4>' . $facies->input('code', 'facies_code', false);
                    if ($_SESSION['user']->is_beginner()) { echo '</h4><h4>'; }
                    echo $facies->input('name', 'facies_name', false) . '</h4>';
                    $facies->owner(); echo "<br><br>";
                    echo p($facies->input('project', 'facies_project'));
                    echo ($facies->input_text('descr', 'facies_descr'));
                    echo (h(4, ucfirst(thesaurus('confidentiality and publication state'))));
                    echo p($facies->input_checkbox('public', 'facies_public'));
                    echo p($facies->input_checkbox('unpublished', 'facies_unpublished'));
                    echo p($facies->input_checkbox('allow_graphs', 'facies_allow_graphs'));
                $facies->form('end');
                // Add script
                echo ($facies->input_text('descr', 'facies_descr', true, false, true));
            } ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>