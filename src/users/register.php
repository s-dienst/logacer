<?php
    $title = ucfirst(thesaurus('register'));
    if (isset($_POST['object'])) {
        $user = new User($_POST['object']);
        $user->matching_password($_POST['object']['password'], $_POST['confirmation']);
        // On vérifie si il y a un projet, et si oui, s'il y a des erreurs
        $project_errors = [];
        if (isset($_POST['project'])) {
            $project_errors = add_error($project_errors, check_forbidden($_POST['project']['code'], 'code', ['logacer']));
            $project_errors = add_error($project_errors, check_characters($_POST['project']['code'], 'code', '/\A[a-zA-Z0-9_-]+\z/'));
            $project_errors = add_error($project_errors, check_max_char($_POST['project']['code'], 16, "the code"));
            $project_errors = add_error($project_errors, check_max_char($_POST['project']['name'], 128, "the name"));
            $project_errors = add_error($project_errors, check_blank($_POST['project']['code'], "a code"));
            $project_errors = add_error($project_errors, check_blank($_POST['project']['name'], "a name"));
        }
        if (count($project_errors) === 0) {
            $success = $user->save();
            if ($success) {
                // Création message de succès
                $_SESSION['flash_message_success'] = ucfirst(thesaurus("success_creation_user")) . "<br>";
                if (count(User::find_all()) > 1) {
                    // Email pour validation
                    $search_admin = User::find_all();
                    $mail_lang = 'en';
                    foreach ($search_admin as $sa) {
                        if ($sa->is_staff()) {
                            $mail_lang = $sa->language();
                            break;
                        }
                    }
                    switch($mail_lang) {
                        case 'fr':
                            $subject = "Compte à valider (" . WEBSITE_NAME . ")";
                            $message = "
                                Compte à valider (" . WEBSITE_NAME . ") :

                                Utilisateur : " . $user->codename() . "

                                Email : " . $user->mail() . "

                                Accéder au site web : " . create_url_proj(['manage_users']) . "
                                ";
                            break;
                        case 'de':
                            $subject = "Konto muss freigeschaltet werden (" . WEBSITE_NAME . ")";
                            $message = "
                                Konto muss freigeschaltet werden (" . WEBSITE_NAME . ") :

                                Benutzer : " . $user->codename() . "

                                E-Mail : " . $user->mail() . "

                                Zur Website gehen : " . create_url_proj(['manage_users']) . "
                                ";
                            break;
                        case 'es':
                            $subject = "Cuenta pendiente de aprobación (" . WEBSITE_NAME . ")";
                            $message = "
                                Cuenta pendiente de aprobación (" . WEBSITE_NAME . ") :

                                Usuario : " . $user->codename() . "

                                Correo electrónico : " . $user->mail() . "

                                Acceder al sitio web : " . create_url_proj(['manage_users']) . "
                                ";
                            break;
                        case 'it':
                            $subject = "Account in attesa di approvazione (" . WEBSITE_NAME . ")";
                            $message = "
                                Account in attesa di approvazione (" . WEBSITE_NAME . ") :

                                Utente : " . $user->codename() . "

                                Email : " . $user->mail() . "

                                Accedi al sito web : " . create_url_proj(['manage_users']) . "
                                ";
                            break;
                        default:
                            $subject = "Account pending approval (" . WEBSITE_NAME . ")";
                            $message = "
                                Account pending approval (" . WEBSITE_NAME . ") :

                                User : " . $user->codename() . "

                                Email : " . $user->mail() . "

                                Access the website : " . create_url_proj(['manage_users']) . "
                                ";
                    }
                    $mail_headers = "From: " . WEBMASTER_MAIL . "\r\n";
                    $mail_headers .= "Reply-To: " . WEBMASTER_MAIL . "\r\n";
                    $mail_headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
                    mail(WEBMASTER_MAIL, $subject, $message, $mail_headers);
                    $_SESSION['flash_message_success'] .= ucfirst(thesaurus("need validation"));
                } else {
                    $_SESSION['flash_message_success'] .= ucfirst(thesaurus("already validated"));
                    if (isset($_POST['project'])) {
                        $project = new Project([
                            'code'=>$_POST['project']['code'],
                            'name'=>$_POST['project']['name'],
                            'owner'=>User::find_all()[0]->id(),
                            'langs'=>implode(';', SUPPORTED_LANGUAGES)
                        ]);
                        $success = $project->save();
                    }
                }

                // Redirection
                header('Location: ' . BASE_URL);
                exit();
            }
        }
    } else {
        $user = new User();
    }
?>

<!DOCTYPE html>
<html>
    <?php require_once("../layout/headers.php"); ?>
    <body>
        <?php require_once("../layout/navbars.php"); ?>
        <div class="maindiv container">
        <?php
            echo h(2, ucfirst(thesaurus('register')));
            if (isset($user)) { $user->display_errors(); }
            // Erreurs projet
            if (isset($project_errors) && count($project_errors) > 0) {
                $message =  "<div class='alert alert-danger'>"
                    . thesaurus('base_error') . "<ul>";
                foreach ($project_errors as $error) { $message .= "<li>" . $error . "</li>"; }
                $message .= "</ul></div>";
                echo $message;
            }
            ?>

            <form action="<?php echo create_url(['register']) ?>" method="post">
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
                        <td><input class="form-control" autofocus type="text" name="object[username]" required maxlength="64" placeholder="<?php echo ucfirst(thesaurus('username')); ?>" value="<?php if (isset($_POST['object']['username'])) { echo $_POST['object']['username']; } ?>"></td>
                    </tr>
                    <tr>
                        <td style="text-align:right;"><?php echo ucfirst(thesaurus('mail')); ?></td>
                        <td><input class="form-control" type="mail" name="object[mail]" required maxlength="64" placeholder="<?php echo ucfirst(thesaurus('mail')); ?>" value="<?php if (isset($_POST['object']['mail'])) { echo $_POST['object']['mail']; } ?>"></td>
                    </tr>
                    <tr>
                        <td style="text-align:right;"><?php echo ucfirst(thesaurus('password')); ?></td>
                        <td><input class="form-control" type="password" name="object[password]" required maxlength="64" placeholder="<?php echo ucfirst(thesaurus('password')); ?>" value="<?php if (isset($_POST['object']['password'])) { echo $_POST['object']['password']; } ?>"></td>
                    </tr>
                    <tr>
                        <td style="text-align:right;"><?php echo ucfirst(thesaurus('password confirmation')); ?></td>
                        <td><input class="form-control" type="password" name="confirmation" required maxlength="64" placeholder="<?php echo ucfirst(thesaurus('password confirmation')); ?>" value="<?php if (isset($_POST['confirmation'])) { echo $_POST['confirmation']; } ?>"></td>
                    </tr>
                    <tr>
                        <td style="text-align:right;"><?php echo ucfirst(thesaurus('firstname') . ' (' . thesaurus('optionnal') . ')'); ?></td>
                        <td><input class="form-control" type="text" name="object[firstname]" maxlength="64" placeholder="<?php echo ucfirst(thesaurus('firstname') . ' (' . thesaurus('optionnal') . ')'); ?>" value="<?php if (isset($_POST['object']['firstname'])) { echo $_POST['object']['firstname']; } ?>"></td>
                    </tr>
                    <tr>
                        <td style="text-align:right;"><?php echo ucfirst(thesaurus('lastname') . ' (' . thesaurus('optionnal') . ')'); ?></td>
                        <td><input class="form-control" type="text" name="object[lastname]" maxlength="64" placeholder="<?php echo ucfirst(thesaurus('lastname') . ' (' . thesaurus('optionnal') . ')'); ?>" value="<?php if (isset($_POST['object']['lastname'])) { echo $_POST['object']['lastname']; } ?>"></td>
                    </tr>
                    <?php if (count(User::find_all()) === 0 && ISOLATED_WEBSITE) { ?>
                    <tr></tr>
                    <tr>
                        <td style="text-align:right;"><?php echo ucfirst(thesaurus('project_code')); ?></td>
                        <td><input class="form-control" type="text" name="project[code]" maxlength="16" placeholder="<?php echo ucfirst(thesaurus('code')); ?>" value="<?php if (isset($_POST['project']['code'])) { echo $_POST['project']['code']; } ?>"></td>
                    </tr>
                    <tr>
                        <td style="text-align:right;"><?php echo ucfirst(thesaurus('project_name')); ?></td>
                        <td><input class="form-control" type="text" name="project[name]" maxlength="128" placeholder="<?php echo ucfirst(thesaurus('name')); ?>" value="<?php if (isset($_POST['project']['name'])) { echo $_POST['project']['name']; } ?>"></td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <div style="text-align:center">
                <p><input class="btn btn-primary" type="submit" value="<?php echo ucfirst(thesaurus('register')); ?>"></p></div>
                <input type="hidden" name="typeaction" value="register">
            </form>

            <div style="text-align:center">
                <?php if (count(User::find_all()) > 0) { echo "<p>" . thesaurus('already account') . " <a href='" . create_url(['login']) . "'>" . thesaurus('connect here') . "</a></p>";
                 echo "<h5><b>" . thesaurus('need validation') . "</b></h5>"; } ?>
            </div>
        
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>