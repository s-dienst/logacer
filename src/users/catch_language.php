<?php
// Vérification langage
if (!defined('LANGUAGE')) {
    $language = get_user_language();

    if ($language === null || !in_array($language, ALL_LANGUAGES) || (defined('SUPPORTED_LANGUAGES') && !in_array($language, SUPPORTED_LANGUAGES))) {
        // Cas où il n'y a pas de language défini, ou dans le cas où il n'est plus supporté : on va chercher le language browser et afficher le choix de langue
        // URL demandée initialement
        $requested_url = $_SERVER['REQUEST_URI'] ?? '/';

        $trad_language = get_browser_language();
        if (!$trad_language) {
            $trad_language = "en";
        }
        if (file_exists('lang/' . $trad_language . '.json')) {
            $translations = json_decode(
                file_get_contents('lang/' . $trad_language . '.json'),
                true
            );
        } else {
            $translations = json_decode(
                file_get_contents('../../lang/' . $trad_language . '.json'),
                true
            );
        }

        define('LANGUAGE', $trad_language);

        // Éviter une boucle vers la page de choix de langue
        if (!isset($_SESSION['choose_language'])) {

            $_SESSION['choose_language'] = true;
            $_SESSION['language_return_url'] = $requested_url;

            if (STATUS_INSTALLATION === 'validated') {
                if (ISOLATED_WEBSITE) {
                    $logacer = "";
                } else {
                    $logacer = "logacer/";
                }
                header('Location: ' . BASE_URL . $logacer . 'language');
                exit;
            } else {
                require_once(__DIR__ . "/../index/language.php");
            }
        }
    } else {
        if (file_exists('lang/' . $language . '.json')) {
            $translations = json_decode(
                file_get_contents('lang/' . $language . '.json'),
                true
            );
        } else {
            $translations = json_decode(
                file_get_contents('../../lang/' . $language . '.json'),
                true
            );
        }
        define('LANGUAGE', $language);
    }

    define('TRANSLATIONS', $translations);
}
?>