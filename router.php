<?php
if (file_exists(__DIR__ . $_SERVER['REQUEST_URI'])) {
    return false;
} else {
    if (preg_match('/\/api\/generate/', $_SERVER['REQUEST_URI'])) {
        include_once __DIR__ . '/api/generate.php';
    } elseif (preg_match('/\/api\/decode/', $_SERVER['REQUEST_URI'])) {
        include_once __DIR__ . '/api/decode.php';
    } else {
        include_once __DIR__ . '/index.php';
    }
    return true;
}