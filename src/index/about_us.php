<?php
    $title = ucfirst(thesaurus('about us'));

    if (isset($_POST['name'])) {
        // Créer l'email
        if (isset($_POST['email'])) { $email = $_POST['email']; } else { $email = "non mentionné"; }
        if (isset($_POST['message'])) { $message = $_POST['message']; } else { $message = "message vide"; }

        if (PROJECT) {
            $owner = User::find_by_id(PROJECT->owner('prop'));
            $mail_lang = $owner->language();
            $email_owner = $owner->mail();
        } else {
            $email_owner = WEBMASTER_MAIL;
            $search_admin = User::find_all();
            $mail_lang = 'en';
            foreach ($search_admin as $sa) {
                if ($sa->is_staff()) {
                    $mail_lang = $sa->language();
                    break;
                }
            }
        }

        switch($mail_lang) {
            case 'fr':
                $subject = "Message de contact (" . PROJECT_NAME . ")";
                $message = "
                    Un usager de " . PROJECT_NAME . " vous a contacté :

                    Utilisateur : " . $_POST['name'] . "

                    Email : " . $email . "

                    Site web : " . BASE_URL . "

                    Message :

                    '" . $message . "'

                    ";
                break;

            case 'de':
                $subject = "Kontaktanfrage (" . PROJECT_NAME . ")";
                $message = "
                    Ein Benutzer von " . PROJECT_NAME . " hat Sie kontaktiert :

                    Benutzer : " . $_POST['name'] . "

                    E-Mail : " . $email . "

                    Website : " . BASE_URL . "

                    Nachricht :

                    '" . $message . "'

                    ";
                break;

            case 'es':
                $subject = "Mensaje de contacto (" . PROJECT_NAME . ")";
                $message = "
                    Un usuario de " . PROJECT_NAME . " se ha puesto en contacto con usted :

                    Usuario : " . $_POST['name'] . "

                    Correo electrónico : " . $email . "

                    Sitio web : " . BASE_URL . "

                    Mensaje :

                    '" . $message . "'

                    ";
                break;

            case 'it':
                $subject = "Messaggio di contatto (" . PROJECT_NAME . ")";
                $message = "
                    Un utente di " . PROJECT_NAME . " vi ha contattato :

                    Utente : " . $_POST['name'] . "

                    Email : " . $email . "

                    Sito web : " . BASE_URL . "

                    Messaggio :

                    '" . $message . "'

                    ";
                break;

            default: // anglais
                $subject = "Contact message (" . PROJECT_NAME . ")";
                $message = "
                    A user of " . PROJECT_NAME . " has contacted you :

                    User : " . $_POST['name'] . "

                    Email : " . $email . "

                    Website : " . BASE_URL . "

                    Message :

                    '" . $message . "'

                    ";
        }


            $mail_headers = "From: " . $email_owner . "\r\n";
            $mail_headers .= "Reply-To: " . $email_owner . "\r\n";
            $mail_headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
            mail($email_owner, $subject, $message, $mail_headers);

            // Sauvegarde temporaire des demandes de contact
            $log_file = __DIR__ . '/contact_requests.txt';

            $log_entry = "\n"
                . "========================================\n"
                . "Date : " . date('Y-m-d H:i:s') . "\n"
                . "Utilisateur : " . ($_POST['name'] ?? 'non mentionné') . "\n"
                . "Email : " . $email . "\n"
                . "Environnement : " . BASE_URL . "\n"
                . "Message :\n"
                . $message . "\n"
                . "========================================\n";

            file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);

        // Confirmation
        $confirmation_sent = thesaurus('contact_confirmation');
    }
?>

<!DOCTYPE html>
<html>
    <?php require_once("../layout/headers.php"); ?>
    <body>
        <?php require_once("../layout/navbars.php"); ?>
        <div class="maindiv container" style="max-width:1000px">
            <?php
            // Confirmation contact
            if (isset($confirmation_sent)) {
                echo "<div class='alert alert-success'>" . $confirmation_sent . "</div>";
            }
            ?>
            <br>
            <?php long_translation("about_us"); ?>
            
            <section id="contact" class="mb-5">
            <h2><?php echo ucfirst(thesaurus("contacts")); ?></h2>
            <br>
            <p><?php if (PROJECT) { echo ucfirst(thesaurus("contact_descr_project")); } else { echo ucfirst(thesaurus("contact_descr_logacer")); } ?></p>
            <h4><?php echo ucfirst(thesaurus("contact_form")); ?></h4>
            <form action="<?php echo create_url(['about_us']); ?>" method="post">
                <div class="form-floating mb-3">
                    <input class="form-control" type="text" id="name" name="name" placeholder="<?php echo ucfirst(thesaurus('firstname') . ' ' . thesaurus('and') . ' ' . thesaurus('lastname')); ?>" required style="width:100%; max-width:512px;">
                    <label for="name"><?php echo ucfirst(thesaurus("insert name")); ?></label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" type="text" id="email" name="email" placeholder="<?php echo ucfirst(thesaurus('mail')); ?>" style="width:100%; max-width:512px;">
                    <label for="email"><?php echo ucfirst(thesaurus("insert email contact")); ?></label>
                </div>
                <div class="form-floating mb-3">
                    <textarea class="form-control" cols="80" rows="10" id="message" name="message" style="width:100%; max-width:512px; height:256px"></textarea>
                    <label for="message"><?php echo ucfirst(thesaurus("your message")); ?></label>
                </div>
                <input class="btn btn-primary" type="submit" value="Envoyer">
            </form>
            </section>
        </div>
        <?php require_once("../layout/footer.php"); ?>
    </body>
</html>