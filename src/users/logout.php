<?php
    // Si pas suffisant, voir https://www.php.net/session_destroy
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    unset($_SESSION['user']);
    header('Location: ' . create_url_proj([]));
?>