<?php
namespace MVC;
class Router {
    protected $routes = [];

    public function addRoute($route, $controller, $action) {
        $this->routes[$route] = ['controller' => $controller, 'action' => $action];
    }

    public function dispatch($uri) {
        // Parse the URL to get the path and query string
        $parsedUrl = parse_url($uri);
        $path = $parsedUrl['path'];
        $queryParams = [];

        // If there's a query string, parse it into an array
        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $queryParams);
        }

        // Handle the root path ("/") properly
        if (array_key_exists($path, $this->routes)) {
            $controller = $this->routes[$path]['controller'];
            $action = $this->routes[$path]['action'];
            $controller = new $controller();

            // Pass query parameters to the controller action
            $controller->$action($queryParams);
        } else {
            throw new \Exception("No route found for URI: $uri");
        }
    }
}