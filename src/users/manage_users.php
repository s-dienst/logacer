
<?php
    if (!isset($_SESSION['user'])) {
        $error_message = 'no_connexion';
    } elseif (!$_SESSION['user']->is_staff()) {
        $error_message = 'not_staff';
    } else {
        $title = ucfirst(thesaurus('manage users'));
    }

    if ($_POST AND !isset($error_message)) {
        $action = $_POST['typeaction'];
        /* Gère la validation ou la suppression de nouveaux utilisateurs */
        if ($action === "validate_user" || $action === "delete_user") {
            User::validation_user($action, $_POST['iduser']);
        } elseif (in_array($action, ["no_staff", "no_staff_contributor", "is_staff", "no_contributor", "is_staff_contributor", "is_contributor"])) {
            $user_to_change = User::find_by_id($_POST['iduser']);
            $user_to_change->change_rights($action);
            $user_to_change->save();
        }
    }

    if (!isset($error_message)) {
        /* Si administrateur : liste des personnes à valider */
        $all_users = User::find_all();
        $users_to_activate = [];
        $users_other = [];
        foreach ($all_users as $user) {
            if ($user->is_activated()) {
                $users_other[] = $user;
            } else {
                $users_to_activate[] = $user;
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
            <!-- Error message if not valid -->
            <?php if (isset($error_message)) { display_fatal_error($error_message); } else {
                
                echo h(1, $title);
                echo '<br>';

            // Activate user form; check if user can do that before adding code
                // Display title
                echo h(3, ucfirst(thesaurus('validate users')));
                // If no user to add, there is a message indicating it
                if (count($users_to_activate) == 0) {
                    echo "<li class='no-info'>" . ucfirst(thesaurus('no_user_to_validate')) . "</li>";
                } else {
                    // Display a form for each user, with an iduser input with the id of the user and two typeaction buttons: a validate_user to activate and delete_user to delete it
                    echo "<ul>";
                    foreach ($users_to_activate as $user) {
                        $html = "<form action='" . create_url(['manage_users']) . "' method='post'>";
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

            // Other users
                // Display title
                echo "<br><br>";
                echo h(3, ucfirst(thesaurus('validated users')));
                echo "<table class='table' id='user_table'><thead>";
                foreach (['username', 'names', 'mail', 'role', 'language', 'actions'] as $header) {
                    echo "<th>" . ucfirst(thesaurus($header)) . "</th>";
                }
                echo "</thead><tbody>";
                foreach ($users_other as $user) {
                    echo "<form action='" . "' method='post'><tr>";
                    // Normal rows
                    echo "<td>" . $user->username() . "</td>";
                    if ($user->firstname() && $user->lastname()) {
                        echo "<td>" . $user->lastname() . " " . $user->firstname() . "</td>";
                    } else {
                        echo "<td>-</td>";
                    }
                    echo "<td>" . $user->mail() . "</td>";
                    if ($user->is_staff()) {
                        $role = "administrator";
                    } elseif ($user->is_contributor()) {
                        $role = "contributor";
                    } else {
                        $role = "simple user";
                    }
                    echo "<td>" . ucfirst(thesaurus($role)) . "</td>";
                    echo "<td>" . $user->language() . "</td>";
                    // Actions
                    echo "<td><div class='btn-group' role='group'>";
                    if ($user->is_staff()) {
                        echo "<button class='btn btn-outline-danger btn-sm' name='typeaction' type='submit' value='no_staff'>" . ucfirst(thesaurus("change to contributor")) . "</button>";
                        echo "<button class='btn btn-outline-danger btn-sm' name='typeaction' type='submit' value='no_staff_contributor'>" . ucfirst(thesaurus("change to simple user")) . "</button>";
                    } elseif ($user->is_contributor()) {
                        echo "<button class='btn btn-outline-success btn-sm' name='typeaction' type='submit' value='is_staff'>" . ucfirst(thesaurus("change to staff")) . "</button>";
                        echo "<button class='btn btn-outline-danger btn-sm' name='typeaction' type='submit' value='no_contributor'>" . ucfirst(thesaurus("change to simple user")) . "</button>";
                    } else {
                        echo "<button class='btn btn-outline-success btn-sm' name='typeaction' type='submit' value='is_staff_contributor'>" . ucfirst(thesaurus("change to staff")) . "</button>";
                        echo "<button class='btn btn-outline-success btn-sm' name='typeaction' type='submit' value='is_contributor'>" . ucfirst(thesaurus("change to contributor")) . "</button>";
                    }
                        echo "<button class='btn btn-danger btn-sm' name='typeaction' type='submit' value='delete_user'>" . ucfirst(thesaurus("delete")) . "</button>";
                    echo "</td></div>";
                    // Hidden
                    echo "<input type='hidden' name='iduser' value='" . $user->id() . "'>";
                    echo "</tr></form>";
                }
                echo "</tbody></table>";

             /* endif for error message */ } ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>