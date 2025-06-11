<?php

namespace Core;

class Router
{
    private $routes = [];

    public function get(string $uri, string $controller): void
    {
        $this->routes['GET'][] = [
            'uri' => $uri,
            'controller' => $controller
        ];
    }

    public function post(string $uri, string $controller): void
    {
        $this->routes['POST'][] = [
            'uri' => $uri,
            'controller' => $controller
        ];
    }

    public function run(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $requestUri = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/') ?: '/';
        $pathURL = str_replace(dirname($_SERVER['SCRIPT_NAME']), '', $requestUri);

        if ($pathURL === '') {
            $pathURL = '/';
        }

        if (!isset($this->routes[$method])) {
            http_response_code(405);
            echo "Method Not Allowed";
            return;
        }

        foreach ($this->routes[$method] as $route) {
            $pattern = preg_replace("#\{[\w-]+\}#", '([\w-]+)', $route['uri']);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $pathURL, $varMatched)) {

                array_shift($varMatched); // remove full match
                preg_match_all("#\{([\w-]+)\}#", $route['uri'], $keyMatches);

                $params = array_combine($keyMatches[1], $varMatched);

                $file = '../app/controllers' . $route['controller'];
                if (file_exists($file)) {
                    require_once $file;
                    $controllerName = ucfirst(basename($route['controller'], '.php'));
                    $controllerName = str_replace('_', '', $controllerName);
                    if (!class_exists($controllerName)) {
                        http_response_code(500);
                        echo "Controller class $controllerName not found in $file";
                        return;
                    }
                    $controller = new $controllerName();

                    // Extract method name from URL and route
                    $methodName = $this->extractMethod($pathURL, $route['uri'], $controller);

                    if (!method_exists($controller, $methodName)) {
                        http_response_code(500);
                        echo "Method '$methodName' not found in controller '$controllerName'";
                        return;
                    }

                    call_user_func_array([$controller, $methodName], array_values($params));
                    return;
                } else {
                    http_response_code(404);
                    echo "Controller file not found: $file";
                    return;
                }
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }

    private function extractMethod(string $pathURL, string $routeUri, object $controller): string
    {
        $pathSegments = explode('/', trim($pathURL, '/'));
        $routeSegments = explode('/', trim($routeUri, '/'));

        // Determine method as the first segment in $pathURL not matched by route pattern placeholder
        foreach ($routeSegments as $i => $segment) {
            if (!str_starts_with($segment, '{') && isset($pathSegments[$i])) {
                $possibleMethod = str_replace('-', '_', $pathSegments[$i]);
                if (method_exists($controller, $possibleMethod)) {
                    return $possibleMethod;
                }
            }
        }

        // Fallback
        return 'index';
    }
}
