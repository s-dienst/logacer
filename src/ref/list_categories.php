<?php
    $error_message = false;

    if (!isset($_SESSION['user'])) {
        $error_message = 'no_connexion';
    } else {
        $title = ucfirst(thesaurus('list of the categories'));
        $idmodify = 0;
        if (isset($_POST) && $_SESSION['user']->is_staff()) {
            // Signifie qu'il ne s'agit pas d'une toute nouvelle catégorie
            if (isset($_POST['object'])) {
                if (count($_POST['object']) === 1 && isset($_POST['object']['id'])) {
                    // Signifie que juste l'id est transmise (bouton modify cliqué)
                    $cat_modify = Category::find_by_id($_POST['object']['id']);
                    if ($_POST['typeaction'] == 'delete') {
                        $cat_modify->delete($cat_modify->url(), [], true);
                    }
                } else {
                    // Signifie qu'il y a un formulaire complet (bouton sauvegarde cliqué)
                    $cat_modify = new Category($_POST['object']);
                    if (in_array($_POST['typeaction'], ['categoryadded', 'categorymodified'])) {
                        $success = $cat_modify->save();
                        if ($success) {
                            header('Location: ' . $cat_modify->url());
                            exit();
                        }
                    }
                }
                if (isset($_POST['object']['id'])) { $idmodify = $_POST['object']['id']; }
            } else {
                // On a cliqué sur nouveau
                $cat_modify = new Category();
            }
        } elseif (isset($_POST)) {
            $error_message = 'not_staff';
        }

    }
    

?>

<!DOCTYPE html>
<html>
    <?php require_once("../layout/headers.php"); ?>
    <body>
        <?php require_once("../layout/navbars.php"); ?>
        <div class="maindiv container">
            
        <?php if ($error_message) { display_fatal_error($error_message); } else {

            // Ajouter catégorie
            if ($_SESSION['user']->is_staff()) {
                echo "<form action='" . create_url_proj(['categories']) . "' method='post'>";
                    echo "<input class='btn btn-outline-success' type='submit' value='" . ucfirst(thesaurus('new')) . "'>";
                    echo "<input type='hidden' name='typeaction' value='addcategory'>";
                echo "</form><br>";
            }

            // Titre
            echo h(2, ucfirst(thesaurus('list of the categories')));

            if (isset($cat_modify)) {
                $cat_modify->display_errors();
            }

            if ($_SESSION['user']->is_staff() && isset($_POST['typeaction'])) {
                $action = $_POST['typeaction'];
                if (in_array($action, ['addcategory', 'modifycategory'])) {
                    echo $cat_modify->form('begin');
                }
            }

            // Liste des références
            echo p(ucfirst(thesaurus('can sort by clicking headers')));
            // Filtres
            $cols = ['cat_code', 'cat_abbreviation', 'cat_name', 'cat_onicer', 'cat_creator', 'cat_color'];
            filter_box($cols, 'category_table');
            echo "<table class='table' id='category_table'><thead>";
                // Création du header
                if ($_SESSION['user']->is_staff()) { $cols[] = 'modify'; }
                table_headers($cols, 'category_table');
            echo "</thead><tbody>";
                if (isset($action)) { if (in_array($action, ['addcategory', 'modifycategory'])) {
                // Form for new or modification category
                    echo "<tr>";
                    echo "<td>" . $cat_modify->input("code", false, false) . "</td>";
                    echo "<td>" . $cat_modify->input("abbreviation", false, false) . "</td>";
                    echo "<td>" . $cat_modify->input("name", false, false) . "</td>";
                    echo "<td>" . $cat_modify->input_checkbox("onicer", false, false) . "</td>";
                    echo "<td>" . User::find_by_id($cat_modify->owner('prop'))->codename() . "</td>";
                    echo "<td>" . $cat_modify->input("color", false, false) . "</td>";
                    if ($action == 'addcategory') { $val_action = 'categoryadded'; } else { $val_action = 'categorymodified'; }
                    echo "<input type='hidden' name='typeaction' value='" . $val_action . "'>";
                    if ($action == 'modifycategory') {
                        echo "<input type='hidden' name='object[id]' value='" . $cat_modify->id() . "'>";
                    }
                    echo "</tr>";
                }}
                // Intégration des catégories
                $categories = Category::find_all();
                foreach ($categories as $category) {
                    if ($category->id() != $idmodify) {
                        echo "<tr>";
                        echo $category->code('table');
                        echo $category->abbreviation('table');
                        echo $category->name('table');
                        echo $category->onicer('table');
                        echo $category->owner('table');
                        echo $category->color('table');
                        if ($_SESSION['user']->is_staff()) { echo $category->modify('table'); }
                        echo "</tr>";
                    }
                }
            echo "</tbody></table>";

            if (isset($action)) { if (in_array($action, ['addcategory', 'modifycategory'])) {
                echo $cat_modify->form('end');
            }}


        } ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>