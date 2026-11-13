<?php
    $error_message = false;

    if (!isset($_SESSION['user'])) {
        $error_message = 'no_connexion';
    } elseif (!PROJECT) {
        $error_message = 'no_project';
    } elseif (!PROJECT->setting_horizon()) {
        $error_message = 'not_in_project';
    } else {
        $facies = Facies::find_by_id($params['idfacies']);
        if ($facies) {
            if (!ISOLATED_WEBSITE && (!$facies->project() || $facies->project()->id() !== PROJECT->id())) {
                $error_message = 'not_content_project';
            } else {
                if (isset($params['idhorizon'])) {
                    /* Récupère les informations de l'horizon */
                    $horizon = Horizon::find_by_id($params['idhorizon']);
                    if (!$horizon) {
                        $error_message = 'no_horizon';
                    } elseif ($horizon->facies()->id() != $facies->id()) {
                        $error_message = 'no_horizon';
                    } elseif (isset($_POST['object'])) {
                        $_POST['object']['facies'] = $facies->id();
                        $_POST['object']['id'] = $horizon->id();
                        $horizon = new Horizon($_POST['object']);
                        /* Initialise le site */
                        $title = ucfirst(thesaurus('modifications')) . thesaurus(":") . $horizon->codename();
                    } else {
                        /* Initialise le site */
                        $title = ucfirst(thesaurus('modifications')) . thesaurus(":") . $horizon->codename();
                    }
                    
                } elseif (isset($_POST['object'])) {
                    $_POST['object']['facies'] = $facies->id();
                    $horizon = new Horizon($_POST['object']);
                    $title = ucfirst(thesaurus('new') . ' ' . thesaurus('horizon'));
                } else {
                    if (isset($params['idsuperhorizon']) && Horizon::find_by_id($params['idsuperhorizon']) && Horizon::find_by_id($params['idsuperhorizon'])->facies()->id() === $facies->id()) {
                        $args = ['facies'=>$facies->id(), 'superhorizon'=>$params['idsuperhorizon']];
                    } else { $args = ['facies'=>$facies->id()]; }
                    $horizon = new Horizon($args);
                    $title = ucfirst(thesaurus('new') . ' ' . thesaurus('horizon'));
                }

            }
        } else {
            $error_message = 'no_facies';
        }
        
    }

    if (!$error_message) {
        if (!$horizon->contributor_rights()) { $error_message = 'not_contributor'; }
    }

    if ($_POST && !$error_message) {
        $success = $horizon->save();
        if ($success) {
            header('Location: ' . $horizon->url());
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
                $horizon->display_errors();
                
                echo h(2, $title);

                // Initiate form
                $horizon->form('begin');
                    echo '<br>';
                    echo '<h4>' . $horizon->input('code', 'horizon_code', false);
                    if ($_SESSION['user']->is_beginner()) { echo '</h4><h4>'; }
                    echo $horizon->input('name', 'horizon_name', false) . '</h4>';
                    echo p(ucfirst(thesaurus('facies')) . thesaurus(':') . ' ' . $facies->hyperlink() . ".");
                    $facies->owner(); $horizon->owner(); echo "<br><br>";
                    echo p($horizon->input('superhorizon', 'horizon_superhorizon'));
                    echo ($horizon->input_text('descr', 'horizon_descr'));
                    echo ($horizon->input_text('dating', 'horizon_dating'));
                    echo p($horizon->input_checkbox('public', 'horizon_public'));
                $horizon->form('end');
                // Add script
                echo ($horizon->input_text('descr', 'horizon_descr', true, false, true));
                echo ($horizon->input_text('dating', 'horizon_dating', true, false, true));
            } ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>