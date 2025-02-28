<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define uma constante que libera acesso aos arquivos componentes incluídos abaixo.
define('ACCESS_ALLOWED', true);

// Define o nome da página.
$nome_pagina = "Inicio";

// Autenticação de usuário com controle de erro do REQUIRE.
$arquivo_verifica = __DIR__ . '/auth/verifica.php';
if (file_exists($arquivo_verifica)) {
  require $arquivo_verifica;
} else {
  die("Erro crítico: arquivo de autenticação de usuário não encontrado.");
}

// Configurações globais com controle de erro do REQUIRE.
$arquivo_config = __DIR__ . '/config.php';
if (file_exists($arquivo_config)) {
  require $arquivo_config;
} else {
  die("Erro crítico: arquivo de configuração não encontrado.");
}

// Chama o componente TOPO.PHP.
require_once __DIR__ . '/componentes/topo.php';

?>

</head>

<body class="bg-success">

  <?php require_once __DIR__ . '/componentes/barra-nav.php'; ?>

  <div class="container col-11 bg-light text-dark mx-auto p-3 mt-4 rounded-2 shadow altura-85">

    <?php require_once __DIR__ . '/paginas/painel.php'; ?>

  </div>

</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</html>
