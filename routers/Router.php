<?php
namespace Routers;

use Request\Request;

class Router
{
    private $routes = [];

    public function __construct(private Request $request)
    {
    }

    public function add(string $method, string $path, array $handler)
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function dispatch($method, $path)
    {
        foreach ($this->routes as $route) {
            if ($route['method'] === strtoupper($method) && $route['path'] === $path) {

                $handler = $route['handler'];

                $controller = new $handler[0]($this->request);
                $action = $handler[1];
                return $controller->$action();
            }
        }
    }
}
