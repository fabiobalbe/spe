<?php
//------------------------------------------------------- DEV -------------------------------------------------------//
// Define algumas configurações de desenvolvimento.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


//----------------------------------------------- CONTROLE DE ACESSO ------------------------------------------------//
// Define uma constante que libera acesso aos arquivos componentes incluídos abaixo.
define('ACCESS_ALLOWED', true);


//------------------------------------------- REQUISIÇÃO DE COMPONENTES -------------------------------------------//
// Autenticação de usuário com controle de erro do REQUIRE.
$arquivo_verifica = dirname(__DIR__) . '/spe/auth/verifica.php';
if (file_exists($arquivo_verifica)) {
  require $arquivo_verifica;
} else {
  die("Erro crítico: arquivo de autenticação de usuário não encontrado.");
}

// Configurações globais com controle de erro do REQUIRE.
$arquivo_config = dirname(__DIR__) . '/spe/config.php';
if (file_exists($arquivo_config)) {
  require_once $arquivo_config;
} else {
  die("Erro crítico: arquivo de configuração não encontrado.");
}

//------------------------------------------- INICIALIZAÇÃO DO ROUTER ---------------------------------------------//

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
require_once dirname(__DIR__) . '/spe/biblioteca/router.php';

$router = new Router;

//------------------------------------------------------ ROTAS ------------------------------------------------------//

$arquivo_rotas = dirname(__DIR__) . '/spe/routes.php';
if (file_exists($arquivo_rotas)) {
  require_once $arquivo_rotas;
} else {
  die("Erro crítico: arquivo de rotas não encontrado.");
}

//------------------------------------------------------- PÁGINA ---------------------------------------------------//
// Define o título da página antes do HTML
$titulo_pagina = $router->getRouteTitle($path);

// Chama o componente TOPO.PHP.
require_once dirname(__DIR__) . '/spe/componentes/topo.php';

?>

<!---------------------------------------------------- COMEÇO DO BODY ----------------------------------------------->

<body class="bg-success">

  <!----- INSERE A BARRA DE NAVEGAÇÃO COM COMPONENTE HTML NAV ------>
  <?php require_once dirname(__DIR__) . '/spe/componentes/barra-nav.php'; ?>


  <?php
  // INSERE MENSAGEM DE NOTIFICAÇÃO
  if (isset($_SESSION["mensagem-conteudo"])) {
    include_once dirname(__DIR__) . '/spe/componentes/mensagem.php';
    unset($_SESSION["mensagem-conteudo"]);
  }
  ?>

  <!----------------------------------------- CONTAINER DE CONTEÚDO PRINCIPAL --------------------------------------->
  <div class="container col-11 bg-light text-dark mx-auto p-3 mt-4 rounded-2 shadow altura-85">
    
    <!-- INCLUI O CONTEÚDO DA PÁGINA POR MEIO DE REQUIRE_once --> 
    <?php $router->dispatch($path); ?>

  </div>

</body>

</html>
