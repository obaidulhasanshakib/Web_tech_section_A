<?php
class Router {
  private array $routes = ['GET'=>[], 'POST'=>[]];

  public function get($uri, $action){ $this->routes['GET'][$uri] = $action; }
  public function post($uri, $action){ $this->routes['POST'][$uri] = $action; }

  public function dispatch() {
    $method = $_SERVER['REQUEST_METHOD'];
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    // base path কাটবে
    $base = '/artisanal-tea/public';
    if (str_starts_with($uri, $base)) $uri = substr($uri, strlen($base));
    if ($uri === '') $uri = '/';

    $action = $this->routes[$method][$uri] ?? null;
    if (!$action) { http_response_code(404); die('404 Not Found'); }

    [$controller, $fn] = $action;
    require_once __DIR__ . "/../controllers/{$controller}.php";
    (new $controller)->$fn();
  }
}
