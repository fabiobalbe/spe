<?php
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
  die("As senhas não são inguais!");                                 // IDENTIDOS.
}

$senha_hash = password_hash($_POST["senha"], PASSWORD_DEFAULT);      // GERA O HASH DA SENHA.

$mysqli = require __DIR__ . "/database.php";

print_r($_POST);
var_dump($senha_hash);
