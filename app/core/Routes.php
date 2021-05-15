<?php
namespace App\Core;

class Routes {
    private $routes = array();
    private $middleware;

    public function get($path, $function) {
        array_push($this->routes, ['route' => $path, 'function' => $function, 'method' => 'GET']);
    }
    public function post($path, $function) {
        array_push($this->routes, ['route' => $path, 'function' => $function, 'method' => 'POST']);
    }

    public function middleware($middleware) {
        $this->middleware .= 'App\Middleware\\'.$middleware;
        return $this;
    }

    public function init() {
        $path = isset($_SERVER['PATH_INFO']) ? explode('/', $_SERVER['PATH_INFO']) : ['/'];
        array_shift($path);
        $method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
        foreach ($this->routes as $route) {
            $routePath = explode('/', $route['route']);
            array_shift($routePath);
            $correct = true;
            $params = [];
            if (count($path) !== count($routePath) OR $route['method'] !== $method) continue;
            foreach ($routePath as $index => $value) {
                if (empty($path[$index])) {
                    $correct = false;
                    break;
                }
                if ($value === $path[$index]) continue;

                if (strpos($value, '{') !== false AND strpos($value, '}') !== false) {
                    $params[trim(trim($value, '}'), '{')] = $path[$index];
                    continue;
                }
                $correct = false;
                break;
            }
            if (!$correct) continue;

            if (isset($this->middleware)) {
                $middleware = new $this->middleware();
                $correct = $middleware->next($params);
            } else $correct = true;
            if ($correct)
                call_user_func_array($route['function'], $params);
        }
    }
}