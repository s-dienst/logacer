<?php
    
    $error_message = false;

    if (!isset($_SESSION['user'])) {
        $error_message = 'no_connexion';
    } else {
        /* Si objet déjà existant */
        if (isset($params['idobject'])) {
            $object = ObjectTable::find_by_id($params['idobject']);
            if (!$object) {
                $error_message = 'no_object';
            } elseif (!PROJECT) {
                $error_message = 'no_project';
            } elseif (!ISOLATED_WEBSITE && (!$object->related_context()->related_phase()->related_site()->project() || $object->related_context()->related_phase()->related_site()->project()->id() !== PROJECT->id())) {
                $error_message = 'not_content_project';
            } elseif (isset($_POST['object'])) {
                $_POST['object']['related_context'] = $object->related_context()->id();
                $_POST['object']['id'] = $object->id();
                $object = new ObjectTable($_POST['object']);
                /* Initialise le titre */
                $title = ucfirst(thesaurus('modifications')) . thesaurus(":") . $object->codename();
            } else {
                /* Initialise le titre */
                $title = ucfirst(thesaurus('modifications')) . thesaurus(":") . $object->codename();
            }
        } else {
            $site = Site::find_by_owner_code($params['idowner'], dec_sl($params['codesite']));
            if ($site) {
                /* Récupère les informations du site */
                $phase = Phase::find_by_site_code($site->id(), dec_sl($params['codephase']));
                if ($phase) {
                        $context = Context::find_by_phase_code($phase->id(), dec_sl($params['codecontext']));
                        if ($context) {
                            if (isset($_POST['object'])) {
                                $_POST['object']['related_context'] = $context->id();
                                $object = new ObjectTable($_POST['object']);
                                $title = ucfirst(thesaurus('new') . ' ' . thesaurus('object'));
                            } else {
                                $object = new ObjectTable(['related_context'=>$context->id()]);
                                $title = ucfirst(thesaurus('new') . ' ' . thesaurus('object'));
                            }
                        } else { $error_message = 'no_context'; }
                } else { $error_message = 'no_phase'; }
            } else { $error_message = 'no_site'; }
        }
    }

    if (!$error_message) {
        if (!$object->contributor_rights()) { $error_message = 'not_contributor'; }
    }

    if ($_POST && !$error_message) {
        $success = $object->save();
        if ($success) {
            header('Location: ' . $object->url());
            exit();
        }
    }
?>

<!DOCTYPE html>
<html>
    <?php require_once("../layout/headers.php"); ?>
    <!-- If biblio review, special color -->
    <body>
        <?php require_once("../layout/navbars.php"); ?>
        <div class="maindiv container">
            <!-- Error message -->
            <?php if ($error_message) { display_fatal_error($error_message); } else {

                echo h(2, $title);

                $object->display_errors();

                // Initiate form
                $object->form('begin');
                echo "<ul>";
                /* Cherche les méthodes de comptage à afficher (copié de context.php) */
                $countings = [];
                if (isset($site)) {
                    $countings_obj = Counting::linked('counting', 'site', $site->id(), true);
                } else {
                    $countings_obj = Counting::linked('counting', 'site', $object->related_context()->related_phase()->related_site()->id(), true);
                }
                foreach ($countings_obj as $count) {
                    $countings[] = $count->id();
                }

                /* Crée la liste des fonctions à appeler pour afficher dans l'objet */
                if (PROJECT && PROJECT->setting_horizon()) {
                    $list_functions = ['horizon', 'site', 'phase', 'context'];
                } else {
                    $list_functions = ['site', 'phase', 'context'];
                }
                /* Affiche les propriétés non modifiables de l'objet */
                foreach ($list_functions as $function) {
                    $html = $object->$function("", true);
                    if ($html !== false) {
                        echo li($html);
                    }
                }

                /* Crée la liste des propriétés à créer */
                if ($site->project()->setting_litterature() && ($object->related_context()->biblio_review() || $object->category_litt() || $object->function_litt() || $object->type_litt() || $object->fabric_litt())) {
                    $list_properties = ['number'=>'text', 'category_abbr'=>'text', 'category_litt'=>'text',
                        'function_name'=>'text', 'function_litt'=>'text',
                        'type_name'=>'text', 'type_var'=>'text', 'type_doubt'=>'text', 'type_litt'=>'text',
                        'fabric_code'=>'text', 'fabric_litt'=>'text', 'stamp'=>'text'];
                } else {
                    $list_properties = ['number'=>'text', 'category_abbr'=>'text',
                        'function_name'=>'text',
                        'type_name'=>'text', 'type_var'=>'text', 'type_doubt'=>'text',
                        'fabric_code'=>'text', 'stamp'=>'text'];
                }
                if (in_array(1, $countings)) { $list_properties += ['n_rim'=>'number', 'n_bottom'=>'number', 'n_handle'=>'number', 'n_wall'=>'number']; }
                if (in_array(2, $countings)) { $list_properties += ['n_mni'=>'number']; }
                if (in_array(3, $countings)) { $list_properties += ['n_sherd'=>'number']; }
                $list_properties += ["diameter"=>'text', "comment"=>'text'];
                /* Affiche les inputs des propriétés de l'objet */
                foreach ($list_properties as $property=>$check) {
                    if ($check === 'text') {
                        echo li($object->input($property, 'object_' . $property));
                    } elseif ($check === 'number') {
                        echo li($object->input_number($property, 'object_' . $property, 0));
                    }
                }
                echo "</ul>";
                $object->form('end');
            } ?>
            </div>
            <?php require_once("../layout/footer.php"); ?>
        </body>
    </html>