<?php
require_once dirname(__DIR__) . '/auth/verifica.php';
require_once dirname(__DIR__) . "/biblioteca/valida-cpf.php";
require_once dirname(__DIR__) . "/biblioteca/valida-telefone.php";

// VERIFICA CAMPOS OBRIGATÓRIOS
if (empty($_POST["nome"])) {
  $_SESSION["mensagem-tipo"] = "negativo";
  $_SESSION["mensagem-conteudo"] = "<strong>Erro!: </strong>Não foi possível cadastrar o paciente.";
  $_SESSION["form_dados"] = $_POST;
  header("Location: /pacientes");
  exit;
}
if (empty($_POST["data-nascimento"])) {
  $_SESSION["mensagem-tipo"] = "negativo";
  $_SESSION["mensagem-conteudo"] = "<strong>Erro!: </strong>Não foi possível cadastrar o paciente.";
  $_SESSION["form_dados"] = $_POST;
  header("Location: /pacientes");
  exit;
}
if (empty($_POST["sexo"])) {
  $_SESSION["mensagem-tipo"] = "negativo";
  $_SESSION["mensagem-conteudo"] = "<strong>Erro!: </strong>Não foi possível cadastrar o paciente.";
  $_SESSION["form_dados"] = $_POST;
  header("Location: /pacientes");
  exit;
}
if (empty($_POST["fator-rh"])) {
  $_SESSION["mensagem-tipo"] = "negativo";
  $_SESSION["mensagem-conteudo"] = "<strong>Erro!: </strong>Não foi possível cadastrar o paciente.";
  $_SESSION["form_dados"] = $_POST;
  header("Location: /pacientes");
  exit;
}

// VERIFICA VALIDADE DE CAMPOS OPCIONAIS
if (!empty($_POST["cpf"])) {
  if (!validarCPF($_POST["cpf"])) {
    $_SESSION["mensagem-tipo"] = "neutro";
    $_SESSION["mensagem-conteudo"] = "CPF inválido!";
    $_SESSION["form_dados"] = $_POST;
    header("Location: /pacientes");
    exit;
  }
}
if (!empty($_POST["email"])) {
  if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    $_SESSION["mensagem-tipo"] = "neutro";
    $_SESSION["mensagem-conteudo"] = "Endereço de e-mail incorreto.";
    $_SESSION["form_dados"] = $_POST;
    header("Location: /pacientes");
    exit;
  }
}
if (!empty($_POST["tel"])) {
  if (!validarTelefone($_POST["tel"])) {
    $_SESSION["mensagem-tipo"] = "neutro";
    $_SESSION["mensagem-conteudo"] = "Telefone incorreto.";
    $_SESSION["form_dados"] = $_POST;
    header("Location: /pacientes");
    exit;
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
  $_SESSION["mensagem-tipo"] = "negativo";
  $_SESSION["mensagem-conteudo"] = "<strong>Erro SQL: </strong>" . $mysqli->error;
  $_SESSION["form_dados"] = $_POST;
  header("Location: /pacientes");
  exit;

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
$observacoes = $_POST["obs"] ?? "";
$historico_medico = $_POST["historico"] ?? "";
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
  unset($_SESSION["form_dados"]);
  $_SESSION["mensagem-tipo"] = "positivo";
  $_SESSION["mensagem-conteudo"] = "O paciente <strong>"
    . $_POST["nome"]
    . " </strong> foi cadastrado com sucesso!";
  header("Location: /");
  exit;
} else {
  $_SESSION["mensagem-tipo"] = "negativo";
  $_SESSION["mensagem-conteudo"] = "Erro ao cadastrar paciente: " . $stmt->error;
  $_SESSION["form_dados"] = $_POST;
  header("Location: /pacientes");
  exit;
}
