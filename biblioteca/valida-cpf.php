<?php
require_once dirname(__DIR__) . '/auth/verifica.php';

function validarCPF($cpf)
{
  // Remove caracteres não numéricos
  $cpf = preg_replace('/\D/', '', $cpf);

  // Verifica se tem 11 dígitos
  if (strlen($cpf) != 11) {
    return false;
  }

  // Elimina CPFs inválidos conhecidos
  if (preg_match('/^(.)\1{10}$/', $cpf)) {
    return false;
  }

  // Calcula e verifica os dígitos verificadores
  for ($t = 9; $t < 11; $t++) {
    $d = 0;
    for ($c = 0; $c < $t; $c++) {
      $d += $cpf[$c] * (($t + 1) - $c);
    }
    $d = ((10 * $d) % 11) % 10;
    if ($cpf[$t] != $d) {
      return false;
    }
  }

  return true;
}

function existeCpf($cpf)
{
  $mysqli = require dirname(__DIR__) . "/auth/database.php";

  $sql = "SELECT * FROM pacientes WHERE cpf =" . $cpf;

  $stmt = $mysqli->stmt_init();

  if (!$stmt->prepare($sql)) {
    die("Erro de conexão com o DB!");
  }

  $stmt->execute();

  $result = $stmt->get_result();

  $row = $result->fetch_assoc();

  $stmt->close();
  
  if (isset($row["id"])) {
  return true;
  } else {
    return false;
  }
}

function idCpf($cpf)
{
  $mysqli = require dirname(__DIR__) . "/auth/database.php";

  $sql = "SELECT id FROM pacientes WHERE cpf =" . $cpf;

  $stmt = $mysqli->stmt_init();

  if (!$stmt->prepare($sql)) {
    die("Erro de conexão com o DB!");
  }

  $stmt->execute();

  $result = $stmt->get_result();

  $row = $result->fetch_assoc();

  $stmt->close();
  
  if (isset($row["id"])) {
  return $row["id"];
  }
}
