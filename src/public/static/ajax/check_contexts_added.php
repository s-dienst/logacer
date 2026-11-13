<?php
require_once("../../../variables.php");
require_once("../../../layout/functions2.php");
require_once("../../../layout/functions_database.php");
require_once("../../../layout/functions_html.php");
require_once("../../../layout/errors.php");
require_once("../../../layout/thesaurus.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérification que la requête est bien AJAX
if (
    !isset($_SERVER['HTTP_X_REQUESTED_WITH']) ||
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest'
) {
    http_response_code(403);
    exit('Accès interdit');
}

require("../../../users/catch_language.php");

/* Rappel codes :
0   Tout est OK
100 Pas standard, mais pas bloquant
200 Validation violée pour la cellule
302 Validation violée pour le site, mais également le code du contexte
303 Validation violée pour le faciès, mais également pour l'horizon (non bloquant)
402 Validation correcte pour le site mais pas pour le contexte
403 Validation correcte pour le faciès mais pas pour l'horizon (non bloquant)
Validation violée pour le numéro d'inventaire
602 Validation correcte pour site et contexte, résolu
603 Validation correcte pour faciès et horizon, résolu
*/


// Récupérer l'entrée utilisateur envoyée par JS
$inputData = json_decode(file_get_contents("php://input"), true);
$value = trim($inputData["inputValue"]); // Normalisation
$attribute = strtolower(trim($inputData["column"]));
$row = intval($inputData["row"]);
$id_project = intval($input_data["project_id"]);
if (!defined('PROJECT')) {
    define('PROJECT', Project::find_by_id($id_project));
}

// ATTENTION : CALCUL DE LA CONSTANTE PROJECT IMPORTANTE

$response = 0;

switch($attribute) {
    case 'site':
        if (strlen($value) > 255 || strlen($value) === 0) {
            $response = 302;
        } else {
            $site = Site::find_by_name($value);
            if ($site) {
                if ($site->contributor_rights()) {
                    // Préparer le JSON
                    $json_file = file_get_contents("data_adding_context" . $_SESSION['user']->id() . ".json"); // Assurez-vous que le fichier s'appelle 'data.json'
                    $data = json_decode($json_file, true);
                    $response = 602;
                    foreach ($data['objects'] as $key => $subarray) {
                        if ($key != $row && $subarray['site'] === $value && $subarray['context_code'] === $data['objects'][$row]['context_code']) {
                            $response = 402;
                        }
                    }
                } else {
                    $response = 302;
                }
            } else { $response = 302; }
        }
        break;
    case 'facies':
        if (PROJECT->setting_horizon()) {
            if (strlen($value) > 0) {
                $facies = Facies::find_by_code($value);
                if ($facies) {
                    if ($facies->public() || $facies->contributor_rights()) {
                        // Préparer le JSON
                        $json_file = file_get_contents("data_adding_context" . $_SESSION['user']->id() . ".json"); // Assurez-vous que le fichier s'appelle 'data.json'
                        $data = json_decode($json_file, true);
                        // Check si horizon aussi OK
                        $horizon = Horizon::find_by_facies_code($facies->id(), $data['objects'][$row]['horizon_code']);
                        if ($horizon) {
                            $response = 603;
                        } else {
                            $response = 403;
                        }
                    } else {
                        $response = 303;
                    }
                } else {
                    $response = 303;
                }
            } else {
                // Préparer le JSON
                $json_file = file_get_contents("data_adding_context" . $_SESSION['user']->id() . ".json"); // Assurez-vous que le fichier s'appelle 'data.json'
                $data = json_decode($json_file, true);
                if ($data['objects'][$row]['horizon']) {
                    $response = 303;
                }
            }
        }
        break;
    case 'horizon_code':
        if (PROJECT->setting_horizon()) {
            // Préparer le JSON
            $json_file = file_get_contents("data_adding_context" . $_SESSION['user']->id() . ".json"); // Assurez-vous que le fichier s'appelle 'data.json'
            $data = json_decode($json_file, true);
            if (strlen($data['objects'][$row]['facies'] > 0)) {
                $facies = Facies::find_by_code($data['objects'][$row]['facies']);
                if ($facies) {
                    if ($facies->public() || $facies->contributor_rights()) {
                        // Check si horizon aussi OK
                        $horizon = Horizon::find_by_facies_code($facies->id(), $value);
                        if ($horizon) {
                            $response = 603;
                        } else {
                            $response = 403;
                        }
                    } else {
                        $response = 303;
                    }
                } else {
                    $response = 303;
                }
            } elseif (strlen($value) > 0) {
                $response = 303;
            }
        }
        break;
    case 'horizon_strength':
        if (PROJECT->setting_horizon()) {
            if ($value) {
                if (!in_array($value, [1, 2, 3])) {
                    $response = 100;
                }
            }
        }
        break;
    case 'phase_code':
        if (strlen($value) > 32) { $response = 200; }
        break;
    case 'phase_name':
        if (strlen($value) > 255) { $response = 200; }
        break;
    case 'context_code':
        if (strlen($value) > 32 || strlen($value) === 0) {
            $response = 302;
        } else {
            // Préparer le JSON
            $json_file = file_get_contents("data_adding_context" . $_SESSION['user']->id() . ".json"); // Assurez-vous que le fichier s'appelle 'data.json'
            $data = json_decode($json_file, true);
            $site = Site::find_by_name($data['objects'][$row]['site']);
            if ($site) {
                if ($site->contributor_rights()) {
                    // Préparer le JSON
                    $json_file = file_get_contents("data_adding_context" . $_SESSION['user']->id() . ".json"); // Assurez-vous que le fichier s'appelle 'data.json'
                    $data = json_decode($json_file, true);
                    $response = 602;
                    foreach ($data['objects'] as $key => $subarray) {
                        if ($key != $row && $subarray['site'] === $value && $subarray['context_code'] === $value) {
                            $response = 402;
                        }
                    }
                } else {
                    $response = 302;
                }
            } else { $response = 302; }
        }
        break;
    case 'context_name':
        if (strlen($value) > 255) { $response = 200; }
        break;
    default:
        $response = 0;
}

// Retourner la réponse en JSON
header("Content-Type: application/json");
echo json_encode($response);
?>
