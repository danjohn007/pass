<?php
/**
 * Main entry point for PASS application
 */

// Include configuration
require_once 'config/config.php';
require_once 'config/database.php';

// Autoload classes
function autoload($className) {
    $paths = [
        APP_PATH . '/controllers/',
        APP_PATH . '/models/'
    ];
    
    foreach ($paths as $path) {
        $file = $path . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
}

spl_autoload_register('autoload');

// Simple router class
class Router {
    private $routes = [];
    
    public function add($pattern, $controller, $action) {
        $this->routes[] = [
            'pattern' => $pattern,
            'controller' => $controller,
            'action' => $action
        ];
    }
    
    public function dispatch() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Remove base path if exists
        $basePath = parse_url(BASE_URL, PHP_URL_PATH);
        if ($basePath && strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }
        
        $uri = trim($uri, '/');
        
        foreach ($this->routes as $route) {
            if (preg_match($route['pattern'], $uri, $matches)) {
                $controllerName = $route['controller'] . 'Controller';
                $actionName = $route['action'];
                
                if (class_exists($controllerName)) {
                    $controller = new $controllerName();
                    if (method_exists($controller, $actionName)) {
                        // Pass any captured groups as parameters
                        $params = array_slice($matches, 1);
                        call_user_func_array([$controller, $actionName], $params);
                        return;
                    }
                }
            }
        }
        
        // Default 404 handling
        http_response_code(404);
        include APP_PATH . '/views/errors/404.php';
    }
}

// Initialize router
$router = new Router();

// Define routes
$router->add('/^$/', 'Home', 'index');
$router->add('/^home$/', 'Home', 'index');
$router->add('/^login$/', 'Auth', 'login');
$router->add('/^register$/', 'Auth', 'register');
$router->add('/^logout$/', 'Auth', 'logout');
$router->add('/^dashboard$/', 'Dashboard', 'index');
$router->add('/^assessment\/([a-zA-Z0-9]+)$/', 'Assessment', 'take');
$router->add('/^assessment\/([a-zA-Z0-9]+)\/result$/', 'Assessment', 'result');
$router->add('/^tracking$/', 'Tracking', 'index');
$router->add('/^tracking\/add$/', 'Tracking', 'add');
$router->add('/^resources$/', 'Resources', 'index');
$router->add('/^profile$/', 'User', 'profile');
$router->add('/^admin$/', 'Admin', 'index');

// Dispatch the request
$router->dispatch();
?>