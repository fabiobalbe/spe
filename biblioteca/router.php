<?php
require_once dirname(__DIR__) . '/auth/access_control.php';

class Router
{
  private array $routes = [];
  private string $title = "SPE"; // Título padrão

  public function add(string $path, Closure $handler, string $title = ""): void
  {
    $this->routes[$path] = ['handler' => $handler, 'title' => $title];
  }

  public function dispatch(string $path): void
  {
    if (array_key_exists($path, $this->routes)) {
      $route = $this->routes[$path];
      $this->title = $route['title'] ?: "Meu Site";
      call_user_func($route['handler']);
    } else {
      $this->title = "Página não encontrada";
      echo "Página não encontrada";
    }
  }

  // Novo método para obter o título sem executar o handler
  public function getRouteTitle(string $path): string
  {
    if (array_key_exists($path, $this->routes)) {
      $route = $this->routes[$path];
      return $route['title'] ?: "Meu Site";
    }
    return "Página não encontrada";
  }

  public function getTitle(): string
  {
    return $this->title;
  }
}
