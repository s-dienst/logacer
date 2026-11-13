<?php
    $error_message = false;

    if (!isset($_SESSION['user'])) {
        $error_message = 'no_connexion';
    } else {
        $object = ObjectTable::find_by_id($params['idobject']);
        if ($object) {
            if (!ISOLATED_WEBSITE && (!$object->related_context()->related_phase()->related_site()->project() || $object->related_context()->related_phase()->related_site()->project()->id() !== PROJECT->id())) {
                $error_message = 'not_content_project';
            } elseif (isset($params['idpicture'])) {
                /* Récupère les informations de l'illustration */
                $picture = Picture::find_by_id($params['idpicture']);
                if (!$picture) {
                    $error_message = 'no_picture';
                } elseif (isset($_POST['object'])) {
                    $_POST['object']['related_object'] = $object->id();
                    $_POST['object']['id'] = $picture->id();
                    $_POST['object']['biblio_reference'] = Bibliography::find_by_abbr($_POST['object']['biblio_reference'])->id();
                    $picture = new Picture($_POST['object']);
                    /* Initialise le titre */
                    $title = $picture->codename();
                } else {
                    /* Initialise le titre */
                    $title = $picture->codename();
                }
                
            } elseif (isset($_POST['object'])) {
                $_POST['object']['related_object'] = $object->id();
                $biblio = Bibliography::find_by_abbr($_POST['object']['biblio_reference']);
                if ($biblio) {
                    $_POST['object']['biblio_reference'] = $biblio->id();
                }
                $picture = new Picture($_POST['object']);
                $title = ucfirst(thesaurus('new') . ' ' . thesaurus('picture'));
            } else {
                $picture = new Picture(['related_object'=>$object->id()]);
                $title = ucfirst(thesaurus('new') . ' ' . thesaurus('picture'));
            }
        } else {
            $error_message = 'no_object';
        }
    }

    if (!PROJECT) {
        $error_message = 'no_project';
    }

    if (!$error_message) {
        if (!$picture->contributor_rights()) { $error_message = 'not_contributor'; }
    }

    if ($_POST && !$error_message) {
        // Converti les numéros de la liste de valeurs en valeur par défaut
        $picture->convert('type_picture');
        $picture->convert('storage');

        // Si suppression :
        if (isset($_POST['typeaction'])) {
            if ($_POST['typeaction'] === 'delete') {
                $picture->delete($picture->url('parent'));
            }
        }

        // Si nécessaire : update le fichier d'image
        $update = $picture->update_file();
        if ($update) {
            if ($picture->storage() !== 'local') {
                $ancient_pic = Picture::find_by_id($picture->id());
                if ($ancient_pic) { $ancient_pic->delink_local_file(); }
            }
            $success = $picture->save();
            if ($success) {
                if (isset($params['idpicture'])) {
                    $success_message = "<div class='alert alert-success'>" . thesaurus('success_modifications_pictures') . "</div>";
                } else {
                    header('Location: ' . $picture->url());
                    exit();
                }
                // 
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

                // Bouton de suppression
                if ($picture->owner_rights()) {
                    $html = "<br><button class='btn btn-outline-danger' type='submit' form='delete'>" . ucfirst(thesaurus('delete')) . "</button>";
                    $html .= "<form action='" . $picture->url() ."' id='delete' method='post'>";
                    $html .= "<input type='hidden' name='typeaction' value='delete'></form><br><br>";
                    echo $html;
                }
                
                if ($picture->name()) { echo h(2, ucfirst(thesaurus('picture'))); }

                /* Crée la liste des fonctions à appeler pour afficher dans l'objet */
                if (PROJECT && PROJECT->setting_horizon()) {
                    $list_functions = ['horizon', 'site', 'phase', 'context', 'number'];
                } else {
                    $list_functions = ['site', 'phase', 'context', 'number'];
                }

                /* Affiche les propriétés non modifiables de l'objet */
                echo "<p>";
                foreach ($list_functions as $function) {
                    $html = $object->$function("", true);
                    if ($html !== false) {
                        echo $html . "<br>";
                    }
                }
                echo "</p>";

                $picture->display_errors();
                if (isset($success_message)) { echo $success_message; }

                // Initiate form
                $picture->form('begin', true);
                    echo p($picture->input('name', 'picture_name'));
                    /* Gestion du type */
                    $picture->convert('type_picture', true);
                    echo p($picture->input('type_picture', 'picture_type'));
                    $picture->convert('storage', true);
                    echo p($picture->input('storage', 'picture_storage'));
                    echo "<div id='path_div'></div>";
                    $picture->input_text('url_path', 'picture_url_path', true, false, true);
                    //echo p($picture->input_number('height', 'picture_height', 0));
                    //echo p($picture->input_number('width', 'picture_width', 0));

                    $html = "<datalist id='bibliography'>";
                    $bibliography = Bibliography::find_all();
                    foreach ($bibliography as $item) {
                        $html .= opt($item->codename('not_secure'));
                    }
                    $html .= "</datalist>";
                    echo $html;

                    echo p($picture->input('biblio_reference', 'picture_biblio_reference'));
                    echo p($picture->input('biblio_emplacement', 'picture_biblio_emplacement'));
                    echo p($picture->input('comment', 'picture_comment'));
                $picture->form('end');

                if ($picture->id()) {
                    Picture::find_by_id($picture->id())->display();
                    // Ajout cadre pour affichage image en grand
                    Picture::lightbox();
                }
            } ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>

<!-- Ce script sert à afficher les options en fonction de l'emplacement de stockage -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    let storage_input = document.getElementById("id_storage");
    let path_div = document.getElementById("path_div");
    
    // Crée la fonction qui regarde la valeur et donne une réponse
    function charge_html() {
        switch(storage_input.value) {
            case '1': // Local storage
                html = "<?php echo p($picture->upload()); ?>";
                html += "<?php echo p($picture->input('extension', 'picture_extension')); ?>";
                break;
            case '2': // Online storage
                html = `<?php echo p($picture->input_text('url_path', 'picture_url_path', true, false, false, false)); ?>`;
                break;
            default:
                html = "";
        }
        path_div.innerHTML = html;    
    }

    // L'appelle au changement de valeur
    storage_input.addEventListener('change', charge_html)

    // L'appelle lors du premier chargement
    charge_html();

})
</script>

    </body>
</html>