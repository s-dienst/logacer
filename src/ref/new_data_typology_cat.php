<?php
    $error_message = false;
    $new = true;

    if (!isset($_SESSION['user'])) {
        $error_message = 'no_connexion';
    } elseif ((ISOLATED_WEBSITE || !PROJECT) && !$_SESSION['user']->is_contributor()) {
        $error_message = 'no_contributor_rights';
    } elseif (PROJECT && !ISOLATED_WEBSITE && !PROJECT->contributor_rights()) {
        $error_message = 'not_project_contributor';
    } else {
        /* Récupère les informations de la typologie */
        $typology = Typology::find_by_id($params['idtypology']);
        $new = false;
        $all_categories = Category::find_all();
        $typo_categories = Category::linked('typology', 'category', $typology->id());
        if (!$typology) {
            $error_message = 'no_typology';
        } else {
            /* Initialise le titre */
            $title = ucfirst(thesaurus('modifications')) . thesaurus(":") . $typology->codename() . " (" . thesaurus("categories") . ")";
        }
    }

    if (!$error_message) {
        if (!$typology->contributor_rights()) { $error_message = 'not_contributor'; }
    }

    if ($_POST && !$error_message) {
        $authorized = true;
        if (!isset($_POST['category'])) {
            $error_typology = 'typology_need_one_category';
            $authorized = false;
        } else {
            foreach ($all_categories as $category) {
                if (in_array($category, $typo_categories) && !(isset($_POST['category'][$category->code()]))) {
                    /* TODO : DELIER CATEGORIE ; la méthode vérifie s'il y a des objets avec
                    des types présents dans la typologie correspondant à la catégorie ; si oui,
                    erreur et return false ; sinon, return true */
                    $authorized = $typology->delink_cat($category->id());
                } elseif (!in_array($category, $typo_categories) && (isset($_POST['category'][$category->code()]))) {
                    /* TODO : LIER CATEGORIE ; la méthode vérifie si il n'y a pas de types
                    avec le nom des types de la typologie dans la catégorie ; s'il y en a,
                    erreur et return false ; sinon, return true */
                    $authorized = $typology->link_cat($category->id());
                }
            }
        }
        if ($authorized) {
            header('Location: ' . $typology->url());
            exit();
        }
    }

?>

<!DOCTYPE html>
<html>
    <?php require_once("../layout/headers.php"); ?>
    <body>
        <!-- SCRIPT FOR COLOR - NOT WORKING NOW -->
    <script>
        function toggleColor(color, code) {
            var idcheckbox = 'id_category_' + code;
            var idlabel = code + '_label';
            var checkbox = document.getElementById(idcheckbox);
            var label = document.getElementById(idlabel);
            // Définir les couleurs personnalisées
            if (checkbox.checked) {
                label.style.background-color = color;
                label.style.color = '#FFFFFF';
                label.style.border = '1px solid #FFFFFF';
            } else {
                label.style.background-color = "#FFFFFF";
                label.style.color = color;
                label.style.border = '1px solid ' + color;
            }
        }; </script>
        <?php require_once("../layout/navbars.php"); ?>
        <div class="maindiv container">
            <!-- Error message -->
            <?php if ($error_message) { display_fatal_error($error_message); } else {
                
                if (isset($error_typology)) {
                    display_fatal_error($error_typology);
                }

                // Informations about the typology
                $typology->codename('title');
                $typology->owner();
                $typology->project('display');
                echo "<br><br>";

                $typology->display_errors();

                // Début form
                echo "<form action='" . $typology->url('update_category') . "' method='post' name='form'>";
                
                echo h(3, ucfirst(thesaurus('list of the categories')));

                echo p(ucfirst(thesaurus('can sort by clicking headers')));
                // Filtres
                filter_box(['cat_code', 'cat_name'], 'category_table');
                echo "<table class='table' id='category_table'><thead>";
                    // Création du header
                    table_headers(['cat_code', 'cat_name'], 'category_table');
                echo "</thead><tbody>";
                foreach ($all_categories as $category) {
                    echo "<tr>";
                    $category->code(['button', $typology->id()]);
                    echo $category->name('table');
                    echo "</tr>";
                }
                echo "</tbody></table>";

                echo "<div class='btn-group' role='group'>
                    <input class='btn btn-success' type='submit' value='" . ucfirst(thesaurus('modify')) . ' ' . thesaurus('the categories') . "'>
                    <a class ='btn btn-secondary' href='" . $typology->url() . "'>" . ucfirst(thesaurus('give up')) . "</a>
                    </div><br><br>";
            // Pour ajouter un POST vide
            echo "<input type='hidden' name='check' value='check'>";
            // Fin form
            echo "</form>";

            } ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>