<?php
    $error_message = false;

    if (!isset($_SESSION['user'])) {
        $error_message = 'no_connexion';
    } elseif (!PROJECT) {
        $error_message = 'no_project';
    } elseif (isset($params['codesite'])) {
        /* Récupère les informations du site */
        $site = Site::find_by_owner_code($params['idowner'], dec_sl($params['codesite']));
        if (!$site) {
            $error_message = 'no_site';
        } elseif (!ISOLATED_WEBSITE && (!$site->project() || $site->project()->id() !== PROJECT->id())) {
            $error_message = 'not_content_project';
        } elseif (isset($_POST['object'])) {
            $_POST['object']['id'] = $site->id();
            $site = new Site($_POST['object']);
            /* Initialise le site */
            $title = ucfirst(thesaurus('modifications')) . thesaurus(":") . $site->codename();
        } else {
            /* Initialise le site */
            $title = ucfirst(thesaurus('modifications')) . thesaurus(":") . $site->codename();
        }
    } elseif (isset($_POST['object'])) {
        $site = new Site($_POST['object']);
        $title = ucfirst(thesaurus('new') . ' ' . thesaurus('site'));
    } else {
        $site = new Site(['project'=>PROJECT->id()]);
        $title = ucfirst(thesaurus('new') . ' ' . thesaurus('site'));
    }

    if (!$error_message) {
        if (!$site->contributor_rights()) { $error_message = 'not_contributor'; }
    }

    if ($_POST && !$error_message) {
        $success = $site->save();
        if ($success) {
            // Crée la nouvelle phase par défaut
            $idsite = Site::find_by_name(htmlspecialchars_decode($site->name()))->id();
            if (!Phase::find_by_site_code($idsite, '00')) {
                $default_phase = New Phase(['code'=>'00', 'name'=>'00', 'related_site'=>$idsite, 'public'=>1, 'unpublished'=>1]);
                $default_phase->save();                
            }
            // Gère les méthodes de comptage
            Counting::manage($site);
            header('Location: ' . $site->url());
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

                $site->display_errors();
                
                // Initiate form
                $site->form('begin');
                    echo '<br>';
                    echo '<h4>' . $site->input('code', 'site_code', false);
                    if ($_SESSION['user']->is_beginner()) { echo '</h4><h4>'; }
                    echo $site->input('name', 'site_name', false) . '</h4>';
                    $site->owner(); echo "<br><br>";
                    //echo p($site->input('project', 'site_project'));
                    echo p($site->input('region', 'site_region'));
                    echo p($site->input_number('coord_lat', 'site_latitude', -90, 90, 'any') . '° ' . thesaurus('north') . ". "
                        . $site->input_number('coord_long', 'site_longitude', -180, 180, 'any') . '° ' . thesaurus('east') . '.');
                    echo ($site->input_text('descr', 'site_descr'));
                    echo ($site->input_counting('site_counting'));
                    echo (h(4, ucfirst(thesaurus('confidentiality and publication state'))));
                    echo p($site->input_checkbox('public', 'site_public'));
                    echo p($site->input_checkbox('unpublished', 'site_unpublished'));
                    echo p($site->input_checkbox('biblio_review', 'site_biblio_review'));
                    echo p($site->input_checkbox('allow_graphs', 'site_allow_graphs'));
                $site->form('end');
                // Add script
                echo ($site->input_text('descr', 'site_descr', true, false, true));
            } ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>