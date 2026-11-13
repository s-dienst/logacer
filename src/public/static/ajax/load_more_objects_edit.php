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
                                        // Check si biblio_review
                                        if ($params['biblio_rev']) {
                                            $cat_litt = $object->input('category_litt', 'object_', false, false, true);
                                            $fun_litt = $object->input('function_litt', 'object_', false, false, true);
                                            $typ_litt = $object->input('type_litt', 'object_', false, false, true);
                                            $fab_litt = $object->input('fabric_litt', 'object_', false, false, true);
                                        } else {
                                            $cat_litt = ""; $fun_litt = ""; $typ_litt = ""; $fab_litt = "";
                                        }
                                        // Ajoute codes catégorie et fonction
                                        if ($object->category_link()) {
                                            $cat_sort = $object->category_link()->code();
                                        } else {
                                            $cat_sort = $object->category('simple');
                                        }
                                        if ($object->function_link()) {
                                            $fun_sort = $object->function_link()->code();
                                        } else {
                                            $fun_sort = $object->function('simple');
                                        }
                                        $html .= '<tr>';
                                        // Number
                                        $html .= "<td sort-text='" . $object->number('simple') . "'>" . $object->input('number', 'object_', false, false, true) . "</td>";
                                        // Category
                                        echo "<td sort-text='" . $cat_sort . " " . $object->category('simple') . "'>" .
                                            $object->input('category_abbr', 'object_', false, false, true)
                                            . $cat_litt
                                            . "</td>";
                                        // Function
                                        echo "<td sort-text='" . $fun_sort . " " . $object->function('simple') . "'>" .
                                            $object->input('function_name', 'object_', false, false, true)
                                            . $fun_litt
                                            . "</td>";
                                        // Type
                                        echo "<td sort-text='" . $object->type('simple') . "'>" .
                                            $object->input('type_name', 'object_', false, false, true) .
                                            $object->input('type_var', 'object_', false, false, true) .
                                            $object->input('type_doubt', 'object_', false, false, true)
                                            . $typ_litt
                                            . "</td>";
                                        // Fabric
                                        echo "<td sort-text='" . $object->fabric('simple') . "'>" .
                                            $object->input('fabric_code', 'object_', false, false, true)
                                            . $fab_litt
                                            . "</td>";
                                        // Countings
                                        if (in_array('n_rim', $cols)) {
                                            $html .= "<td sort-text='" . $object->n_rim() . "'>" . $object->input_number('n_rim', 'object_', 0, "", "", false, false, true) . "</td>";
                                            $html .= "<td sort-text='" . $object->n_bottom() . "'>" . $object->input_number('n_bottom', 'object_', 0, "", "", false, false, true) . "</td>";
                                            $html .= "<td sort-text='" . $object->n_handle() . "'>" . $object->input_number('n_handle', 'object_', 0, "", "", false, false, true) . "</td>";
                                            $html .= "<td sort-text='" . $object->n_wall() . "'>" . $object->input_number('n_wall', 'object_', 0, "", "", false, false, true) . "</td>";
                                        } if (in_array('n_mni', $cols)) {
                                            $html .= "<td sort-text='" . $object->n_mni() . "'>" . $object->input_number('n_mni', 'object_', 0, "", "", false, false, true) . "</td>";
                                        } if (in_array('n_sherd', $cols)) {
                                            $html .= "<td sort-text='" . $object->n_sherd() . "'>" . $object->input_number('n_sherd', 'object_', 0, "", "", false, false, true) . "</td>";
                                        } if (in_array('eve', $cols)) {
                                            $html .= "<td sort-text='" . $object->eve() . "'>" . $object->input_number('eve', 'object_', 0, "", "", false, false, true) . "</td>";
                                        } if (in_array('drawing_or_cat', $cols)) {
                                            $html .= "<td sort-text='" . $object->drawing_or_cat() . "'>" . $object->input_number('drawing_or_cat', 'object_', 0, "", "", false, false, true) . "</td>";
                                        }
                                        // Diameter
                                        $html .= "<td sort-text='" . $object->diameter() . "'>" . $object->input('diameter', 'object_', false, false, true) . "</td>";
                                        // Stamps
                                        $html .= "<td sort-text='" . $object->stamp() . "'>" . $object->input('stamp', 'object_', false, false, true) . "</td>";
                                        // Comment
                                        $html .= "<td sort-text='" . $object->comment() . "'>" . $object->input('comment', 'object_', false, false, true) . "</td>";
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
