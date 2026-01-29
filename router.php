<?php
/**
 * Router script for PHP built-in development server
 * Usage: php -S localhost:8080 router.php
 */

// Get the request URI
$uri = $_SERVER['REQUEST_URI'];
$path = parse_url($uri, PHP_URL_PATH);

// If it's a real file, serve it directly
if ($path !== '/' && file_exists(__DIR__ . $path)) {
    return false; // Let PHP serve the file
}

// Fix SCRIPT_NAME for proper routing
$_SERVER['SCRIPT_NAME'] = '/index.php';

// Route through index.php
require_once __DIR__ . '/index.php';

