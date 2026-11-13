<?php

/* Description de l'objet
** Fonctions statiques :
    /

** Fonctions supplémentaires :
    password(), is_activated() --> pour login

** Variables supplémentaires :
    /
*/
class User extends DatabaseObject {

    static protected $table_name = "user";
    static protected $db_columns = ['id', 'username', 'password', 'mail', 'firstname', 'lastname',
        'is_staff', 'is_activated', 'is_contributor', 'is_beginner', 'language', 'date_creation', 'date_modification', 'number_attempts', 'activation_key'];
    static protected $links = ['project', 'site', 'facies', 'typology', 'fabric'];
    static protected $max_chars = ['username'=>64, 'password'=>64, 'mail'=>64, 'firstname'=>64, 'lastname'=>64, 'language'=>3];
    static protected $required = ['username', 'password', 'mail'];
    static protected $uniques = ['username', 'mail'];
    // ATTENTION : si modifications de $bool avec des données non modifiables par l'user, les ajouter dans la liste de la fonction set_booleans()
    static protected $bool = ['is_staff', 'is_activated', 'is_contributor', 'is_beginner'];

    static public function authentification ($username="", $password="") {
        $errors = [];
        $errors = add_error($errors, check_blank($username, "a username"));
        $errors = add_error($errors, check_blank($password, "a password"));
        if (count($errors) === 0) {
            $user = static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE username = :username", ['username'=>$username]);
            if (!$user) {
                $user = static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE mail = :username", ['username'=>$username]);
                if (!$user) { $errors[] = ucfirst(thesaurus('no_user')); }
            }
            if ($user) {
                if (count($errors) === 0) {
                    $user = array_shift($user);
                    if (strlen($user->activation_key()) > 0) {
                        if (!$user->check_activation_key($password)) {
                            $errors[] = ucfirst(thesaurus('no_valid_password'));
                            $blocked = $user->failed_connexion_attempt();
                            if ($blocked) {
                                $errors[] = $blocked;
                            }
                            $user->save();
                        }
                    } elseif (!password_verify($password, $user->password())) {
                        $errors[] = ucfirst(thesaurus('no_valid_password'));
                        $blocked = $user->failed_connexion_attempt();
                        if ($blocked) {
                            $errors[] = $blocked;
                        }
                        $user->save();
                    }
                }
                elseif (!$user->is_activated()) { $errors[] = ucfirst(thesaurus('not_activated')); }
            }
        }
        if (count($errors) === 0) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['user'] = $user;
            return false;
        } else {
            return $errors;
        }
    }

    static public function validation_user ($action, $iduser) {
        $user = User::find_by_id($iduser);
        $username = $user->codename();
        // Add validation key
        $user->generate_activation_key();
        $usermail = $user->mail();
        if ($action === "validate_user") {
            $request = static::$connexion->prepare("UPDATE user SET is_activated = 1 WHERE id = :id LIMIT 1");
            if ($user->language() === "fr") {
                $subject = "Votre compte " . WEBSITE_NAME . " a été validé !";
                $message = "
                    Bonjour $username,
                    
                    Nous avons le plaisir de vous informer que votre compte " . WEBSITE_NAME . " a été validé avec succès.

                    Vous pouvez maintenant vous connecter sur " . BASE_URL . "login et enregistrer vos inventaires.
                    
                    IMPORTANT : avant toute connexion avec votre mot de passe, veuillez entrer la clé d'activation suivante à la place du mot de passe : " . $user->activation_key() . ". Veuillez copier-coller tous les caractères, y-compris les tirets.

                    Si cette activation fait suite à une perte de mot de passe, une fois reconnecté, vous pourrez changer votre mot de passe dans Mon compte. Attention : votre clé d'activation n'est valable qu'une seule et unique fois.

                    Si vous avez des questions ou que vous souhaitez contribuer de façon plus approfondie à " . WEBSITE_NAME . ", vous pouvez nous contacter à " . WEBMASTER_MAIL . ".
                    
                    Merci pour votre confiance,

                    Simon Dienst
                    ";
            } elseif ($user->language() === "it") {
                $subject = "Il tuo account " . WEBSITE_NAME . " è stato approvato!";
                $message = "
                    Buongiorno $username,
                    
                    Siamo lieti di informarti che il tuo account " . WEBSITE_NAME . " è stato approvato con successo.

                    Ora puoi accedere a " . BASE_URL . "login e registrare i tuoi inventari.
                    
                    IMPORTANTE: prima di effettuare l'accesso con la tua password, inserisci la seguente chiave di attivazione al posto della password: " . $user->activation_key() . ". Copia e incolla tutti i caratteri, compresi i trattini.

                    Se questa attivazione è dovuta alla perdita della password, una volta effettuato l'accesso potrai modificare la password nella sezione Il mio account. Attenzione: la chiave di attivazione può essere utilizzata una sola volta.

                    Se hai domande o desideri contribuire in modo più approfondito a " . WEBSITE_NAME . ", puoi contattarci all'indirizzo " . WEBMASTER_MAIL . ".
                    
                    Grazie per la fiducia,

                    Simon Dienst
                    ";
            } elseif ($user->language() === "de") {
                $subject = "Ihr " . WEBSITE_NAME . "-Konto wurde genehmigt!";
                $message = "
                    Guten Tag $username,
                    
                    wir freuen uns, Ihnen mitteilen zu können, dass Ihr " . WEBSITE_NAME . "-Konto erfolgreich genehmigt wurde.

                    Sie können sich jetzt unter " . BASE_URL . "login anmelden und Ihre Inventare erfassen.
                    
                    WICHTIG: Bevor Sie sich mit Ihrem Passwort anmelden, geben Sie bitte den folgenden Aktivierungsschlüssel anstelle Ihres Passworts ein: " . $user->activation_key() . ". Bitte kopieren Sie alle Zeichen, einschließlich der Bindestriche.

                    Falls diese Aktivierung aufgrund eines vergessenen Passworts erforderlich ist, können Sie Ihr Passwort nach der Anmeldung unter Mein Konto ändern. Bitte beachten Sie: Ihr Aktivierungsschlüssel kann nur einmal verwendet werden.

                    Wenn Sie Fragen haben oder " . WEBSITE_NAME . " stärker unterstützen möchten, können Sie uns unter " . WEBMASTER_MAIL . " kontaktieren.
                    
                    Vielen Dank für Ihr Vertrauen,

                    Simon Dienst
                    ";
            } elseif ($user->language() === "es") {
                $subject = "¡Tu cuenta de " . WEBSITE_NAME . " ha sido aprobada!";
                $message = "
                    Hola $username,
                    
                    Nos complace informarte de que tu cuenta de " . WEBSITE_NAME . " ha sido aprobada correctamente.

                    Ahora puedes iniciar sesión en " . BASE_URL . "login y registrar tus inventarios.
                    
                    IMPORTANTE: antes de iniciar sesión con tu contraseña, introduce la siguiente clave de activación en lugar de la contraseña: " . $user->activation_key() . ". Copia y pega todos los caracteres, incluidos los guiones.

                    Si esta activación se debe a que has perdido tu contraseña, una vez que hayas iniciado sesión podrás cambiarla desde Mi cuenta. Atención: tu clave de activación solo puede utilizarse una única vez.

                    Si tienes alguna pregunta o deseas contribuir de forma más activa a " . WEBSITE_NAME . ", puedes ponerte en contacto con nosotros en " . WEBMASTER_MAIL . ".
                    
                    Gracias por tu confianza,

                    Simon Dienst
                    ";
            } else {
                $subject = "Your " . WEBSITE_NAME . " account has been approved!";
                $message = "
                    Hello $username,
                    
                    We are pleased to inform you that your " . WEBSITE_NAME . " account has been successfully approved.

                    You can now log in at " . BASE_URL . "login and register your inventories.
                    
                    IMPORTANT: before logging in with your password, please enter the following activation key instead of your password: " . $user->activation_key() . ". Please copy and paste all characters, including the hyphens.

                    If this activation is the result of a lost password, once you have logged in, you will be able to change your password under My Account. Please note that your activation key can only be used once.

                    If you have any questions or would like to contribute further to " . WEBSITE_NAME . ", you can contact us at " . WEBMASTER_MAIL . ".
                    
                    Thank you for your trust,

                    Simon Dienst
                    ";
            }
        } elseif ($action === "delete_user") {
            $countings = Counting::linked('counting', 'user', $iduser, true);
            foreach ($countings as $counting) {
                DatabaseObject::delink('counting', 'user', $counting->id(), $iduser);
            }
            $request = static::$connexion->prepare("DELETE FROM user WHERE id = :id LIMIT 1");
            if ($user->language() === "FR") {
                $subject = "Validation du compte " . WEBSITE_NAME . " refusée";
                $message = "
                    Bonjour $username,
                    
                    Nous avons le regret de vous informer que votre compte " . WEBSITE_NAME . " n'a pas été validé, probablement car il ne semblait pas authentique.

                    Si vous souhaitez contester cette décision, je vous invite à me contacter par retour de mail.
                    
                    Cordialement,

                    Simon Dienst
                    ";
            } elseif ($user->language() === "it") {
                $subject = "Convalida dell'account " . WEBSITE_NAME . " rifiutata";
                $message = "
                    Buongiorno $username,
                    
                    Ci dispiace informarti che il tuo account " . WEBSITE_NAME . " non è stato approvato, probabilmente perché non sembrava autentico.

                    Se desideri contestare questa decisione, ti invitiamo a contattarci rispondendo a questa email.
                    
                    Cordiali saluti,

                    Simon Dienst
                    ";
            } elseif ($user->language() === "de") {
                $subject = WEBSITE_NAME . " Kontobestätigung abgelehnt";
                $message = "
                    Guten Tag $username,
                    
                    leider müssen wir Ihnen mitteilen, dass Ihr " . WEBSITE_NAME . "-Konto nicht genehmigt wurde, wahrscheinlich weil es nicht authentisch zu sein schien.

                    Wenn Sie diese Entscheidung anfechten möchten, kontaktieren Sie uns bitte, indem Sie auf diese E-Mail antworten.
                    
                    Mit freundlichen Grüßen,

                    Simon Dienst
                    ";
            } elseif ($user->language() === "es") {
                $subject = "Validación de la " . WEBSITE_NAME . " cuenta rechazada";
                $message = "
                    Hola $username,
                    
                    Lamentamos informarte de que tu cuenta de " . WEBSITE_NAME . " no ha sido aprobada, probablemente porque no parecía auténtica.

                    Si deseas impugnar esta decisión, puedes ponerte en contacto con nosotros respondiendo a este correo electrónico.
                    
                    Atentamente,

                    Simon Dienst
                    ";
            } else {
                $subject = WEBSITE_NAME . " account validation refused";
                $message = "
                    Hello $username,
                    
                    We regret to inform you that your " . WEBSITE_NAME . " account has not been approved, probably because it did not appear to be authentic.

                    If you wish to contest this decision, please contact me by replying to this email.
                    
                    Kind regards,

                    Simon Dienst
                    ";
            }
        }
        $request->bindParam(':id', $iduser);
        $request->execute();
        send_email($usermail, $subject, $message);
    }

    protected string $username;
    protected string $password;
    protected string $mail;
    protected string $firstname;
    protected string $lastname;
    protected int $is_staff;
    protected int $is_activated;
    protected int $is_contributor;
    protected int $is_beginner;
    protected string $language;
    protected int $number_attempts;
    protected string $activation_key;

    public function __construct($args=[]) {
        $this->id = $args['id'] ?? 0;
        $this->username = $args['username'] ?? '';
        if (isset($args['password'])) { if (isset($args['id'])) { $this->password = $args['password']; } else { $this->password = password_hash($args['password'], PASSWORD_DEFAULT); }} else { $this->password = ""; }
        $this->mail = $args['mail'] ?? '';
        $this->firstname = $args['firstname'] ?? '';
        $this->lastname = $args['lastname'] ?? '';
        $this->activation_key = $args['activation_key'] ?? '';
        if (isset($args['is_staff'])) { if ($args['is_staff']) { $this->is_staff = 1; } else { $this->is_staff = 0; } } else { $this->is_staff = 0; }
        if (isset($args['is_activated'])) { if ($args['is_activated']) { $this->is_activated = 1; } else { $this->is_activated = 0; } } else { $this->is_activated = 0; }
        if (isset($args['is_contributor'])) { if ($args['is_contributor']) { $this->is_contributor = 1; } else { $this->is_contributor = 0; } } else { $this->is_contributor = 0; }
        if (isset($args['is_beginner'])) { if ($args['is_beginner']) { $this->is_beginner = 1; } else { $this->is_beginner = 0; } } else { $this->is_beginner = 0; }
        if (isset($args['number_attempts'])) { $this->number_attempts = intval($args['number_attempts']); } else { $this->number_attempts = 0; }
        if (isset($args['language'])) { $this->language = $args['language']; } elseif (!empty($_COOKIE['logacer_language'])) { $this->language = $_COOKIE['logacer_language']; } else { $this->language = 'en'; }
        $this->date_creation = $args['date_creation'] ?? '';
        $this->date_modification = $args['date_modification'] ?? '';
    }

    protected function create() {
        if (count(User::find_all()) === 0) {
            $this->is_staff = 1;
            $this->is_activated = 1;
            $this->is_contributor = 1;
        }
        parent::create();
        // Create countings
        $countings = Counting::find_all();
        foreach ($countings as $counting) {
            $request = static::$connexion->query("INSERT INTO link_counting_user (counting, user) VALUES(" . $counting->id() . ", " . $this->id . ")");
            if (!$request) {
                return false;
            }
        }
        return true;
    }

    public function url($arg=false) {
        
    }

    public function username() {
        return $this->username;
    }

    public function mail() {
        return $this->mail;
    }
    
    public function firstname() {
        return $this->firstname;
    }
    
    public function lastname() {
        return $this->lastname;
    }

    public function password() {
        return $this->password;
    }

    public function activation_key() {
        return $this->activation_key;
    }

    public function failed_connexion_attempt() {
        if ($this->number_attempts < 2) {
            $this->number_attempts = $this->number_attempts + 1;
            return false;
        } else {
            $this->number_attempts = 0;
            $this->is_activated = 0;
            return ucfirst(thesaurus('account_blocked'));
        }
    }

    public function generate_activation_key() {
        $length = 25;
        $bytes = random_bytes($length);
        $hex   = strtoupper(bin2hex($bytes));
        // Format style XXXXX-XXXXX-XXXXX...
        $this->activation_key = substr(chunk_split(substr($hex, 0, $length), 5, '-'), 0, -1);
        $this->save();
    }

    public function check_activation_key($password) {
        if ($this->activation_key) {
            if ($password === $this->activation_key) {
                return true;
                $this->activation_key = "";
                $this->save();
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    public function matching_password($password, $confirmation) {
        if ($password !== $confirmation) {
            array_push($this->errors, ucfirst(thesaurus('no_matching_password')));
        }
    }

    public function set_booleans($object) {
        foreach (['is_staff', 'is_activated', 'is_contributor'] as $boolean) {
            $object[$boolean] = $this->$boolean;
        }
        return $object;
    }

    public function is_activated() {
        return $this->is_activated;
    }

    public function is_beginner() {
        return $this->is_beginner;
    }

    public function is_contributor() {
        return $this->is_contributor;
    }

    public function is_staff() {
        return $this->is_staff;
    }

    public function language() {
        return $this->language;
    }

    public function set_language($language) {
        if (in_array($language, SUPPORTED_LANGUAGES)) {
            $this->language = $language;
        }
    }

    public function codename() {
        if ($this->firstname && $this->lastname) {
            return secure($this->firstname . " " . $this->lastname);
        } else {
            return secure($this->username);
        }
    }

    public function change_rights($action) {
        // Staff à 0 ou 1
        if (in_array($action, ['no_staff', 'no_staff_contributor'])) {
            $this->is_staff = 0;
        } elseif (in_array($action, ['is_staff', 'is_staff_contributor'])) {
            $this->is_staff = 1;
        }
        // Contributor à 0 ou 1
        if (in_array($action, ['no_staff_contributor', 'no_contributor'])) {
            $this->is_contributor = 0;
        } elseif (in_array($action, ['is_staff_contributor', 'is_contributor'])) {
            $this->is_contributor = 1;
        }
    }
}

?>