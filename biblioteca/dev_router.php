<?php

// Simula o comportamento do .htaccess no servidor embutido do PHP
$request = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$file = __DIR__ . $request;

// Se for um arquivo ou diretório real, deixa o PHP servir normalmente
if ($request !== '/' && file_exists($file)) {
    return false;
}

// Encaminha todas as requisições para `index.php`
require dirname(__DIR__) . '/spe/index.php';

