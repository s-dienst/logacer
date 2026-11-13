<?php
    $error_message = false;

    if (!isset($_SESSION['user'])) {
        $error_message = 'no_connexion';
    } elseif (!$_SESSION['user']->is_contributor()) {
        $error_message = 'no_contributor_rights';
    } elseif (isset($params['code'])) {
        /* Récupère les informations du projet */
        $country = Country::find_by_code(dec_sl($params['code']));
        if (!$country) {
            $error_message = 'no_country';
        } elseif (isset($_POST['object'])) {
            $_POST['object']['id'] = $country->id();
            $country = new Country($_POST['object']);
            /* Initialise le site */
            $title = ucfirst(thesaurus('modifications')) . thesaurus(":") . $country->codename();
        } else {
            /* Initialise le site */
            $title = ucfirst(thesaurus('modifications')) . thesaurus(":") . $country->codename();
        }
    } elseif (isset($_POST['object'])) {
        $country = new Country($_POST['object']);
        $title = ucfirst(thesaurus('new') . ' ' . thesaurus('country'));
    } else {
        $country = new Country();
        $title = ucfirst(thesaurus('new') . ' ' . thesaurus('country'));
    }

    if ($_POST && !$error_message) {
        $success = $country->save();
        if ($success) {
            header('Location: ' . $country->url('parent'));
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

                $country->display_errors();
                
                // Initiate form
                $country->form('begin');
                    echo '<br>';
                    echo p($country->input('code', 'country_code'));
                    echo p($country->input('name', 'country_name'));
                $country->form('end');
            } ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>