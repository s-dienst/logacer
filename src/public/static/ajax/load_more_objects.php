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

// Initialisation des variables communes
$mode       = $params['mode'] ?? '';
$offset     = (int) ($params['offset'] ?? 0);
$limit      = (int) ($params['limit'] ?? ROWS_PER_PAGE);
$ordering   = $params['ordering'] ?? [];
$loaded     = (int) ($params['loaded'] ?? 0);
$cols       = $params['cols'] ?? [];

// Récupération des objets
switch ($mode) {
    case 'find_by_parent':
        $parent_id      = (int) ($params['parent_id'] ?? 0);
        if (
            !Context::find_by_id($parent_id) ||
            (!Context::find_by_id($parent_id)->public() &&
            !Context::find_by_id($parent_id)->contributor_rights())
        ) {
            http_response_code(403);
            exit('Accès interdit');
        }
        $objects        = ObjectTable::find_by_parent($parent_id, $ordering, $limit, $offset);
        break;
    case 'find_public':
        $conditions     = $params['conditions'] ?? [];
        $left_join      = $params['left_join'] ?? false;
        $binds          = $params['binds'] ?? [];
        $conditions_ns  = $params['conditions_ns'] ?? false;
        $objects        = ObjectTable::find_public($conditions, $left_join, $binds, $ordering, $conditions_ns, $limit, $offset);
        break;
    default:
        http_response_code(400);
        exit("Incorrect input");
}

// Check du offset actuel
if (count($ordering) > 0) {
    $offset += $limit;
} else {
    $offset = end($objects)->id();
}

// Mise à jour du nombre d'objets chargés
$loaded += count($objects);

// Création du code
$html = '';
foreach ($objects as $object) {
    $html .= '<tr>';
    foreach ($cols as $col) {
        $html .= $object->$col('table');
    }
    $html .= '</tr>';
}

// Réponse JSON
header('Content-Type: application/json');
echo json_encode([
    'html'  => $html,
    'offset'=> $offset,
    'loaded'=> $loaded
]);
exit;
?>
