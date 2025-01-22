<?php

class Router
{
    public static function route($method, $path, $callback)
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        $pathPattern = '#^' . preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[a-zA-Z0-9_]+)', $path) . '$#';

        if ($method === $requestMethod && preg_match($pathPattern, $requestPath, $matches)) {
            $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
            call_user_func($callback, ...array_values($params));
            exit;
        }
    }
}
