<?php

require_once __DIR__ . '/Response.php';

// GET - fetch data
// POST - create
// PUT - update all fields
// PATCH - partial update
// DELETE - delete

class Router
{
    private $rotas = [];

    public function addRota($method, $path, $callback)
    {
        $this->rotas[$method][$path] = $callback;
    }

    public function get($path, $callback)
    {
        $this->addRota('GET', $path, $callback);
    }

    public function post($path, $callback)
    {
        $this->addRota('POST', $path, $callback);
    }

    public function put($path, $callback)
    {
        $this->addRota('PUT', $path, $callback);
    }

    public function patch($path, $callback)
    {
        $this->addRota('PATCH', $path, $callback);
    }

    public function delete($path, $callback)
    {
        $this->addRota('DELETE', $path, $callback);
    }

    public function run()
    {
        $method = $_SERVER['REQUEST_METHOD'];

        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $base = '/api';

        if (str_starts_with($uri, $base)) {
            $uri = substr($uri, strlen($base));
        }

        if (isset($this->rotas[$method][$uri])) {
            [$class, $action] = $this->rotas[$method][$uri];
            call_user_func([new $class(), $action]);
            return;
        }

        $response = new Response();
        $response->json([
            "erro" => "Rota não encontrada"
        ], 404);
    }
}