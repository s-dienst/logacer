
<?php
    if (!isset($_SESSION['user'])) {
        $error_message = 'no_connexion';
    } else {
        $title = ucfirst(thesaurus('my homepage'));
                /* Liste des fichiers */
            /*    $request = $connexion->query("SELECT * FROM file INNER JOIN link_site_file ON link_site_file.file = file.id WHERE link_site_file.site = $idsite");
                $files = $request->fetchAll();*/
    }

    if ($_POST AND !isset($error_message)) {
        $action = $_POST['typeaction'];
        /* Gère la validation ou la suppression de nouveaux utilisateurs */
        if (($action === "validate_user" || $action === "delete_user") && $_SESSION['user']->is_staff()) {
            User::validation_user($action, $_POST['iduser']);
        } elseif ($action === "delete_file") {
            // Gère la suppression de fichiers
            $file_to_delete = File::find_by_id($_POST['idfile']);
            if ($file_to_delete) {
                $file_to_delete->delete(create_url(['homepage']));
            }
        }
    }

    if (!isset($error_message)) {
        /* Si administrateur : liste des personnes à valider */
        if ($_SESSION['user']->is_staff()) {
            $users_to_activate = User::find_by_property('is_activated', 0);
        }
    }
?>

<!DOCTYPE html>
<html>
    <?php require_once("../layout/headers.php"); ?>
    <body>
        <?php require_once("../layout/navbars.php"); ?>
        <div class="maindiv container">
            <!-- Error message if not valid -->
            <?php if (isset($error_message)) { display_fatal_error($error_message); } else {
                
                echo h(1, $title);
                echo '<br>';

                echo p("<a class ='btn btn-primary' href='" . create_url(['myaccount']) . "'>" . ucfirst(thesaurus('modify account info')) . "</a>");
                // Navigation tabs --> VERSION FINALE
                /*if ($_SESSION['user']->is_staff()) {
                    echo nav_tabs(['my data', 'unify my data', 'refs', 'validate users']);
                } else {
                    echo nav_tabs(['my data', 'unify my data', 'refs']);
                }*/
                // Navigation tabs temporaires
                if ($_SESSION['user']->is_staff()) {
                    if (PROJECT || ISOLATED_WEBSITE) {
                        echo nav_tabs(['my data', 'my files', 'refs', 'validate users']);
                        $files_init = "<div class='row' id='div_2' style='display:none'>";
                        $refs_init = "<div class='row' id='div_3' style='display:none'>";
                        $validate_init = "<div class='row' id='div_4' style='display:none'>";
                    } else {
                        echo nav_tabs(['my files', 'refs', 'validate users']);
                        $files_init = "<div class='row' id='div_1' style='display:block'>";
                        $refs_init = "<div class='row' id='div_2' style='display:none'>";
                        $validate_init = "<div class='row' id='div_3' style='display:none'>";
                    }
                } else {
                    if (PROJECT || ISOLATED_WEBSITE) {
                        echo nav_tabs(['my data', 'my files']);
                        $files_init = "<div class='row' id='div_2' style='display:none'>";
                    }
                }
                

                /* Mes données : projets, import de données */
                if (PROJECT || ISOLATED_WEBSITE) {
                    echo "<div class='row' id='div_1' style='display:block'>
                        <div class='col-sm-6'>
                            <br>";
                            // Gestion de l'importation générale des données
                            echo h(3, ucfirst(thesaurus('import data')));

                            // Lien vers le tutorial
                            echo "<p><a href='". create_url(["tutorials", "add-inventory"]) . "' target='_blank' class='btn btn-primary'>" . ucfirst(thesaurus("list tutorials")) . "</a></p>";

                            // Reprise d'un ajout de données si déjà en cours
                            if (file_exists("static/ajax/data_adding_inventory" . $_SESSION['user']->id() . ".json")) {
                                echo "<p><div class='btn-group-vertical' role='group' aria-label='Vertical button group'>
                                    <a href='" . create_url(["new_inventory", "resume"]) . "' class='btn btn-success' role='button'>" . ucfirst(thesaurus("continue_inv")) . "</a>
                                    <a href='" . create_url(["new_inventory", "drop"]) . "' id='drop_upload' class='btn btn-danger' role='button'>" . ucfirst(thesaurus("giveup_inv")) . "</a>
                                    </div></p>";
                                $upload_ongoing = " id='drop_upload' ";
                            } elseif (file_exists("static/ajax/data_adding_context" . $_SESSION['user']->id() . ".json")) {
                                echo "<p><div class='btn-group-vertical' role='group' aria-label='Vertical button group'>
                                    <a href='" . create_url(["new_context", "resume"]) . "' class='btn btn-success' role='button'>" . ucfirst(thesaurus("continue_contexts")) . "</a>
                                    <a href='" . create_url(["new_context", "drop"]) . "' id='drop_upload' class='btn btn-danger' role='button'>" . ucfirst(thesaurus("giveup_contexts")) . "</a>
                                    </div></p>";
                                $upload_ongoing = " id='drop_upload' ";
                            } elseif (file_exists("static/ajax/data_adding_site" . $_SESSION['user']->id() . ".json")) {
                                echo "<p><div class='btn-group-vertical' role='group' aria-label='Vertical button group'>
                                    <a href='" . create_url(["new_site", "resume"]) . "' class='btn btn-success' role='button'>" . ucfirst(thesaurus("continue_sites")) . "</a>
                                    <a href='" . create_url(["new_site", "drop"]) . "' id='drop_upload' class='btn btn-danger' role='button'>" . ucfirst(thesaurus("giveup_sites")) . "</a>
                                    </div></p>";
                                $upload_ongoing = " id='drop_upload' ";
                            } else {
                                $upload_ongoing = " ";
                                // Formulaire pour ajouter les données 
                                echo "<form enctype='multipart/form-data' id='form_add' action='' method='post'>";
                                    // Crée les différentes options possibles
                                    echo "<p><select class='form-select' id='select_csv_added'>";
                                    $list_added = ['select option', 'sites', 'phases_contexts', 'objects'];
                                    foreach ($list_added as $add) {
                                        echo opt($add, ucfirst(thesaurus($add)));
                                    }
                                    echo "</select></p>";
                                    // Permet de choisir le mode d'ajout
                                    echo p("<input class='form-control' type='file' name='file_to_upload' id='file_to_upload' required>");
                                    echo "<div class='form-check form-switch'>
                                        <input class='form-check-input' type='checkbox' name='check_all' id='check_all' value='1' checked>
                                        <label class='form-check-label' for='check_all'>" . ucfirst(thesaurus("show_correct_data")) . "</label>
                                        </div>";
                                    echo p("<input class='btn btn-primary' type='submit'" . $upload_ongoing . "value='" . ucfirst(thesaurus('add')) . "'>");
                                echo "</form>";

                            }

                            // Formulaire pour télécharger les templates
                            $list_templates = File::find_by_property('type', 'template_import');
                            echo h(4, ucfirst(thesaurus('templates')));
                            echo p(ucfirst(thesaurus('download templates here')));
                            echo "<form method='GET' id='form_template' action='" . create_url(['files', 'download', $list_templates[0]->id()]) . "'>";
                                echo "<p><select class='form-select' id='version' name='version'>";
                                foreach ($list_templates as $templates) {
                                    echo opt($templates->id(), $templates->descr_file());
                                }
                                echo "</select></p>";
                                echo "<input class='btn btn-outline-primary' type='submit' value='" . ucfirst(thesaurus('download')) . "'>
                            </form>";
                    echo "</div></div>";
                    ?>

    <script>
        // Gère l'URL pour l'ajout de nouvelles données
    document.getElementById("select_csv_added").addEventListener("change", function() {
        var selected = this.value;
        var form_add = document.getElementById("form_add");
        var links_url = {
            'select option':'',
            'sites':'<?php echo create_url(['new_site']); ?>',
            'phases_contexts':'<?php echo create_url(['new_context']); ?>',
            'objects': '<?php echo create_url(['new_inventory']); ?>'
        };
        form_add.action = links_url[selected];
    });

        // Gère l'URL pour la sélection du template
    document.getElementById("version").addEventListener("change", function() {
        var selected = this.value;
        var form_add = document.getElementById("form_template");
        var links_url = {
            <?php
            foreach ($list_templates as $templates) {
                echo "'" . $templates->id() . "':'" . create_url(['files', 'download', $templates->id()]) . "',";
            }
                ?>
        };
        form_add.action = links_url[selected];
    });

    </script>                    
                <?php } ?>

            <?php if (PROJECT || ISOLATED_WEBSITE || $_SESSION['user']->is_staff()) {
                echo $files_init .
                    "<div class='col-sm-6'>
                        <br>";
                        button_new('file', ['files', 'addfile']);
                        echo h(4, ucfirst(thesaurus('my files')));
                        $files = File::find_all();
                        echo "<ul>";
                        foreach ($files as $file) {
                            if (!ISOLATED_WEBSITE) {
                                if (PROJECT) {
                                    if (!$file->project() || $file->project()->id() !== PROJECT->id()) {
                                        continue;
                                    }
                                } else {
                                    if ($file->project()) {
                                        continue;
                                    }
                                }
                            }
                            if ($file->contributor_rights()) {
                                $html = "<form action='" . create_url(['homepage']) . "' method='post'>";
                                $html .= $file->codename('link');
                                $html .= " <input class='btn btn-light btn-sm delete' type='submit' value='" . ucfirst(thesaurus("delete")) . "'>";
                                $html .= "<input name='typeaction' type='hidden' value='delete_file'>";
                                $html .= "<input type='hidden' name='idfile' value='" . $file->id() . "'>";
                                echo li($html . "</form>");
                            }
                        }
                        echo "</ul>";
                    echo "</div>
                </div>";
            } ?>

                <div class="row" id="div_x" style="display:none"> <!-- changer ID après mise en place -->
                    <div class="col-sm-6">
                        <h4>Unifier les objets créés avec le référentiel</h4>
                        <div class="btn-group-vertical" role="group">
                            <a class ="btn btn-outline-primary" href="{% url 'list_categories_without_link' %}">Liste des objets sans lien avec la catégorie</a>
                            <a class ="btn btn-outline-primary" href="{% url 'list_functions_without_link' %}">Liste des objets sans lien avec la fonction</a>
                            <a class ="btn btn-outline-primary" href="{% url 'list_types_without_link' %}">Liste des objets sans lien avec le type</a>
                            <a class ="btn btn-outline-primary" href="{% url 'list_fabrics_without_link' %}">Liste des objets sans lien avec le groupe de pâtes</a>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <h1 style="color:darkred">En construction !</h1>
                    </div>
                </div>

                <?php if ($_SESSION['user']->is_staff()) {
                    echo $refs_init; ?>
                    <br>
                    <div class="col-sm-6">
                        <h4><?php echo ucfirst(thesaurus("countrys")) . " " . thesaurus("and") . " " . thesaurus("regions"); ?></h4>
                            <a class ="btn btn-outline-primary" href="<?php echo create_url_proj(['geography']); ?>"><?php echo ucfirst(thesaurus("list of the countries and regions")); ?></a>
                            <br>
                            <br>

                        <?php if ($_SESSION['user']->is_contributor()) { ?>
                        <h4><?php echo ucfirst(thesaurus("categories")) . " " . thesaurus("and") . " " . thesaurus("functions"); ?></h4>
                        <div class="btn-group-vertical" role="group">
                            <a class ="btn btn-outline-primary" href="<?php echo create_url_proj(['categories']); ?>"><?php echo ucfirst(thesaurus("list of the categories")); ?></a>
                            <a class ="btn btn-outline-primary" href="<?php echo create_url_proj(['functions']); ?>"><?php echo ucfirst(thesaurus("list of the functions")); ?></a>
                        </div>
                        <br>
                        <br>
                        <?php } ?>

                        <h4><?php echo ucfirst(thesaurus("countings")); ?></h4>
                        <a class ="btn btn-outline-primary" href="<?php create_url_proj(['counting']); ?>"><?php echo ucfirst(thesaurus("list of the countings")); ?></a>

                    </div>
                </div>

                <?php } ?>

                <?php if ($_SESSION['user']->is_staff()) {
                // CHanger ID en div_5 après mise en place
                echo $validate_init .
                    '<div class="col-sm-6">
                    <br>';
                        // Activate user form; check if user can do that before adding code
                        if ($_SESSION['user']->is_staff()) {
                            // Display title
                            echo h(4, ucfirst(thesaurus('validate users')));
                            // If no user to add, there is a message indicating it
                            if (count($users_to_activate) == 0) {
                                echo "<li class='no-info'>" . ucfirst(thesaurus('no_user_to_validate')) . "</li>";
                            } else {
                                // Display a form for each user, with an iduser input with the id of the user and two typeaction buttons: a validate_user to activate and delete_user to delete it
                                echo "<ul>";
                                foreach ($users_to_activate as $user) {
                                    $html = "<form action='" . create_url(['homepage']) . "' method='post'>";
                                    $html .= $user->codename() . " (Mail: " . $user->mail() . ") ";
                                    $html .= "<div class='btn-group' role='group'>";
                                    $html .= "<button class='btn btn-success btn-sm' name='typeaction' type='submit' value='validate_user'>" . ucfirst(thesaurus("validate")) . "</button>";
                                    $html .= "<button class='btn btn-danger btn-sm' name='typeaction' type='submit' value='delete_user'>" . ucfirst(thesaurus("delete")) . "</button>";
                                    $html .= "</div>";
                                    $html .= "<input type='hidden' name='iduser' value='" . $user->id() . "'>";
                                    echo li($html . "</form>");
                                }
                                echo "</ul>";
                            }
                        }
                    echo '</div>
                </div>';
                }
             /* endif for error message */ } ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>