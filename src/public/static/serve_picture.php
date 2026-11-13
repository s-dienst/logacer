<?php
require_once("../../variables.php");
require_once("../../layout/functions2.php");
require_once("../../layout/functions_database.php");
require_once("../../layout/functions_html.php");
require_once("../../layout/errors.php");
require_once("../../layout/thesaurus.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Get the requested file
$filename = $_GET['picture'] ?? '';
if (!$filename) {
    http_response_code(400);
    exit('Missing file parameter');
}

// Split into path + extension
$pathInfo   = pathinfo($filename);
$url_path   = $pathInfo['filename'];   // e.g. "00.EAR.31403.2"
$extension  = $pathInfo['extension'];  // e.g. "svg"

// Retrieve the picture object
$pictures = Picture::find_by_properties(["url_path"=>$url_path, "extension"=>$extension]);

if (empty($pictures)) {
    http_response_code(404);
    exit('Picture not found');
}

$picture = $pictures[0];

// Check if the current user has access to this picture
$object = ObjectTable::find_by_id($picture->related_object()->id());
if ($object->contributor_rights() || $object->related_context()->public()) {
    $has_access = true;
} else {
    $has_access = false;
}
if (!$has_access) {
    http_response_code(403);
    exit('Access denied');
}

// Correct picture path (from rue function)
$lastpoint = strrpos($filename, '.');
$first = substr($filename, 0, $lastpoint);
$last = substr($filename, $lastpoint);
$real_filename = str_replace('.', '%2E', $first) . $last;

// Build the real file path
$baseDir = realpath(__DIR__ . '/pictures_objects');
$path    = realpath($baseDir . '/' . $real_filename);

// Ensure the file is inside the allowed directory
if ($path && strpos($path, $baseDir) === 0 && file_exists($path)) {
    $mime = mime_content_type($path);
    header("Content-Type: $mime");
    readfile($path);
    exit;
} else {
    http_response_code(404);
    exit('File not found');
}
?>