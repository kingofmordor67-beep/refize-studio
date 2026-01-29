<?php
/**
 * =====================================================
 * REFIZE STUDIO - Monster Adventure
 * Main Entry Point (index.php)
 * =====================================================
 * 
 * This is a lightweight MVC implementation inspired by CodeIgniter 4
 * Handles routing, controllers, and views
 */

// Error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session
session_start();

// Define paths
define('BASEPATH', __DIR__ . '/');
define('APPPATH', __DIR__ . '/app/');
define('PUBLICPATH', __DIR__ . '/public/');

// Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = APPPATH;
    
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    
    if (file_exists($file)) {
        require $file;
    }
});

// Load configuration
require_once APPPATH . 'Config/Database.php';
require_once APPPATH . 'Config/App.php';

// Simple Router
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = trim($uri, '/');
$segments = $uri ? explode('/', $uri) : [];

// Get base path from URL (for subdirectory installations)
$scriptName = $_SERVER['SCRIPT_NAME'];
$basePath = dirname($scriptName);
$basePath = $basePath === '\\' || $basePath === '/' ? '' : $basePath;

// Remove base path from URI
if ($basePath && strpos($uri, trim($basePath, '/')) === 0) {
    $uri = substr($uri, strlen(trim($basePath, '/')));
    $uri = ltrim($uri, '/');
    $segments = $uri ? explode('/', $uri) : [];
}

// Route to controller
$controller = !empty($segments[0]) ? ucfirst($segments[0]) : 'Home';
$method = $segments[1] ?? 'index';
$params = array_slice($segments, 2);

// Handle CMS API requests
if (strtolower($segments[0] ?? '') === 'cms') {
    header('Content-Type: application/json');
    $controller = 'CMS';
    $method = $segments[1] ?? 'index';
    $params = array_slice($segments, 2);
}

// Handle AJAX API requests
if ($controller === 'Api') {
    header('Content-Type: application/json');
    $apiController = $segments[1] ?? 'home';
    $apiMethod = $segments[2] ?? 'index';
    $controller = 'Api\\' . ucfirst($apiController);
    $method = $apiMethod;
    $params = array_slice($segments, 3);
}

$controllerClass = "App\\Controllers\\{$controller}";

if (class_exists($controllerClass)) {
    $instance = new $controllerClass();
    if (method_exists($instance, $method)) {
        call_user_func_array([$instance, $method], $params);
    } else {
        http_response_code(404);
        echo "Method not found: {$method}";
    }
} else {
    // Try default Home controller for clean URLs
    $controllerClass = "App\\Controllers\\Home";
    if (class_exists($controllerClass)) {
        $instance = new $controllerClass();
        $instance->index();
    } else {
        http_response_code(404);
        echo "Controller not found: {$controller}";
    }
}
