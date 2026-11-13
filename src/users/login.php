<?php
    $title = ucfirst(thesaurus('login'));
    $errors = false;

    if (isset($_SESSION['user'])) {
        $error_message = 'already_logged';
    }

    elseif (isset($_POST['username'])) {
        $errors = User::authentification($_POST['username'], $_POST['password']);
        if (!$errors) {
            header('Location: ' . create_url_proj(["homepage"]));
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
            <?php h(2, ucfirst(thesaurus('login')));
            if (isset($error_message)) { display_fatal_error($error_message); } else {
                if ($errors) { 
                    echo "<div class='alert alert-danger'>" . thesaurus('base_error') . "<ul>";
                    foreach ($errors as $error) { echo "<li>" . $error . "</li>"; }
                    echo "</ul></div>";
                };
            ?>
            
            <form action="<?php echo create_url_proj(['login']); ?>" method="post">
                <div class="form-floating mb-3">
                    <input autofocus class="form-control" type="text" id="username" name="username" placeholder="<?php ucfirst(thesaurus('username') . ' ' . thesaurus('or') . ' ' . thesaurus('mail')); ?>">
                    <label for="username"><?php echo ucfirst(thesaurus('username')); ?></label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" type="password" id="password" name="password" placeholder="<?php echo ucfirst(thesaurus('password')); ?>">
                    <label for="password"><?php echo ucfirst(thesaurus('password')); ?></label>
                </div>
                <input class="btn btn-primary" type="submit" value="Login">
            </form>

            <div style="text-align:center">
                <?php echo "<p>" . thesaurus('no account yet') . " <a href='" . create_url_proj(['register']) . "'>" . thesaurus('register here') . "</a></p><h5><b>" . thesaurus('need validation 2') . "</b></h5>"; ?>
            </div>
            <?php } ?>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>