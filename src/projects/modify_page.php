<?php
    $error_message = false;

    if (!PROJECT) {
        $error_message = "no_project";
    } else {
        $project = PROJECT;
        $pn = $params['pagename'];
        $lang = $params['lang'];
        $text = AppText::find_lang($pn, $lang, $project->id());
        /* Initialise le titre */
        $title = $project->code() . thesaurus(':') . ' ' . thesaurus($pn . "_page") . " (" . strtoupper($lang) . ")";

        /* Check si visible */
        if (!$project->contributor_rights()) {
            $error_message = 'not_project_contributor';
        } elseif (!in_array($pn, ["welcome", "about_us", "gdpr", "legals", "footer", "other_databases", "other_tools", "partnerships"])) {
            $error_message = 'not_existing_page';
        } elseif (!in_array($lang, $project->langs())) {
            $error_message = 'not_project_language';
        }
    }

    if ($text && isset($_POST['object'])) {
        /* Récupère les informations du texte */
        $_POST['object']['id'] = $text->id();
        if ($_POST['object']['format'] == 'markdown') {
            $_POST['object']['content'] = $_POST['object']['content_md'];
        }
        unset($_POST['object']['content_md']);
        $_POST['object']['project'] = $project->id();
        $_POST['object']['lang'] = $lang;
        $_POST['object']['page'] = $pn;
        $text = new AppText($_POST['object']);
    } elseif (isset($_POST['object'])) {
        if ($_POST['object']['format'] == 'markdown') {
            $_POST['object']['content'] = $_POST['object']['content_md'];
        }
        unset($_POST['object']['content_md']);
        $_POST['object']['project'] = $project->id();
        $_POST['object']['lang'] = $lang;
        $_POST['object']['page'] = $pn;
        $text = new AppText($_POST['object']);
    } elseif (!$text) {
        $text = new AppText(['project'=>PROJECT->id(), 'lang'=>$lang, 'page'=>$pn]);
    }

    // Suppression ou sauvegarde
    if (isset($_POST['typeaction']) && !$error_message) {
        if ($_POST['typeaction'] === 'delete') {
            $text->delete($text->url('parent'));
        }
    }
    if ($_POST && !$error_message) {
        $success = $text->save();
        if ($success) {
            header('Location: ' . $text->url('parent'));
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
            <!-- Error message if not a valid phase -->
            <?php if ($error_message) { display_fatal_error($error_message); } else {
            
                echo h(2, ucfirst(thesaurus($params['pagename'] . "_page"))  . " (" . strtoupper($lang) . ")");

                $text->display_errors();

                // Initiate form
                $text->form('begin');
                    if ($text->format() === "markdown") {        
                        $display_html = "none";
                        $display_md = "block";
                        $checked_html = "";
                        $checked_md = "checked";
                    } else {
                        $display_html = "block";
                        $display_md = "none";
                        $checked_html = "checked";
                        $checked_md = "";
                    }
                    // Définition du format
                    // Compléter : indications sur HTML/Markdown (dans les boutons radio et dans les divs)
                    echo "<div>
                        <div class='form-check'>
                            <input class='form-check-input' type='radio' name='object[format]' id='format_html' value='html' " . $checked_html . ">
                            <label class='form-check-label' for='format_html'>" . ucfirst(thesaurus('text editor')) . "</label>
                        </div>
                        <div class='form-check'>
                            <input class='form-check-input' type='radio' name='object[format]' id='format_md' value='markdown' " . $checked_md . ">
                            <label class='form-check-label' for='format_md'>Markdown (" . thesaurus('allow advanced edition') . ")</label>
                        </div>
                    </div>";
                    
                    // Si format HTML
                    echo "<div id='div_html' style='display:" . $display_html . "'>";
                    echo p(tutorial('apptext_content'));
                    echo ($text->input_text('content', 'apptext_content', false));
                    echo "</div>";

                    // Si format Markdown
                    echo "<div id='div_md' style='display:" . $display_md . "'>";
                    echo p(thesaurus('apptext_markdown'));
                    echo "<textarea class='form-control' name='object[content_md]' rows='20'></textarea>";
                    echo "</div><br>";
                $text->form('end');
                // Add script
                echo ($text->input_text('content', 'apptext_content', true, false, true));

            } ?>
        </div>
        
        <script>
            // Script choix HTML/Markdown
        document.addEventListener("DOMContentLoaded", function () {
            const radios = document.querySelectorAll(
                'input[name="object[format]"]'
            );

            function updateFormat() {
                const selected = document.querySelector(
                    'input[name="object[format]"]:checked'
                );

                if (!selected) return;

                document.getElementById("div_html").style.display =
                    selected.value === "html" ? "block" : "none";

                document.getElementById("div_md").style.display =
                    selected.value === "markdown" ? "block" : "none";
            }

            radios.forEach(function (radio) {
                radio.addEventListener("change", updateFormat);
            });

            updateFormat();
        });
        </script>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>

<!-- ##### Bienvenue sur la base de données de CeVICA - Céramique et Verre de l'Italie Centrale Antique

Outre le projet lié, CeVICA est une base de données relationnelle dédiée à l’étude du mobilier en céramique et en verre découvert sur de nombreux sites d'Italie centrale, couvrant une période du IVᵉ s. av. J.-C. au VIIᵉ siècle ap. J.-C.

Initiée dans le cadre d’une thèse doctorale (S. Dienst, *Étude chronologique, économique et culturelle de la vaisselle du Piano della Civita à Artena (Latium) depuis la République romaine jusqu'à l'Antiquité tardive*, soutenue à l'Université de Liège sous la direction de X. Deru et consultable [ici](https://hdl.handle.net/2268/318966)), elle regroupe des données issues de sites qui ont, pour la plupart, déjà été publiés, mais en utilisant des référentiels (typologies, fonctions, catégories) diversifiés. Afin de permettre la comparaison, ces publications ont été réexaminées et le mobilier a été uniformisé sous la forme de nouveaux inventaires.

La base de données comprend également du mobilier jusque-là inédit, en premier lieu celui du [Piano della Civita](https://cevica.uliege.be/site/1/AR) à Artena.

##### Un outil en évolution

CeVICA s’appuie sur le logiciel [LOGACer](https://www.logacer.org) (un logiciel online de gestion et d'analyse de données sur la vaisselle archéologique). La structure relationnelle de la base permet des requêtes avancées et des analyses transversales entre les sites.

##### Nous contacter

Cette base est en développement continu. [Contactez-nous](https://cevica.uliege.be/about_us#contact) pour partager vos questions, suggestions ou commentaires, ou apprenez-en plus sur le projet sur la page de [Présentation et contacts](https://cevica.uliege.be/about_us).

Bonne exploration !

— Simon Dienst et l'équipe CeVICA