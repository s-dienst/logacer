<?php
    /* Récupère les données de l'objet */
    $error_message = false;
    $object = ObjectTable::find_by_id($params['idobject']);
    if (!PROJECT) {
        $error_message = 'no_project';
    } elseif ($object && !ISOLATED_WEBSITE) {
        if (PROJECT->id() !== $object->related_context()->related_phase()->related_site()->project()->id()) {
            $object = false;
        }
    }
    if ($object) {
        /* Initialise le titre */
        $title = $object->codename();

        /* Cherche les sites, phases, contextes (pour moins se casser la tête et code plus propre) */
        $context = $object->related_context();
        $phase = $context->related_phase();
        $site = $phase->related_site();

        /* Illustrations */
        $pictures = Picture::find_by_parent($object->id());

        /* Check si visible */
        if (!$context->public() && !$object->contributor_rights()) {
            $error_message = 'non_public_object';
        }

    } else {
        $error_message = 'no_object';
    }

    if ($_POST && !$error_message) {

        $object->check_post();

        $object->manage_files('back');
        if (isset($_POST['typeaction'])) {
            if ($_POST['typeaction'] === 'delete') {
                $object->delete($object->url('parent'), ['picture']);
            }
        }
    }
?>

<!DOCTYPE html>
<html>
    <?php require_once("../layout/headers.php"); ?>
    <!-- If biblio review, special color -->
    <?php if ($object) { $context->biblio_review('body'); } else { echo "<body>"; } ?>
        <?php require_once("../layout/navbars.php"); ?>
        <div class="maindiv container">
            <!-- Error message -->
            <?php if ($error_message) { display_fatal_error($error_message); } else {

                // If biblio review, special display
                $context->biblio_review('message');

                // Buttons for the object
                $object->buttons_contrib();

                // Informations about the object
                $object->codename('title');
                $site->owner(); $object->owner();
                echo "<br><br>";
                $object->display_errors();

                if ($object->contributor_rights() || count($pictures) > 0) {
                    echo nav_tabs(['description', 'pictures']);
                    $nav_tabs = true;
                } else {
                    $nav_tabs = false;
                }

                echo "<div id='div_1' style='display:block'><br>";
                echo h(4, ucfirst(thesaurus('object description')));
                echo "<ul>";
                /* Cherche les méthodes de comptage à afficher (copié de context.php) */
                $countings = [];
                $countings_obj = Counting::linked('counting', 'site', $site->id(), true);
                foreach ($countings_obj as $count) {
                    $countings[] = $count->id();
                }
                /* Crée la liste des fonctions à appeler pour afficher dans l'objet */
                if (PROJECT && PROJECT->setting_horizon()) {
                    $list_functions = ['horizon', 'site', 'phase', 'context', 'number', 'category', 'function', 'type', 'fabric', 'stamp'];
                } else {
                    $list_functions = ['site', 'phase', 'context', 'number', 'category', 'function', 'type', 'fabric', 'stamp'];
                }
                if (in_array(1, $countings)) { array_push($list_functions, 'n_rim', 'n_bottom', 'n_handle', 'n_wall'); }
                if (in_array(2, $countings)) { array_push($list_functions, 'n_mni'); }
                if (in_array(3, $countings)) { array_push($list_functions, 'n_sherd'); }
                array_push($list_functions, "diameter", "comment");
                /* Affiche les propriétés de l'objet */
                foreach ($list_functions as $function) {
                    $html = $object->$function("", true);
                    if ($html !== false) {
                        echo li($html);
                    }
                }
                echo "</ul>";

                // Show and manage files
                $object->manage_files('front');
                echo "</div>";

                echo "<div id='div_2' style='display:none'><br>";
                echo h(4, ucfirst(thesaurus('pictures')));
                if ($object->contributor_rights()) {
                    echo "<a class ='btn btn-outline-success' href='" . $object->url('new_picture') . "'>" . ucfirst(thesaurus('add') . ' ' . thesaurus('a picture')) . "</a>";
                }
                echo "<div class='gallery'>";
                foreach ($pictures as $picture) {
                    $picture->display();
                }
                echo "</div>";
                // Ajout cadre pour affichage image en grand
                Picture::lightbox();
                echo "</div>";

                // Commentaires liés
                if (PROJECT->setting_notes()) {
                    $comment_class = 'ObjectTable';
                    $comment_id = $object->id();
                    require_once('../users/comments.php');
                }

                $object->cite_page();
            } ?>
            </div>
            <?php require_once("../layout/footer.php"); ?>
        </body>
    </html>