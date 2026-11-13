<?php
    $error_message = false;

    if (!isset($_SESSION['user'])) {
        $error_message = 'no_connexion';
    } elseif ((ISOLATED_WEBSITE || !PROJECT) && !$_SESSION['user']->is_contributor()) {
        $error_message = 'no_contributor_rights';
    } elseif (PROJECT && !ISOLATED_WEBSITE && !PROJECT->contributor_rights()) {
        $error_message = 'not_project_contributor';
    } else {
        if (isset($params['codefabric'])) {
            /* Récupère les informations du GP */
            $fabric = Fabric::find_by_code(dec_sl($params['codefabric']));
            if (!$fabric) {
                $error_message = 'no_fabric';
            } elseif (isset($_POST['object'])) {
                if (empty($_POST['object']['superfabric'])) {
                    $_POST['object']['superfabric'] = 0;
                }
                if (empty($_POST['object']['project'])) {
                    $_POST['object']['project'] = 0;
                }
                $_POST['object']['id'] = $fabric->id();
                $fabric = new Fabric($_POST['object']);
                /* Initialise le titre */
                $title = ucfirst(thesaurus('modifications')) . thesaurus(":") . $fabric->codename();
            } else {
                /* Initialise le titre */
                $title = ucfirst(thesaurus('modifications')) . thesaurus(":") . $fabric->codename();
            }
                
        } elseif (isset($_POST['object'])) {
            if (empty($_POST['object']['superfabric'])) {
                $_POST['object']['superfabric'] = 0;
            }
            if (empty($_POST['object']['project'])) {
                $_POST['object']['project'] = 0;
            }
            $fabric = new Fabric($_POST['object']);
            $title = ucfirst(thesaurus('new') . ' ' . thesaurus('fabric'));
        } else {
            if (isset($params['codesuperfabric'])) {
                $superfabric = Fabric::find_by_code(dec_sl($params['codesuperfabric']));
                if ($superfabric) {
                    $args = ['superfabric'=>$superfabric->id()];
                    if ($superfabric->project()) {
                        if ($superfabric->project()->contributor_rights()) {
                            $args['project'] = $superfabric->project()->id();
                        }
                    }
                    $fabric = new Fabric($args);
                }
            } elseif (isset(PROJECT)) {
                $fabric = new Fabric(['project'=>PROJECT->id()]);
            } else { $fabric = new Fabric(); }
            $title = ucfirst(thesaurus('new') . ' ' . thesaurus('fabric'));
        }     
    }

    if (!$error_message) {
        if (!$fabric->contributor_rights()) { $error_message = 'not_contributor'; }
    }

    if ($_POST && !$error_message) {
        $success = $fabric->save();
        if ($success) {
            header('Location: ' . $fabric->url());
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
                $fabric->display_errors();
                
                echo h(2, $title);

                // Initiate form
                $fabric->form('begin');
                    echo '<br>';
                    echo '<h4>' . $fabric->input('code', 'fabric_code', false);
                    if ($_SESSION['user']->is_beginner()) { echo '</h4><h4>'; }
                    echo $fabric->input('name', 'fabric_name', false) . '</h4>';
                    $fabric->owner(); echo "<br><br>";
                    if (PROJECT && !ISOLATED_WEBSITE) {
                        echo p($fabric->input('project', 'fabric_project'));
                    }
                    echo p($fabric->input('superfabric', 'fabric_superfabric'));
                    echo ($fabric->input_text('descr', 'fabric_descr'));
                    echo ($fabric->input_text('origin', 'fabric_origin'));
                $fabric->form('end');
                // Add script
                echo ($fabric->input_text('descr', 'fabric_descr', true, false, true));
                echo ($fabric->input_text('origin', 'fabric_origin', true, false, true));
            } ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>