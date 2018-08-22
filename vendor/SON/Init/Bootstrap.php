<?php

namespace SON\Init;

abstract class Bootstrap
{

    private $routes;
    private static $idRoute;

    public function __construct()
    {
        $this->initRoutes();
        $this->run($this->getUrl());
    }

    abstract protected function initRoutes();

    protected function run($url)
    {
        array_walk($this->routes, function ($route) use ($url) {

            if ($url == $route['route']) {
                $class = "App\\Controllers\\".ucfirst($route['controller']);
                $controller = new $class;
                $controller->$route['action']();
            }
        });
    }

    protected function setRoutes(array $routes)
    {
        $this->routes = $routes;
    }

    protected function getUrl()
    {
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $pieces = explode("/", $url);
        $url = "/". $pieces[1];
        // Se tiver um segundo parâmetro na URL, envia o valor para o método getIdByUrl, para pegar o ID da rota. Este método estático permite retornar o valor para usar nos forms, como edição e remoção de campos na tabela por ID.
        if (count($pieces) != 2) {
            self::$idRoute = $pieces[2];
            $this->getIdByUrl(self::$idRoute);
        }
        return $url;
    }

    // Retorna o ID da URL no formato URL/action/id (segundo parametro da URL)
    public static function getIdByUrl()
    {
        return self::$idRoute;
    }
}
