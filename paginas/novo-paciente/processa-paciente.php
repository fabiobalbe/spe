<?php
require_once '../../auth/verifica.php';
require_once "../../biblioteca/valida-cpf.php";
require_once "../../biblioteca/valida-telefone.php";
$mysqli = require  "../../auth/database.php";

// VERIFICA CAMPOS OBRIGATÓRIOS
if (empty($_POST["nome"])) {
  $_SESSION["mensagem-tipo"] = "negativo";
  $_SESSION["mensagem-conteudo"] = "<strong>Erro!: </strong>Não foi possível cadastrar o paciente.";
  $_SESSION["form_dados"] = $_POST;
  header("Location: /pacientes/novo-paciente");
  exit;
}
if (empty($_POST["data-nascimento"])) {
  $_SESSION["mensagem-tipo"] = "negativo";
  $_SESSION["mensagem-conteudo"] = "<strong>Erro!: </strong>Não foi possível cadastrar o paciente.";
  $_SESSION["form_dados"] = $_POST;
  header("Location: /pacientes/novo-paciente");
  exit;
}
if (empty($_POST["sexo"])) {
  $_SESSION["mensagem-tipo"] = "negativo";
  $_SESSION["mensagem-conteudo"] = "<strong>Erro!: </strong>Não foi possível cadastrar o paciente.";
  $_SESSION["form_dados"] = $_POST;
  header("Location: /pacientes/novo-paciente");
  exit;
}
if (empty($_POST["fator-rh"])) {
  $_SESSION["mensagem-tipo"] = "negativo";
  $_SESSION["mensagem-conteudo"] = "<strong>Erro!: </strong>Não foi possível cadastrar o paciente.";
  $_SESSION["form_dados"] = $_POST;
  header("Location: /pacientes/novo-paciente");
  exit;
}

// VERIFICA VALIDADE DE CAMPOS OPCIONAIS
// CPF
if (!empty($_POST["cpf"])) {
  $cpfValidator = new CPFValidator($mysqli);
  //CPF VALIDO?
  if (!$cpfValidator->validarCPF($_POST["cpf"])) {
    $_SESSION["mensagem-tipo"] = "neutro";
    $_SESSION["mensagem-conteudo"] = "CPF inválido!";
    $_SESSION["form_dados"] = $_POST;
    header("Location: /pacientes/novo-paciente");
    exit;
  }
  // CPF JÁ EXISTE?
  if ($cpfValidator->existeCpf($_POST["cpf"]) === true) {
    $_SESSION["mensagem-tipo"] = "neutro";
    $_SESSION["mensagem-conteudo"] = "CPF já utilizado!";
    $_SESSION["form_dados"] = $_POST;
    header("Location: /pacientes/novo-paciente");
    exit;
  }
}

if (!empty($_POST["email"])) {
  if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    $_SESSION["mensagem-tipo"] = "neutro";
    $_SESSION["mensagem-conteudo"] = "Endereço de e-mail incorreto.";
    $_SESSION["form_dados"] = $_POST;
    header("Location: /pacientes/novo-paciente");
    exit;
  }
}
if (!empty($_POST["tel"])) {
  if (!validarTelefone($_POST["tel"])) {
    $_SESSION["mensagem-tipo"] = "neutro";
    $_SESSION["mensagem-conteudo"] = "Telefone incorreto.";
    $_SESSION["form_dados"] = $_POST;
    header("Location: /pacientes/novo-paciente");
    exit;
  }
}

$mysqli = require  "../../auth/database.php";

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
  header("Location: /pacientes/novo-paciente");
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
  header("Location: /pacientes");
  exit;
} else {
  $_SESSION["mensagem-tipo"] = "negativo";
  $_SESSION["mensagem-conteudo"] = "Erro ao cadastrar paciente: " . $stmt->error;
  $_SESSION["form_dados"] = $_POST;
  header("Location: /pacientes/novo-paciente");
  exit;
}
