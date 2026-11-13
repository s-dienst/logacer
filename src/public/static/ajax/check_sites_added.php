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
301 Validation violée pour le l'owner ET le code du site
401 Validation violée pour le code MAIS owner OK
601 Validation correcte pour tout, résolu
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
    case 'owner':
        $user = User::find_by_sql("SELECT * FROM user WHERE username = :username", ['username'=>$value]);
        if (!$user) {
            $response = 301;
        } else {
            // Préparer le JSON
            $json_file = file_get_contents("data_adding_site" . $_SESSION['user']->id() . ".json");
            $data = json_decode($json_file, true);
            $site = Site::find_by_owner_code($user[0]->id(), $data['objects'][$row]['code']);
            if ($site) {
                $response = 401;
            } else {
                $response = 601;    
            }
        }
        break;
    case 'code':
        if (strlen($value) > 32) {
            $response = 200;
        } else {
            // Préparer le JSON
            $json_file = file_get_contents("data_adding_site" . $_SESSION['user']->id() . ".json");
            $data = json_decode($json_file, true);
            if ($data['objects'][$row]['owner'] === 0) {
                $response = 301;
            } else {
                $site = Site::find_by_owner_code($data['objects'][$row]['owner'], $value);
                if ($site) {
                    $response = 401;
                } else {
                    $response = 601;    
                    foreach ($data['objects'] as $key => $subarray) {
                        if ($key != $row && $subarray['owner'] === $data['objects'][$row]['owner'] && $subarray['code'] === $data['objects'][$row]['code']) {
                            $response = 401;
                        }
                    }
                }
            }
        }
        break;
    case 'name':
        if (strlen($value) > 255) {
            $response = 200;
        } elseif (Site::find_by_name($value)) {
            $response = 200;
        }
        break;
    case 'region':
        if (strlen($value) > 16) {
            $response = 200;
        } elseif (!Region::find_by_code($value)) {
            $response = 200;
        }
        break;
    case 'public':
    case 'unpublished':
    case 'biblio_review':
        if (strlen($value) > 0) {
            if (!in_array(strtolower($value), ['oui', 'non'])) {
                $response = 100;
            }
        }
        break;
    case 'coord_lat':
    case 'coord_long':
        if (is_numeric($value) && floatval($value) == $value) {
            if ($attribute === 'coord_lat') {
                if (floatval($value) > 90 || floatval($value) < -90) {
                    $response = 200;
                }
            } else {
                if (floatval($value) > 180 || floatval($value) < -180) {
                    $response = 200;
                }
            }
        } else {
            $response = 200;
        }
        break;
    default:
        $response = 0;
}

// Retourner la réponse en JSON
header("Content-Type: application/json");
echo json_encode($response);
?>
