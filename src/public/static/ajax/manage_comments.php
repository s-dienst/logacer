<?php
// TODO : gestion des exceptions à harmoniser avec display_errors()
// Code fourni par ChatGPT, à ses risques et périls (il est au courant qu'il a fait de la merde initialement, il promet de pas recommencer, mais c'est un mytho).

require_once("../../../variables.php");
require_once("../../../layout/functions2.php");
require_once("../../../layout/functions_database.php");
require_once("../../../layout/functions_html.php");
require_once("../../../layout/errors.php");
require_once("../../../layout/thesaurus.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json; charset=utf-8');

require("../../../users/catch_language.php");

// Fonctions utilisées
function comment_json_exit($response, $status = 200) {
    http_response_code($status);
    echo json_encode(
        $response,
        JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE
    );
    exit;
}

function html_display_error($comment) {
    ob_start();
    $comment->display_errors();
    return ob_get_clean();
}

// Initialisation réponse
$json_response = [
    'success' => false,
    'message' => '',
    'html' => '',
    'errors' => ''
];

// Vérification AJAX
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
    comment_json_exit(['success' => false, 'message' => 'Accès interdit.'], 403);
}

// Décodage JSON
$params = json_decode(file_get_contents("php://input"), true);
$id_project = intval($params["project_id"]);
if (!defined('PROJECT')) {
    define('PROJECT', Project::find_by_id($id_project));
}

if (!is_array($params)) {
    comment_json_exit(['success' => false, 'message' => 'Requête JSON invalide.'], 400);
}

// Vérification de la session
if (!isset($_SESSION['user']) || !$_SESSION['user']->id()) {
    comment_json_exit(['success' => false, 'message' => 'Vous devez être connecté.'], 401);
}
$user_id = $_SESSION['user']->id();

// Vérification du contexte et du jeton
$token = $params['token'] ?? '';

if (!is_string($token) || !preg_match('/^[a-f0-9]{64}$/', $token) || !isset($_SESSION['comment_contexts'][$token])) {
    comment_json_exit(['success' => false, 'message' => 'Contexte de commentaire invalide ou expiré.'], 403);
}

$context = $_SESSION['comment_contexts'][$token];

// Durée de validité : 2 heures
if (time() - intval($context['created']) > 7200 || intval($context['user']) !== $user_id) {
    unset($_SESSION['comment_contexts'][$token]);
    comment_json_exit(['success' => false, 'message' => 'Session de commentaires expirée.'], 403);
}

$comment_class = $context['class'];
$object_id = intval($context['id']);

// Récupération de l'élément
$element = $comment_class::find_by_id($object_id);

// --------------------------------------------------
// Traitement
// --------------------------------------------------

$action = $params['action'] ?? '';

try {
    switch ($action) {
       // CRÉATION
        case 'create':
            $privacy = filter_var($params['privacy'] ?? 0, FILTER_VALIDATE_INT);
            $html = $params['descr_html'] ?? '';
            $parent_id = intval($params['parent_id'] ?? 0);

            if (!is_string($html) || trim(strip_tags($html)) === '') {
                throw new Exception("Le commentaire ne peut pas être vide.");
            }

            // Vérification du parent éventuel
            if ($parent_id > 0) {
                $parent = Comment::find_by_id($parent_id);
                if ($parent->respond_to() || !$parent->is_visible() || $parent->parent_object() !== $element) {
                    $parent_id = 0;
                }
            }

            // Création du commentaire
            $comment = new Comment([
                'class' => $comment_class,
                'id_object' => $object_id,
                'privacy' => $privacy,
                'respond_to' => $parent_id,
                'descr_html' => $html,
                'creator' => $user_id
            ]);

            if (!$comment->save()) {
                $json_response['errors'] = html_display_error($comment);
            } else {
                $json_response['message'] = "Commentaire publié.";
            }
            break;

        // MODIFICATION
        case 'edit':
            $comment_id = intval($params['comment_id'] ?? 0);
            $html = $params['descr_html'] ?? '';
            if ($comment_id <= 0) {
                throw new Exception("Identifiant invalide.");
            }

            if (!is_string($html) || trim(strip_tags($html)) === '') {
                throw new Exception("Le commentaire ne peut pas être vide.");
            }

            $existing = Comment::find_by_id($comment_id);
            if (!$existing || !$existing->owner_rights()) {
                throw new Exception("Vous ne pouvez pas modifier ce commentaire.");
            }

            // Vérification du rattachement à l'élément courant
            if ($element->id() !== $existing->parent_object()->id()) {
                throw new Exception("Commentaire introuvable dans cet élément.");
            }

            $existing_parent = $existing->respond_to();
            if ($existing_parent) {
                // Vérification du parent éventuel
                if ($existing_parent->respond_to() || !$existing_parent->is_visible() || $existing_parent->parent_object() !== $element) {
                    $respond_to = 0;
                } else {
                    $respond_to = $existing_parent->id();
                }
            } else {
                $respond_to = 0;
            }

            // Reconstruction avec les propriétés originales
            $comment = new Comment([
                'id' => $existing->id(),
                'class' => $comment_class,
                'id_object' => $object_id,
                'privacy' => $existing->privacy(),
                'respond_to' => $respond_to,
                'descr_html' => $html,
                'creator' => $existing->owner('prop')
            ]);

            if (!$comment->save()) {
                $json_response['errors'] = html_display_error($comment);
            } else {
                $json_response['message'] = "Commentaire modifié.";
            }
            break;

        // SUPPRESSION
        case 'delete':
            $comment_id = intval($params['comment_id'] ?? 0);

            if ($comment_id <= 0) {
                throw new Exception("Identifiant invalide.");
            }

            $comment = Comment::find_by_id($comment_id);

            if (!$comment || !$comment->owner_rights()) {
                throw new Exception("Vous ne pouvez pas supprimer ce commentaire.");
            }

            // Vérification du rattachement à l'élément courant
            if ($element->id() !== $comment->parent_object()->id()) {
                throw new Exception("Commentaire introuvable dans cet élément.");
            }

            if (!$comment->delete()) {
                $json_response['errors'] = html_display_error($comment);
            } else {
                $json_response['message'] = "Commentaire supprimé.";
            }
            break;

        default:
            throw new Exception("Action inconnue.");
    }

    // ACTUALISATION DU HTML
    $json_response['html'] = Comment::render_comments($comment_class, $object_id);
    $json_response['success'] = true;

} catch (Throwable $e) {
    $json_response['success'] = false;
    $json_response['message'] = $e->getMessage();
}

// Réponse JSON
comment_json_exit($json_response);