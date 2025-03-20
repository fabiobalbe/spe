<?php

// Se estiver no ambiente de desenvolvimento, inclui o roteador alternativo
if (file_exists(dirname(__DIR__) . '/spe/biblioteca/dev_router.php')) {
    require dirname(__DIR__) . '/spe/biblioteca/dev_router.php';
    exit; // Garante que o script encerre aqui e não continue no router principal
}

class Router
{

  private array $routes = [];

  public function add(string $path, Closure $handler): void
  {
    $this->routes[$path] = $handler;
  }

  public function dispatch(string $path): void
  {
    if (array_key_exists($path, $this->routes)) {
      $handler = $this->routes[$path];
      call_user_func($handler);
    } else {
      echo "Página não encontrada";
    }
  }
}
