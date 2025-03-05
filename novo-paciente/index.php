<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define uma constante que libera acesso aos arquivos componentes incluídos abaixo.
define('ACCESS_ALLOWED', true);

// Define o nome da página.
$nome_pagina = "Cadastro de Paciente";

// Autenticação de usuário com controle de erro do REQUIRE.
$arquivo_verifica = dirname(__DIR__) . '/auth/verifica.php';
if (file_exists($arquivo_verifica)) {
  require $arquivo_verifica;
} else {
  die("Erro crítico: arquivo de autenticação de usuário não encontrado.");
}

// Configurações globais com controle de erro do REQUIRE.
$arquivo_config = dirname(__DIR__) . '/config.php';
if (file_exists($arquivo_config)) {
  require $arquivo_config;
} else {
  die("Erro crítico: arquivo de configuração não encontrado.");
}

// Chama o componente TOPO.PHP.
require_once dirname(__DIR__) . '/componentes/topo.php';

?>

</head>

<body class="bg-success">

  <?php require_once dirname(__DIR__) . '/componentes/barra-nav.php'; ?>

  <?php
  if (isset($_SESSION["mensagem-conteudo"])) {
    include_once dirname(__DIR__) . '/componentes/mensagem.php';
    unset($_SESSION["mensagem-conteudo"]);
  }
  ?>

  <div class="container col-11 bg-light text-dark mx-auto p-3 mt-4 rounded-2 shadow altura-85">
    <?php include_once dirname(__DIR__) . '/paginas/form-novo-paciente.php'; ?>
  </div>
</body>

</html>
