<?php
//------------------------------------------------------- DEV -------------------------------------------------------//
// Define algumas configurações de desenvolvimento.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


//----------------------------------------------- CONTROLE DE ACESSO ------------------------------------------------//
// Define uma constante que libera acesso aos arquivos componentes incluídos abaixo.
define('ACCESS_ALLOWED', true);


//------------------------------------------- CONFIGURAÇÕES DA PÁGINA --------------------------------------------//
// Define o nome da página.
$nome_pagina = "Inicio";


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
  require $arquivo_config;
} else {
  die("Erro crítico: arquivo de configuração não encontrado.");
}


//------------------------------------------------------- PÁGINA ---------------------------------------------------//
// Chama o componente TOPO.PHP.
require_once dirname(__DIR__) . '/spe/componentes/topo.php';


?>

</head>

<!------------------------------------------------- FIM DA TAG HTML HEAD --------------------------------------------->

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

    <?php require_once dirname(__DIR__) . '/spe/paginas/painel.php'; ?>

  </div>

</body>

</html>
