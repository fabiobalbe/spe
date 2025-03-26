<?php

// Controle de acesso de importação de componente.
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
    foreach ($this->routes as $routePath => $route) {
      // Transforma "/paciente/:id" em "/paciente/([^/]+)"
      $pattern = preg_replace('/:[^\/]+/', '([^/]+)', $routePath);

      // Usa delimitadores '#' para evitar problemas com barras '/'
      if (preg_match('#^' . $pattern . '$#', $path, $matches)) {
        array_shift($matches); // Remove o primeiro elemento (string completa)

        // Define o título da página
        $this->title = $route['title'] ?: "Meu Site";

        // Executa o handler e passa os parâmetros extraídos
        call_user_func_array($route['handler'], $matches);
        return;
      }
    }

    // Se não encontrou uma rota correspondente
    $this->title = "Página não encontrada";
    echo "Página não encontrada";
  }

  public function getRouteTitle(string $path): string
  {
    foreach ($this->routes as $routePath => $route) {
      $pattern = preg_replace('/:[^\/]+/', '([^/]+)', $routePath);
      if (preg_match('#^' . $pattern . '$#', $path)) {
        return $route['title'] ?: "Meu Site";
      }
    }
    return "Página não encontrada";
  }

  public function getTitle(): string
  {
    return $this->title;
  }
}
