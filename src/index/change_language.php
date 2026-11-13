<?php
    if (!isset($_POST['language'])) {
        header('Location: ' . create_url([]));
        exit();
    }

    $language = $_POST['language'];

    // La langue doit obligatoirement faire partie des langues supportées
    if (!in_array($language, SUPPORTED_LANGUAGES, true)) {
        header('Location: ' . create_url([]));
        exit();
    }

    if (isset($_SESSION['user'])) {

        // Utilisateur connecté : sauvegarde dans son profil
        $user = User::find_by_id($_SESSION['user']->id());

        if (in_array($language, SUPPORTED_LANGUAGES, true)) {
            $user->set_language($language);
            if ($user->save()) {
                $_SESSION['user']->set_language($language);
            }
        }
    } else {

        // Visiteur : sauvegarde dans un cookie pendant un an
        setcookie(
            'logacer_language',
            $language,
            [
                'expires' => time() + 31536000,
                'path' => '/',
                'httponly' => true,
                'samesite' => 'Lax'
            ]
        );
    }

    // Retour à la page actuelle
    $return_url = $_POST['return_url'] ?? create_url(['homepage']);

    if (
        !str_starts_with($return_url, '/')
        || str_starts_with($return_url, '//')
    ) {
        $return_url = create_url(['homepage']);
    }

    header('Location: ' . $return_url);
    exit();
?>
