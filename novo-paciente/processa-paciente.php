<?php

require_once dirname(__DIR__) . "/biblioteca/valida-cpf.php";
require_once dirname(__DIR__) . "/biblioteca/valida-telefone.php";

// VERIFICA CAMPOS OBRIGATÓRIOS
if (empty($_POST["nome"])) {
  die("Faltou o nome!");
}
if (empty($_POST["data-nascimento"])) {
  die("Faltou a data de nascimento!");
}
if (empty($_POST["sexo"])) {
  die("Faltou o sexo!");
}
if (empty($_POST["fator-rh"])) {
  die("Faltou o tipo sanguineo!");
}

// VERIFICA VALIDADE DE CAMPOS OPCIONAIS
if (!empty($_POST["cpf"])) {
  if (!validarCPF($_POST["cpf"])) {
    die("O CPF está incorreto!");
  }
}
if (!empty($_POST["email"])) {
  if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("O endereço de E-Mail está incorreto!");
  }
}
if (!empty($_POST["tel"])) {
  if (!validarTelefone($_POST["tel"])) {
    die ("O telefone está incorreto!");
  }
}
