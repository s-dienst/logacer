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
            } else {
                /* Récupère les informations du de la phase */
                $phase = Phase::find_by_site_code($site->id(), dec_sl($params['codephase']));
                if ($phase) {
                    if (isset($params['codecontext'])) {
                        $context = Context::find_by_phase_code($phase->id(), dec_sl($params['codecontext']));
                        if (!$context) {
                            $error_message = 'no_context';
                        } elseif (isset($_POST['object'])) {
                            if (empty($_POST['object']['related_phase'])) {
                                $new_phase = Phase::find_by_site_code($site->id(), '00');
                                if ($new_phase) {
                                    $_POST['object']['related_phase'] = $new_phase->id();                                
                                } else {
                                    $_POST['object']['related_phase'] = $phase->id();
                                }
                            }
                            $_POST['object']['id'] = $context->id();
                            $context = new Context($_POST['object']);
                            /* Initialise le titre */
                            $title = ucfirst(thesaurus('modifications')) . thesaurus(":") . $context->codename();
                        } else {
                            /* Initialise le titre */
                            $title = ucfirst(thesaurus('modifications')) . thesaurus(":") . $context->codename();
                        }
                    } elseif (isset($_POST['object'])) {
                    if (empty($_POST['object']['related_phase'])) {
                        $new_phase = Phase::find_by_site_code($site->id(), '00');
                        if ($new_phase) {
                            $_POST['object']['related_phase'] = $new_phase->id();                                
                        } else {
                            $_POST['object']['related_phase'] = $phase->id();
                        }
                    }
                    $context = new Context($_POST['object']);
                        $title = ucfirst(thesaurus('new') . ' ' . thesaurus('context'));
                    } else {
                        $context = new Context(['related_phase'=>$phase->id()]);
                        $title = ucfirst(thesaurus('new') . ' ' . thesaurus('context'));
                    }
                } else {
                    $error_message = 'no_phase';
                }
            }

        } else {
            $error_message = 'no_site';
        }
        
    }

    if (!$error_message) {
        if (!$context->contributor_rights()) { $error_message = 'not_contributor'; }
    }

    if ($_POST && !$error_message) {
        $success = $context->save();
        if ($success) {
            header('Location: ' . $context->url());
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

                $context->display_errors();
                
                // Initiate form
                $context->form('begin');
                    echo '<br>';
                    echo '<h4>' . $context->input('code', 'context_code', false);
                    if ($_SESSION['user']->is_beginner()) { echo '</h4><h4>'; }
                    echo $context->input('name', 'context_name', false) . '</h4>';
                    echo p(ucfirst(thesaurus('site')) . thesaurus(':') . ' ' . $site->hyperlink() . ".");
                    echo p($context->input('related_phase', 'context_phase') . ".");
                    $site->owner(); $phase->owner(); $context->owner(); echo "<br><br>";
                    if (PROJECT && PROJECT->setting_horizon()) {
                        echo $phase->horizon('display');
                    }
                    echo ($context->input_text('descr', 'context_descr'));
                    echo (h(4, ucfirst(thesaurus('confidentiality and publication state'))));
                    echo p($context->input_checkbox('public', 'context_public'));
                    echo p($context->input_checkbox('unpublished', 'context_unpublished'));
                    echo p($context->input_checkbox('biblio_review', 'context_biblio_review'));
                $context->form('end');
                // Add script
                echo ($context->input_text('descr', 'context_descr', true, false, true));
            } ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>