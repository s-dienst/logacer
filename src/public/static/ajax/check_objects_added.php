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
300 Validation violée pour le site, mais également le contexte et le numéro d'inventaire
400 Validation violée pour le contexte et le numéro d'inventaire
500 Validation violée pour le numéro d'inventaire
600 Validation correcte pour tout, résolu
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

$response = 0;

switch($attribute) {
    case 'site':
        if (strlen($value) > 255 || strlen($value) === 0) {
            $response = 300;
        } else {
            $site = Site::find_by_name($value);
            if ($site) {
                if ($site->contributor_rights()) {
                    // Préparer le JSON
                    $json_file = file_get_contents("data_adding_inventory" . $_SESSION['user']->id() . ".json");
                    $data = json_decode($json_file, true);
                    // Checker le contexte
                    $context = Context::find_by_site_code($site->id(), $data['objects'][$row]['context']);
                    if ($context) {
                        // Checker le numéro d'inventaire
                        if (ObjectTable::find_by_context_number($context->id(), $data['objects'][$row]['number'])) {
                            $response = 500;
                        } else {
                            $response = 600;
                            foreach ($data['objects'] as $key => $subarray) {
                                if ($key != $row && $subarray['site'] === $value && $subarray['context'] === $data['objects'][$row]['context'] && $subarray['number'] === $data['objects'][$row]['number']) {
                                    $response = 500;
                                }
                            }
                        }
                    } else { $response = 400; }
                } else {
                    $response = 300;
                }
            } else { $response = 300; }
        }
        break;
    case 'context':
        if (strlen($value) > 32 || strlen($value) === 0) { $response = 400; }
        else {
            // Préparer le JSON
            $json_file = file_get_contents("data_adding_inventory" . $_SESSION['user']->id() . ".json");
            $data = json_decode($json_file, true);
            $site = Site::find_by_name($data['objects'][$row]['site']);
            if (!$site) {
                $response = 300;
            } elseif (!$site->contributor_rights()) {
                $response = 300;
            } else {
                $context = Context::find_by_site_code($site->id(), $value);
                if ($context) {
                    // Vérifier inventaire
                    if (ObjectTable::find_by_context_number($context->id(), $data['objects'][$row]['number'])) {
                        $response = 500;
                    } else {
                        $response = 600;
                        foreach ($data['objects'] as $key => $subarray) {
                            if ($key != $row && $subarray['site'] === $site->name() && $subarray['context'] === $context->code() && $subarray['number'] === $value) {
                                $response = 500;
                            }
                        }
                    }
                } else { $response = 400; }
            }
        }
        break;
    case 'number':
        if (strlen($value) > 128 || strlen($value) === 0) { $response = 500; } else {
            // Préparer le JSON
            $json_file = file_get_contents("data_adding_inventory" . $_SESSION['user']->id() . ".json");
            $data = json_decode($json_file, true);
            $site = Site::find_by_name($data['objects'][$row]['site']);
            if (!$site) {
                $response = 300;
            } elseif (!$site->contributor_rights()) {
                $response = 300;
            } else {
                $context = Context::find_by_site_code($site->id(), $data['objects'][$row]['context']);
                if ($context) {
                    // Vérifier inventaire
                    if (ObjectTable::find_by_context_number($context->id(), $value)) {
                        $response = 500;
                    } else {
                        $response = 600;
                        foreach ($data['objects'] as $key => $subarray) {
                            if ($key != $row && $subarray['site'] === $site->name() && $subarray['context'] === $context->code() && $subarray['number'] === $value) {
                                $response = 500;
                            }
                        }
                    }
                } else { $response = 400; }
            }
        }
        break;
    case 'category_abbr':
        if (strlen($value) > 16 || strlen($value) === 0) { $response = 200; } elseif (Category::find_by_abbr($value)) { $response = 0; } else { $response = 100; }
        break;
    case 'function_name':
        if (strlen($value) > 128 || strlen($value) === 0) { $response = 200; } elseif (FunctionTable::find_by_name($value)) { $response = 0; } else { $response = 100; }
        break;
    case 'type_name':
        if (strlen($value) > 128 || strlen($value) === 0) { $response = 200; } elseif (Type::find_by_name($value)) { $response = 0; } else { $response = 100; }
        break;
    case 'type_var':
        if (strlen($value) > 8) { $response = 200; } else { $response = 0; }
        break;
    case 'fabric_code':
        if (strlen($value) > 64) { $response = 200; } elseif (Fabric::find_by_code($value)) { $response = 0; } else { $response = 100; }
        break;
    case 'n_rim':
    case 'n_bottom':
    case 'n_handle':
    case 'n_wall':
    case 'n_mni':
    case 'n_sherd':
        if (is_numeric($value) && intval($value) == $value) {
            if (intval($value) >= 0) {
                $response = 0;
            } else {
                $response = 200;
            }
        } else {
            $response = 200;
        }
        break;
    case 'type_doubt':
    case 'diameter':
        if (strlen($value) > 16) { $response = 200; } else { $response = 0; }
        break;
    case 'stamp':
    case 'comment':
        if (strlen($value) > 255) { $response = 200; } else { $response = 0; }
        break;
    case 'category_litt':
    case 'function_litt':
    case 'type_litt':
    case 'fabric_litt':
        if (strlen($value) > 128) { $response = 200; } else { $response = 0; }
        break;
    default:
        $response = 0;
}

// Retourner la réponse en JSON
header("Content-Type: application/json");
echo json_encode($response);
?>
