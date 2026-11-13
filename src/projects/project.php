<?php
// TODOs : suppression (avec bouton)
    /* Récupère les données du projet */
    $error_message = false;
    if (!PROJECT) {
        $error_message = "no_project";
    } else {
        $project = PROJECT;
        /* Initialise le titre */
        $title = $project->code();

        /* Check si visible */
        if (!$project->contributor_rights()) {
            $error_message = 'not_project_contributor';
        }
    }

    if ($_POST && !$error_message) {

        $project->check_post();

        if (isset($_POST['typeaction'])) {
            $project->manage_contributors('back');
            $project->manage_files('back');

            // Gestion des typologies liées
            if (in_array($_POST['typeaction'], ['typologyadded', 'deletetypology'])) {
                $action = $_POST['typeaction'];
                if ($action == 'typologyadded') {
                    /* Vérifie si typologie existe */
                    $new_typology = Typology::find_by_id($_POST['typology']);
                    if (in_array($new_typology, Typology::global_typologies()) && !in_array($new_typology, Typology::linked_with_project())) {
                        $request = Typology::$connexion->query("INSERT INTO link_typology_project (typology, project) VALUES (" . $new_typology->id() . ", " . $project->id() . ")");
                    }
                } elseif ($action == 'deletetypology') {
                    DatabaseObject::delink('typology', 'project', $_POST['typology'], $project->id());
                }
                header('Location: ' . $project->url());
                exit();
            }

            // Gestion des fabrics liés
            if (in_array($_POST['typeaction'], ['fabricadded', 'deletefabric'])) {
                $action = $_POST['typeaction'];
                if ($action == 'fabricadded') {
                    /* Vérifie si typologie existe */
                    $new_fabric = Fabric::find_by_id($_POST['fabric']);
                    if (in_array($new_fabric, Fabric::global_fabrics()) && !in_array($new_fabric, Fabric::linked_with_project())) {
                        $request = Fabric::$connexion->query("INSERT INTO link_fabric_project (fabric, project) VALUES (" . $new_fabric->id() . ", " . $project->id() . ")");
                    }
                } elseif ($action == 'deletefabric') {
                    DatabaseObject::delink('fabric', 'project', $_POST['fabric'], $project->id());
                }
                header('Location: ' . $project->url());
                exit();
            }
        } elseif (isset($_POST['object'])) {
            // Autres modifications
            $_POST['object']['id'] = $project->id();
            if (isset($_POST['form']) && $_POST['form'] == 'parameters') {
                if (isset($_POST['object']['setting_horizon_adv'])) {
                    $_POST['object']['setting_horizon'] = 2;
                    unset($_POST['object']['setting_horizon_adv']);
                } elseif (isset($_POST['object']['setting_horizon'])) {
                    $_POST['object']['setting_horizon'] = 1;
                } else {
                    $_POST['object']['setting_horizon'] = 0;
                }
                if (isset($_POST['object']['setting_notes_pub'])) {
                    $_POST['object']['setting_notes'] = 2;
                    unset($_POST['object']['setting_notes_pub']);
                } elseif (isset($_POST['object']['setting_notes'])) {
                    $_POST['object']['setting_notes'] = 1;
                } else {
                    $_POST['object']['setting_notes'] = 0;
                }
                if (isset($_POST['object']['language'])) {
                    foreach ($_POST['object']['language'] as $lang => $on) {
                        if (!in_array($lang, SUPPORTED_LANGUAGES)) {
                            unset($_POST['object']['language'][$lang]);
                        }
                    }
                    if (count($_POST['object']['language']) > 0) {
                        $_POST['object']['langs'] = implode(';', array_keys($_POST['object']['language']));
                    } else {
                        $_POST['object']['langs'] = 'en';
                    }
                    unset($_POST['object']['language']);
                } else {
                    $_POST['object']['langs'] = 'en';
                }
            }
            $project = new Project($_POST['object']);
            if (isset($_POST['form'])) {
                $project->complete($_POST['form']);
            }
            /* Initialise le site */
            $title = ucfirst(thesaurus('modifications')) . thesaurus(":") . $project->code();
            $success = $project->save();
            if ($success) {
                header('Location: ' . $project->url());
                exit();
            }
        } else {
            /* Initialise le site */
            $title = ucfirst(thesaurus('modifications')) . thesaurus(":") . $project->code();
        }


        // Gestion de la suppression
        if (isset($_POST['typeaction'])) {
            if ($_POST['typeaction'] === 'delete') {
                $project->delete($project->url('parent'));
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


                // Informations about the project
                $project->codename('title');
                $project->owner();
                echo "<br><br>";
                $project->display_errors();

                    // Show and manage contributors
                    $project->manage_contributors('front');

                // Navigation tabs
                if (ISOLATED_WEBSITE) {
                    echo nav_tabs(['description', 'parameters', 'texts', 'pictures']);
                } else {
                    echo nav_tabs(['description', 'parameters', 'texts', 'pictures', 'typologies and fabrics']);
                }
                

                // Project description
                echo "<div id='div_1' style='display:block'><br>";


                // TO DO : button suppression

                // Show and manage files
                $project->manage_files('front');
                echo "<br>";
                $project->form('begin');
                echo "<input type='hidden' name='form' value='base'>";

                echo p(ucfirst(thesaurus("save_tabs_one_by_one")));
                echo p($project->input('code', 'project_code'));
                echo p($project->input('name', 'project_name'));
                echo ($project->input_text('descr', 'project_descr'));

                $project->form('end');
                // Add script
                echo ($project->input_text('descr', 'project_descr', true, false, true));

                echo "</div>";

                // Parameters
                echo "<div id='div_2' style='display:none'><br>";
                echo p(ucfirst(thesaurus("save_tabs_one_by_one")));
                $project->form('begin');
                echo "<input type='hidden' name='form' value='parameters'>";
                    echo "<br>";
                    // TO DO
                    echo h(4, ucfirst(thesaurus("base_parameters")));
                        // Utilisation des news
                        // Intégration des news de la racine d'installation, de certaines pages etc.
                        // APIs
                        // Possibilités de téléchargement
                        echo "NO BASE PARAMETERS NOW";
                    echo h(4, ucfirst(thesaurus("used_languages")));
                    foreach (SUPPORTED_LANGUAGES as $name => $abbr) {
                        $checked = "";
                        if (in_array($abbr, $project->langs())) {
                            $checked = "checked";
                        }
                        echo "<p><input type='checkbox' name='object[language][" . $abbr . "]'
                        id='id_language_" . $abbr . "' " . $checked . "> ". $name . "</p>";
                    }
                    echo h(4, ucfirst(thesaurus("modules")));
                    foreach (['horizon', 'horizon_adv', 'litterature', 'graphs', 'archaeometry', 'notes', 'notes_pub'] as $setting) {
                        echo p($project->input_checkbox('setting_' . $setting, 'project_' . $setting));
                    }
                $project->form('end');
                echo "</div>";

                // Texts
                echo "<div id='div_3' style='display:none'><br>";
                echo p(ucfirst(thesaurus("save_tabs_one_by_one")));
                    echo "<br>";
                    $texts = ["welcome", "about_us", "gdpr", "legals", "footer", "other_databases", "other_tools", "partnerships"];
                    echo p(ucfirst(thesaurus('manage_texts')));
                    echo "<ul>";
                    foreach ($texts as $text) {
                        echo li(hyperlink(ucfirst(thesaurus($text . "_page")), [$project->code(), 'page', $text]));
                    }
                    echo "</ul>";
                echo "</div>";

                // Pictures
                echo "<div id='div_4' style='display:none'><br>";
                echo p(ucfirst(thesaurus("save_tabs_one_by_one")));
                $project->form('begin');
                echo "<input type='hidden' name='form' value='pictures'>";
                    echo "<br>";
                    // Liste des images :
                    echo p($project->input('img_icon', 'project_img_icon'));
                    $project->image('icon', true, false);
                    echo p($project->input('img_band', 'project_img_band'));
                    $project->image('band');
                    echo p($project->input('img_logo', 'project_img_logo'));
                    $project->image('logo');
                    echo p($project->input('img_footer1', 'project_img_footer') . " "
                        . $project->input('link_footer1', 'project_link_footer'));
                    $project->image('footer1');
                    echo p($project->input('img_footer2', 'project_img_footer') . " "
                        . $project->input('link_footer2', 'project_link_footer'));
                    $project->image('footer2');
                    echo p($project->input('img_footer3', 'project_img_footer') . " "
                        . $project->input('link_footer3', 'project_link_footer'));
                    $project->image('footer3');
                    echo p($project->input('img_footer4', 'project_img_footer') . " "
                        . $project->input('link_footer4', 'project_link_footer'));
                    $project->image('footer4');
                    echo p($project->input('img_footer5', 'project_img_footer') . " "
                        . $project->input('link_footer5', 'project_link_footer'));
                    $project->image('footer5');
                $project->form('end');
                echo "</div>";

            if (!ISOLATED_WEBSITE) {
                // Typologies and fabrics
                echo "<div id='div_5' style='display:none'><br>";
                echo p(ucfirst(thesaurus("save_tabs_one_by_one")));
                    echo "<br>";

                    // Possibilité d'ajouter des typologies de base ou non, ainsi que des groupes de pâtes de base ou non.
                    // Liste et ajout des typologies
                    echo h(4, ucfirst(thesaurus("global_linked_typologies")));
                    $typologies = Typology::linked_with_project();
                    $html = '<ul>';
                    $action = false;
                    if (isset($_POST['typeaction'])) {
                        if (in_array($_POST['typeaction'], ['addtypology', 'typologyadded', 'deletetypology'])) { $action = $_POST['typeaction']; }
                    }
                    foreach ($typologies as $typology) {
                        if (!$action) {
                            $html2 = "<form action='" . $project->url() . "' method='post'>";
                            $html2 .= $typology->codename('link');
                            $html2 .= button_delete_sm('typology', $typology->id());
                            $html .= li($html2 . "</form>");
                        } else {
                            $html .= li($typology->codename('link'));
                        }
                    }
                    $html2 = "<form action='" . $project->url() . "' method='post'>";
                    if ($action === "addtypology") {
                        $html2 .= "<label for='typology'>" . ucfirst(thesaurus("select typology") . thesaurus(":")) . "</label>";
                        $html2 .= "<select name='typology' id='id_typology'>";
                        $html2 .= opt('0', "-- " . thesaurus("select typology") . " --");
                        $all_typologies = Typology::global_typologies();
                        foreach ($all_typologies as $t) {
                            if (!in_array($t, $typologies)) {
                                $html2 .= opt($t->id(), $t->codename());
                            }
                        }
                        $html2 .= "</select>";
                        $html2 .= buttons_validate_sm($project->url(), 'typology');
                    } elseif (!$action) {
                        $html2 .= button_add_sm('a typology', 'typology');
                    }
                    $html2 .= "</form>";
                    $html .= li($html2);
                    $html .= '</ul>';
                    echo $html;

                    // Liste et ajout des groupes de pâtes
                    echo h(4, ucfirst(thesaurus("global_linked_fabrics")));
                    $fabrics = Fabric::linked('fabric', 'project', $project->id(), true);
                    $html = '<ul>';
                    $action = false;
                    if (isset($_POST['typeaction'])) {
                        if (in_array($_POST['typeaction'], ['addfabric', 'fabricadded', 'deletefabric'])) { $action = $_POST['typeaction']; }
                    }
                    foreach ($fabrics as $fabric) {
                        if (!$action) {
                            $html2 = "<form action='" . $project->url() . "' method='post'>";
                            $html2 .= $fabric->codename('link');
                            $html2 .= button_delete_sm('fabric', $fabric->id());
                            $html .= li($html2 . "</form>");
                        } else {
                            $html .= li($fabric->codename('link'));
                        }
                    }
                    $html2 = "<form action='" . $project->url() . "' method='post'>";
                    if ($action === "addfabric") {
                        $html2 .= "<label for='fabric'>" . ucfirst(thesaurus("select fabric") . thesaurus(":")) . "</label>";
                        $html2 .= "<select name='fabric' id='id_fabric'>";
                        $html2 .= opt('0', "-- " . thesaurus("select fabric") . " --");
                        $all_fabrics = Fabric::global_fabrics();
                        foreach ($all_fabrics as $f) {
                            if (!in_array($f, $fabrics)) {
                                $html2 .= opt($f->id(), $f->codename());
                            }
                        }
                        $html2 .= "</select>";
                        $html2 .= buttons_validate_sm($project->url(), 'fabric');
                    } elseif (!$action) {
                        $html2 .= button_add_sm('a fabric', 'fabric');
                    }
                    $html2 .= "</form>";
                    $html .= li($html2);
                    $html .= '</ul>';
                    echo $html;

                echo "</div>";
            }
            } ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>