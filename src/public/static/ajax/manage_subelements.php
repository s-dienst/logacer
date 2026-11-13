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

// Décodage du JSON
$params = json_decode(file_get_contents("php://input"), true);
$id_project = intval($params["project_id"]);
if (!defined('PROJECT')) {
    define('PROJECT', Project::find_by_id($id_project));
}

// Initialisation de la première variable
$action = $params['action'] ?? false;

// Initiation des variables d'idObject et typeObject si présents
if (isset($params["typeObject"])) {
    // Création du nom de la classe
    $class_parts = explode("_", $params["typeObject"]);
    $class_name = "";
    foreach ($class_parts as $c) {
        $class_name .= ucfirst($c);
    }
} else {
    error_log("ERROR");
}
if (isset($params["idObject"])) {
    // Récupération de l'id
    $object_id = $params["idObject"];
}

switch ($action) {
    // Changement d'un lien entre horizon et type
    case 'selection_contributors':
        // Récupération de l'objet
        $object = $class_name::find_by_id($object_id);
        $users = [];
        if ($object && $object->owner_rights()) {
            // Si présent, sélection de tous les utilisateurs non contributeurs
            $users_objects = $object->no_contributor();
            if (!empty($users_objects)) {
                foreach ($users_objects as $user) {
                    // Intégration dans une array indexée
                    $users[] = ['id' => $user->id(), 'name' => $user->codename()];
                }
            }
        }
        $json_response = ['users' => $users];
        break;
    case 'add_contrib':
        // Création du lien avec le contributeur indiqué
        $object = $class_name::find_by_id($object_id);
        $contributor = false;
        if ($object && $object->owner_rights()) {
            /* Vérifie si utilisateur existe */
            $new_contrib = User::find_by_id($params['idContributor']);
            if (in_array($new_contrib, $object->no_contributor())) {
                $success = DatabaseObject::$connexion->query("INSERT INTO link_" . $params["typeObject"] . "_contributor (" . $params["typeObject"] . ", contributor) VALUES (" . $object->id() . ", " . $new_contrib->id() . ")");
                if ($success) {
                    $contributor = ['id' => $new_contrib->id(), 'name' => $new_contrib->codename()];
                }
            } else {
                $success = false;
            }
        } else {
            $success = false;
        }
        $json_response = [
            'success'     => $success,
            'contributor' => $contributor
        ];
        break;
    case 'delete_contrib':
        // Suppression des liens avec le contributeur indiqué
        $object = $class_name::find_by_id($object_id);
        if ($object && $object->owner_rights()) {
            $success = DatabaseObject::delink($params["typeObject"], 'contributor', $object_id, $params['idContributor']);
        } else {
            $success = false;
        }
        $json_response = ['success' => $success];
        break;
    default:
        http_response_code(400);
        exit("Incorrect input");
}

// Réponse JSON
header('Content-Type: application/json');
echo json_encode($json_response);
exit;
?>