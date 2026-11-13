<?php
    $error_message = false;

    if (!isset($_SESSION['user'])) {
        $error_message = 'no_connexion';
    } elseif (!$_SESSION['user']->is_contributor()) {
        $error_message = 'no_contributor_rights';
    } elseif (isset($params['code'])) {
        /* Récupère les informations du projet */
        $region = Region::find_by_code(dec_sl($params['code']));
        if (!$region) {
            $error_message = 'no_region';
        } elseif (isset($_POST['object'])) {
            $_POST['object']['id'] = $region->id();
            if (!$_POST['object']['country']) {
                $_POST['object']['country'] = -1;
            }
            $region = new Region($_POST['object']);
            /* Initialise le site */
            $title = ucfirst(thesaurus('modifications')) . thesaurus(":") . ' ' . $region->code() . " - " . $region->name();
        } else {
            /* Initialise le site */
            $title = ucfirst(thesaurus('modifications')) . thesaurus(":") . ' ' . $region->code() . " - " . $region->name();
        }
    } elseif (isset($_POST['object'])) {
        $region = new Region($_POST['object']);
        $title = ucfirst(thesaurus('new') . ' ' . thesaurus('region'));
    } else {
        $region = new Region();
        $title = ucfirst(thesaurus('new') . ' ' . thesaurus('region'));
    }

    if ($_POST && !$error_message) {
        $success = $region->save();
        if ($success) {
            header('Location: ' . $region->url('parent'));
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

                $region->display_errors();
                
                // Initiate form
                $region->form('begin');
                    echo '<br>';
                    // ADD LIST COUNTRY
                    echo p($region->input('country', 'region_country'));
                    echo p($region->input('code', 'region_code'));
                    echo p($region->input('name', 'region_name'));
                $region->form('end');
            } ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>