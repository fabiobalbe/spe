<?php
require_once dirname(__DIR__) . '/auth/verifica.php';
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
    die("O telefone está incorreto!");
  }
}

$mysqli = require dirname(__DIR__) . "/auth/database.php";

$sql = "INSERT INTO pacientes
        (
          nome,
          data_nascimento,
          telefone,
          email,
          sexo,
          cpf,
          tipo_sanguineo,
          alergias,
          historico_medico,
          observacoes,
          ativo
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
  die("Erro SQL: " . $mysqli->error);
}

// Definir os valores
$nome = $_POST["nome"];
$data_nascimento = $_POST["data-nascimento"];
$sexo = $_POST["sexo"];
$tipo_sanguineo = $_POST["fator-rh"];
$cpf = $_POST["cpf"] ?? "";
$email = $_POST["email"] ?? "";
$telefone = $_POST["tel"] ?? "";
$alergias = $_POST["alergias"] ?? "";
$observacoes = $_POST["observacoes"] ?? "";
$historico_medico = $_POST["historico_medico"] ?? "";
$ativo = 1;

// Bind dos parâmetros
$stmt->bind_param(
  "ssssssssssi",  // Tipos dos dados
  $nome,
  $data_nascimento,
  $telefone,
  $email,
  $sexo,
  $cpf,
  $tipo_sanguineo,
  $alergias,
  $historico_medico,
  $observacoes,
  $ativo
);

if ($stmt->execute()) {


  $_SESSION["mensagem-tipo"] = "positivo";

  $_SESSION["mensagem-conteudo"] = "O paciente <strong>"
    . $_POST["nome"]
    . " </strong> foi cadastrado com sucesso!";

  header("Location: ../");

  exit;
} else {
  die("Erro ao cadastrar paciente: " . $stmt->error);
}
