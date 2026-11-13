<?php
    $error_message = false;

    if (!isset($_SESSION['user'])) {
        $error_message = 'no_connexion';
    } else {
        $site = Site::find_by_owner_code($params['idowner'], dec_sl($params['codesite']));
        if ($site) {
            if (!PROJECT) {
                $error_message = 'no_project';
            } elseif (!ISOLATED_WEBSITE && (!$site->project() || $site->project()->id() !== PROJECT->id())) {
                $error_message = 'not_content_project';
            } elseif (isset($params['codephase'])) {
                /* Récupère les informations du site */
                $phase = Phase::find_by_site_code($site->id(), dec_sl($params['codephase']));
                if (!$phase) {
                    $error_message = 'no_phase';
                } elseif (isset($_POST['object'])) {
                    $_POST['object']['related_site'] = $site->id();
                    $_POST['object']['id'] = $phase->id();
                    $phase = new Phase($_POST['object']);
                    /* Initialise le site */
                    $title = ucfirst(thesaurus('modifications')) . thesaurus(":") . $phase->codename();
                } else {
                    /* Initialise le site */
                    $title = ucfirst(thesaurus('modifications')) . thesaurus(":") . $phase->codename();
                }
                
            } elseif (isset($_POST['object'])) {
                $_POST['object']['related_site'] = $site->id();
                $phase = new Phase($_POST['object']);
                $title = ucfirst(thesaurus('new') . ' ' . thesaurus('phase'));
            } else {
                $phase = new Phase(['related_site'=>$site->id()]);
                $title = ucfirst(thesaurus('new') . ' ' . thesaurus('phase'));
            }
        } else {
            $error_message = 'no_site';
        }
        
    }

    if (!$error_message) {
        if (!$phase->contributor_rights()) { $error_message = 'not_contributor'; }
    }

    if ($_POST && !$error_message) {
        $success = $phase->save();
        if ($success) {
            header('Location: ' . $phase->url());
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

                $phase->display_errors();
                
                // Initiate form
                $phase->form('begin');
                    echo '<br>';
                    echo '<h4>' . $phase->input('code', 'phase_code', false);
                    if ($_SESSION['user']->is_beginner()) { echo '</h4><h4>'; }
                    echo $phase->input('name', 'phase_name', false) . '</h4>';
                    echo p(ucfirst(thesaurus('site')) . thesaurus(':') . ' ' . $site->hyperlink() . ".");
                    $site->owner(); $phase->owner(); echo "<br><br>";
                    if (PROJECT && PROJECT->setting_horizon()) {
                        echo p($phase->input('horizon', 'phase_horizon') . ". " . $phase->input('horizon_strength', 'phase_horizon_strength'));
                    }
                    echo ($phase->input_text('descr', 'phase_descr'));
                    echo (h(4, ucfirst(thesaurus('confidentiality and publication state'))));
                    echo p($phase->input_checkbox('public', 'phase_public'));
                    echo p($phase->input_checkbox('unpublished', 'phase_unpublished'));
                    echo p($phase->input_checkbox('biblio_review', 'phase_biblio_review'));
                $phase->form('end');
                // Add script
                echo ($phase->input_text('descr', 'phase_descr', true, false, true));
            } ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>