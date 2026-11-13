<?php
    $error_message = false;

    if (!isset($_SESSION['user'])) {
        $error_message = 'no_connexion';
    } else {
        $title = ucfirst(thesaurus('list of the functions'));
        $idmodify = 0;
        if (isset($_POST) && $_SESSION['user']->is_staff()) {
            // Signifie qu'il ne s'agit pas d'une toute nouvelle fonction
            if (isset($_POST['object'])) {
                if (count($_POST['object']) === 1 && isset($_POST['object']['id'])) {
                    // Signifie que juste l'id est transmise (bouton modify cliqué)
                    $func_modify = FunctionTable::find_by_id($_POST['object']['id']);
                    if ($_POST['typeaction'] == 'delete') {
                        $func_modify->delete($func_modify->url());
                    }
                } else {
                    // Signifie qu'il y a un formulaire complet (bouton sauvegarde cliqué)
                    $func_modify = new FunctionTable($_POST['object']);
                    if (in_array($_POST['typeaction'], ['functionadded', 'functionmodified'])) {
                        $success = $func_modify->save();
                        if ($success) {
                            header('Location: ' . $func_modify->url());
                            exit();
                        }
                    }
                }
                if (isset($_POST['object']['id'])) { $idmodify = $_POST['object']['id']; }
            } else {
                // On a cliqué sur nouveau
                $func_modify = new FunctionTable();
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

            // Ajouter fonction
            if ($_SESSION['user']->is_staff()) {
                echo "<form action='" . create_url_proj(['functions']) . "' method='post'>";
                    echo "<input class='btn btn-outline-success' type='submit' value='" . ucfirst(thesaurus('new')) . "'>";
                    echo "<input type='hidden' name='typeaction' value='addfunction'>";
                echo "</form><br>";
            }

            // Titre
            echo h(2, ucfirst(thesaurus('list of the functions')));

            if (isset($func_modify)) {
                $func_modify->display_errors();
            }

            if ($_SESSION['user']->is_staff() && isset($_POST['typeaction'])) {
                $action = $_POST['typeaction'];
                if (in_array($action, ['addfunction', 'modifyfunction'])) {
                    echo $func_modify->form('begin');
                }
            }

            // Liste des références
            echo p(ucfirst(thesaurus('can sort by clicking headers')));
            // Filtres
            $cols = ['func_code', 'func_name', 'func_onicer', 'func_creator'];
            filter_box($cols, 'function_table');
            echo "<table class='table' id='function_table'><thead>";
                // Création du header
                if ($_SESSION['user']->is_staff()) { $cols[] = 'modify'; }
                table_headers($cols, 'function_table');
            echo "</thead><tbody>";
                if (isset($action)) { if (in_array($action, ['addfunction', 'modifyfunction'])) {
                // Form for new or modification function
                    echo "<tr>";
                    echo "<td>" . $func_modify->input("code", false, false) . "</td>";
                    echo "<td>" . $func_modify->input("name", false, false) . "</td>";
                    echo "<td>" . $func_modify->input_checkbox("onicer", false, false) . "</td>";
                    echo "<td>" . User::find_by_id($func_modify->owner('prop'))->codename() . "</td>";
                    if ($action == 'addfunction') { $val_action = 'functionadded'; } else { $val_action = 'functionmodified'; }
                    echo "<input type='hidden' name='typeaction' value='" . $val_action . "'>";
                    if ($action == 'modifyfunction') {
                        echo "<input type='hidden' name='object[id]' value='" . $func_modify->id() . "'>";
                    }
                    echo "</tr>";
                }}
                // Intégration des fonctions
                $functions = FunctionTable::find_all();
                foreach ($functions as $function) {
                    if ($function->id() != $idmodify) {
                        echo "<tr>";
                        echo $function->code('table');
                        echo $function->name('table');
                        echo $function->onicer('table');
                        echo $function->owner('table');
                        if ($_SESSION['user']->is_staff()) { echo $function->modify('table'); }
                        echo "</tr>";
                    }
                }
            echo "</tbody></table>";

            if (isset($action)) { if (in_array($action, ['addfunction', 'modifyfunction'])) {
                echo $func_modify->form('end');
            }}


        } ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>