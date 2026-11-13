<?php

function get_browser_language() {
    $accept_language = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '';

    foreach (explode(',', $accept_language) as $language) {
        $language = strtolower(trim(explode(';', $language)[0]));

        // "fr-BE" -> "fr"
        $language = substr($language, 0, 2);

        if (in_array($language, ALL_LANGUAGES, true) && (!defined('SUPPORTED_LANGUAGES') || in_array($language, SUPPORTED_LANGUAGES, true))) {
            return $language;
        }
    }

    return null;
}

function get_user_language() {
    // Utilisateur authentifié
    if (isset($_SESSION['user'])) {
        if (!defined('SUPPORTED_LANGUAGES')) {
            return null;
        }
        $language = $_SESSION['user']->language();

        if (in_array($language, SUPPORTED_LANGUAGES, true)) {
            return $language;
        }
    }

    // Utilisateur non authentifié : cookie
    if (!empty($_COOKIE['logacer_language'])) {
        $language = $_COOKIE['logacer_language'];

        if (in_array($language, ALL_LANGUAGES, true) && (!defined('SUPPORTED_LANGUAGES') || in_array($language, SUPPORTED_LANGUAGES, true))) {
            return $language;
        }
    }

    return null;
}

function log_missing_translation(string $key, string $group): void
{
    // Vérifie que la langue est connue
    if (!defined('LANGUAGE')) {
        return;
    }

    $language = LANGUAGE;

    // errors.json se trouve dans /public/lang/
    $file = __DIR__ . '/../public/lang/errors.json';

    // Crée le fichier s'il n'existe pas
    if (!file_exists($file)) {
        $errors = [];
    } else {
        $content = file_get_contents($file);
        $errors = json_decode($content, true);

        // Sécurité si le JSON est invalide
        if (!is_array($errors)) {
            $errors = [];
        }
    }

    // Ajoute l'erreur
    $errors[] = [
        'language' => $language,
        'group' => $group,
        'key' => $key,
        'date' => date('Y-m-d H:i:s')
    ];

    // Sauvegarde
    file_put_contents(
        $file,
        json_encode(
            $errors,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        ),
        LOCK_EX
    );
}

function thesaurus(string $name) {
    // Récupérer le WEBSITE_NAME
    if (defined('WEBSITE_NAME')) {
        $website_name = WEBSITE_NAME;
    } else {
        $website_name = 'LOGACer';
    }
    // Check si bien dans traductions
    if (defined('TRANSLATIONS')) {
        $key = strtolower($name);
        if (isset(TRANSLATIONS["thesaurus"][$key])) {
            $translation = TRANSLATIONS["thesaurus"][$key];
            // Remplacer WEBSITE_NAME
            return str_replace(["WEBSITE_NAME", "PROJECT_NAME"], [$website_name, PROJECT_NAME], $translation);
        }
    }
    // Sinon, on va indiquer une erreur dans errors.json
    log_missing_translation($name, "thesaurus");
    // On envoie
    return str_replace(["WEBSITE_NAME", "PROJECT_NAME"], [$website_name, PROJECT_NAME], $name);
}

function long_translation(string $file) {
    // Vérifie que la langue est connue
    if (!defined('LANGUAGE')) {
        return false;
    }
    $language = LANGUAGE;
    $key = strtolower($file);
    if (PROJECT) {
        $replace_text = AppText::find_lang($key, $language, PROJECT->id());
        if ($replace_text) {
            $replace_text->display();
        } else {
            if (file_exists("../lang_php/" . $key . "_" . $language . "_project.php")) {
                return require("../lang_php/" . $key . "_" . $language . "_project.php");
            } elseif (file_exists("../lang_php/" . $key . "_en_project.php")) {
                return require("../lang_php/" . $key . "_en_project.php");
            }
            echo "<p><h1>Missing text. Please contact the admin.</h1></p>";
            // Sinon, on va indiquer une erreur dans errors.json
            log_missing_translation($file, "long_translation");
            return false;
        }
    } else {
        $replace_text = AppText::find_lang($key, $language, 0);
        if ($replace_text) {
            $replace_text->display();
        } else {
            if (file_exists("../lang_php/" . $key . "_" . $language . "_logacer.php")) {
                return require("../lang_php/" . $key . "_" . $language . "_logacer.php");
            } elseif (file_exists("../lang_php/" . $key . "_en_logacer.php")) {
                return require("../lang_php/" . $key . "_en_logacer.php");
            }
            echo "<p><h1>Missing text. Please contact the admin.</h1></p>";
            // Sinon, on va indiquer une erreur dans errors.json
            log_missing_translation($file, "long_translation");
            return false;
        }
    }

}

function tutorial(string $abbreviation) {
    // Check si bien dans traductions
    if (defined('TRANSLATIONS')) {
        if (isset(TRANSLATIONS["tutorial"][$abbreviation])) {
            $translation = TRANSLATIONS["tutorial"][$abbreviation];
            return str_replace(["WEBSITE_NAME", "PROJECT_NAME"], [WEBSITE_NAME, PROJECT_NAME], $translation);
        }
    }
    // Sinon, on va indiquer une erreur dans errors.json
    log_missing_translation($abbreviation, "tutorial");
    // Code à faire
    return str_replace(["WEBSITE_NAME", "PROJECT_NAME"], [WEBSITE_NAME, PROJECT_NAME], $abbreviation);
}

function list_val(string $list, $value=false, $default=false) {
    if (defined('TRANSLATIONS')) {
        if ($default) {
            if (isset(TRANSLATIONS["lists"][$list . "_default"])) {
                $data_list = TRANSLATIONS["lists"][$list . "_default"];
                if ($value === false) {
                    return $data_list;
                } elseif ($value) {
                    if (isset($data_list[intval($value)])) {
                        return $data_list[intval($value)];
                    } else {
                        return $data_list[0];
                    }
                } else {
                    return $data_list[0];
                }
            }
        } else {
            if (isset(TRANSLATIONS["lists"][$list])) {
                $data_list = TRANSLATIONS["lists"][$list];
                if ($value === false) {
                    return $data_list;
                } elseif ($value) {
                    if (isset($data_list[intval($value)])) {
                        return $data_list[intval($value)];
                    } else {
                        return $data_list[0];
                    }
                } else {
                    return $data_list[0];
                }
            }
        }
    }
    // Sinon, on va indiquer une erreur dans errors.json
    log_missing_translation($list, "lists");
    return $list;

}

function filter_labels($col, $place) {
    if ($place === "label") {
        $key = "name_" . $col;
    } elseif ($place === "ph") {
        $key = "ph_" . $col;
    } elseif ($place === "descr") {
        $key = "descr_" . $col;
    } else {
        return "ERROR";
    }
    // Check si bien dans traductions
    if (defined('TRANSLATIONS')) {
        if (isset(TRANSLATIONS["table"][$key])) {
            $translation = TRANSLATIONS["table"][$key];
            return str_replace(["WEBSITE_NAME", "PROJECT_NAME"], [WEBSITE_NAME, PROJECT_NAME], $translation);
        }
    }
    // Sinon, on va indiquer une erreur dans errors.json
    log_missing_translation($key, "table");
    // Code à faire
    return str_replace(["WEBSITE_NAME", "PROJECT_NAME"], [WEBSITE_NAME, PROJECT_NAME], $col);
}

// Transformation d'un timestamp de type YYYY-MM-DD hh:mm:ss en fonction de la location
function date_located($timestamp) {
    // Tant qu'unilingue
    $location = LANGUAGE;
    if ($location = 'fr') {
        // Premier affichage
        $date = date("j F Y", strtotime($timestamp));
        // Remplace les "1" par "1er"
        $date = preg_replace('/^1\s/', '1er ', $date);
        // Mapping
        $map = [
            'January'   => 'janvier',
            'February'  => 'février',
            'March'     => 'mars',
            'April'     => 'avril',
            'May'       => 'mai',
            'June'      => 'juin',
            'July'      => 'juillet',
            'August'    => 'août',
            'September' => 'septembre',
            'October'   => 'octobre',
            'November'  => 'novembre',
            'December'  => 'décembre',
        ];
        $date = strtr($date, $map);
    } elseif ($location = 'en') {
        $date = date("j F Y", strtotime($timestamp));
    } elseif ($location = 'it') {
        $date = date("j F Y", strtotime($timestamp));
    }
    return $date;
}

function template($template_name) {
    // Tant qu'unilingue
    $location = 'FR';
    switch($location) {
        case 'FR':
            switch($template_name) {
                case 'csv_site' : return ['Horizon-site', 'Contexte', "Numéro d'inventaire", "Catégorie", "Fonction", "Type", "Pâte", "Bords", "Fonds", "Anses", "Parois", "NMI", "NR", "Diam.", "Estampilles", "Commentaire", "Dessin"]; break;
                case 'csv_phase' : return ['Contexte', "Numéro d'inventaire", "Catégorie", "Fonction", "Type", "Pâte", "Bords", "Fonds", "Anses", "Parois", "NMI", "NR", "Diam.", "Estampilles", "Commentaire", "Dessin"]; break;
                case 'csv_context' : return ["Numéro d'inventaire", "Catégorie", "Fonction", "Type", "Pâte", "Bords", "Fonds", "Anses", "Parois", "NMI", "Diam.", "NR", "Estampilles", "Commentaire", "Dessin"]; break;
                case 'csv_site_full' : return ['Horizon-site', 'Contexte', "Numéro d'inventaire", "Catégorie", "Catégorie (dans publication)", "Fonction", "Fonction (dans publication)", "Type", "Type (dans publication)", "Pâte", "Pâte (dans publication)", "Bords", "Fonds", "Anses", "Parois", "NMI", "NR", "Diam.", "Estampilles", "Commentaire", "Dessin"]; break;
                case 'csv_phase_full' : return ['Contexte', "Numéro d'inventaire", "Catégorie", "Catégorie (dans publication)", "Fonction", "Fonction (dans publication)", "Type", "Type (dans publication)", "Pâte", "Pâte (dans publication)", "Bords", "Fonds", "Anses", "Parois", "NMI", "NR", "Diam.", "Estampilles", "Commentaire", "Dessin"]; break;
                case 'csv_context_full' : return ["Numéro d'inventaire", "Catégorie", "Catégorie (dans publication)", "Fonction", "Fonction (dans publication)", "Type", "Type (dans publication)", "Pâte", "Pâte (dans publication)", "Bords", "Fonds", "Anses", "Parois", "NMI", "Diam.", "NR", "Estampilles", "Commentaire", "Dessin"]; break;
            }
            break;
    }
}

?>