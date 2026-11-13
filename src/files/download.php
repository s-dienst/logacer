<?php

$file = File::find_by_id($params['idfile']);
$file_path = false;
// Check if file accessible : from user or public
if ($file) {
    if ($file->public()) {
        $file_path = $file->path();
    } elseif (isset($_SESSION['user'])) {
        if ($file->owner_rights()) {
            $file_path = $file->path();
        }
    }
}

if ($file_path) {
    // Get the absolute path
    $full_path = realpath($file_path);
    // Set headers to force download
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($full_path) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($full_path));

    // Clear output buffer and read the file
    flush();
    readfile($full_path);
    exit;
}

?>