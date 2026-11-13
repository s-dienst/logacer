<?php
    if (!isset($_SESSION['user'])) {
        $error_message = 'no_connexion';
    } else {
        $title = ucfirst(thesaurus('my personnal data'));
        $user = User::find_by_id($_SESSION['user']->id());
        if (isset($_POST['object'])) {
            $object = $_POST['object'];
            $object['id'] = $user->id();
            $object = $user->set_booleans($object);
            if ($object['password'] || $_POST['confirmation']) {
                $user->matching_password($_POST['object']['password'], $_POST['confirmation']);
                $object['password'] = password_hash($object['password'], PASSWORD_DEFAULT);
            } else {
                $object['password'] = $user->password();
            }
            $user = new User($object);

            $success = $user->save();
            if ($success) {
                Counting::manage($user);
                /* Ne veut pas fonctionner correctement ; pour le moment, déconnexion-reconnexion ; message de succès l'indiquant
                header('Location: ' . create_url(['homepage']));
                exit(); */
                $success_message = "<div class='alert alert-success'>" . thesaurus('success_modifications_user') . "</div>";
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
        <?php
            echo h(2, ucfirst(thesaurus('my personnal data')));
            if (isset($user)) { $user->display_errors(); }
            if (isset($success_message)) { echo $success_message; }
            ?>

            <form action="<?php echo create_url_proj(['myaccount']) ?>" method="post">
                <table class="table table-borderless align-middle">
                    <thead>
                        <tr>
                            <th width="30%"></th>
                            <th></th>
                            <th width="30%"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="text-align:right;"><?php echo ucfirst(thesaurus('username')); ?></td>
                        <td><input class="form-control" autofocus type="text" name="object[username]" required maxlength="64" placeholder="<?php echo ucfirst(thesaurus('username')); ?>" value="<?php echo $user->username(); ?>"></td>
                    </tr>
                    <tr>
                        <td style="text-align:right;"><?php echo ucfirst(thesaurus('mail')); ?></td>
                        <td><input class="form-control" type="mail" name="object[mail]" required maxlength="64" placeholder="<?php echo ucfirst(thesaurus('mail')); ?>" value="<?php echo $user->mail(); ?>"></td>
                    </tr>
                    <tr>
                        <td style="text-align:right;"><?php echo ucfirst(thesaurus('password')); ?></td>
                        <td><input class="form-control" type="password" name="object[password]" maxlength="64" placeholder="<?php echo ucfirst(thesaurus('password')); ?>"></td>
                    </tr>
                    <tr>
                        <td style="text-align:right;"><?php echo ucfirst(thesaurus('password confirmation')); ?></td>
                        <td><input class="form-control" type="password" name="confirmation" maxlength="64" placeholder="<?php echo ucfirst(thesaurus('password confirmation')); ?>"></td>
                    </tr>
                    <tr>
                        <td style="text-align:right;"><?php echo ucfirst(thesaurus('firstname') . ' (' . thesaurus('optionnal') . ')'); ?></td>
                        <td><input class="form-control" type="text" name="object[firstname]" maxlength="64" placeholder="<?php echo ucfirst(thesaurus('firstname') . ' (' . thesaurus('optionnal') . ')'); ?>" value="<?php echo $user->firstname(); ?>"></td>
                    </tr>
                    <tr>
                        <td style="text-align:right;"><?php echo ucfirst(thesaurus('lastname') . ' (' . thesaurus('optionnal') . ')'); ?></td>
                        <td><input class="form-control" type="text" name="object[lastname]" maxlength="64" placeholder="<?php echo ucfirst(thesaurus('lastname') . ' (' . thesaurus('optionnal') . ')'); ?>" value="<?php echo $user->lastname(); ?>"></td>
                    </tr>
                    </tbody>
                </table>

                <?php echo ($user->input_counting('user_counting'));
                    echo "<br>" . p(thesaurus('check user counting')) . "<br>";
                    echo h(3, ucfirst(thesaurus('options user')));
                    echo p($user->input_checkbox('is_beginner', 'user_is_beginner'));
                     ?>

                <div style="text-align:center">
                <p><input class="btn btn-primary" type="submit" value="<?php echo ucfirst(thesaurus('register modifications')); ?>"></p></div>
            </form>        
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>