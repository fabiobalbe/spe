<?php

require_once dirname(__DIR__) . '/auth/verifica.php';

if (empty($_POST["nome"])) {                                         // VERIFICA SE O NOME E EMAIL ESTÃO PREENCHIDOS.
  die("Faltou o nome!");
}
if (empty($_POST["email"])) {
  die("Faltou o email!");
}
if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {           // VERIFICA SE O EMAIL É VÁLIDO.
  die("O endereço de E-Mail está incorreto!");
}
if (empty($_POST["senha"])) {
  die("Faltou a senha!");
}
if (strlen($_POST["senha"]) < 8) {                                   // VERIFICA SE A SENHA TEM AO MENOS 8 CARACTERES.
  die("Senha deve ter ao menos 8 caracteres!");
}
if (!preg_match("/[a-z]/i", $_POST["senha"])) {                      // VERIFICA SE A SENHA TEM AO MENOS UMA LETRA.
  die("Senha deve ter ao menos uma letra");
}
if (!preg_match("/[0-9]/i", $_POST["senha"])) {                      // VERIFICA SE A SENHA TEM AO MENOS UM NÚMERO.
  die("Senha deve ter ao menos um número!");
}
if ($_POST["senha"] !== $_POST["confirmar-senha"]) {                 // VERIFICA SE A SENHA E O CONFIRMAR-SENHA SÃO 
  die("As senhas não são inguais!");                                 // IDENTICOS.
}

$senha_hash = password_hash($_POST["senha"], PASSWORD_DEFAULT);      // GERA O HASH DA SENHA.

$mysqli = require __DIR__ . "/database.php";                         // RETORNA O OBJETO mysqli COM A CONFIGURAÇÃO 
// DE CONEXÃO MYSQL.
$sql = "INSERT INTO users (name, email, senha_hash)
        VALUES (?, ?, ?)";

$stmt = $mysqli->stmt_init();                                        // INICIA O OBJETO DE DECLARAÇÃO PREPARADA.

if (!$stmt->prepare($sql)) {                                         // SEGURA E EXIBE ERRO MYSQL.
  die("Erro SQL:" . $mysqli->error);
}

$stmt->bind_param(                                                   // bind_param() VINCULA VALORES AOS "?". 
  "sss",                                                             // DEFINE TIPOS DE VALORES STRING.
  $_POST["nome"],
  $_POST["email"],
  $senha_hash
);

try {
  if ($stmt->execute()) {                                            // TENTA EXECUTAR A QUERRY $sql.

    session_start();

    $_SESSION["mensagem-tipo"] = "positivo";

    $_SESSION["mensagem-conteudo"] = "O usuário <strong>"
      . $_POST["nome"]
      . " </strong> foi criado com sucesso!";

    header("Location: ../");                                // REDIRECIONA PARA O PAINEL.

    exit;
  }
} catch (mysqli_sql_exception $e) {                                  // SE DÁ ERRO EXIBE MENSAGEM:
  if ($e->getCode() === 1062) {                                      // SE O ERRO É DE DUPLICATA NO EMAIL. 
    die("<b>Erro</b>: E-Mail já cadastrado!");
  } else {                                                           // SE É OUTRO, EXIBE MENSAGEM DO MYSQL E ERRO.
    die("Erro: " . $e->getMessage() . " Código: " . $e->getCode());
  }
}
