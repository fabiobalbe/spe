<?php
require_once '../../auth/verifica.php';
require_once "../../biblioteca/valida-cpf.php";
require_once "../../biblioteca/valida-telefone.php";

// VERIFICA CAMPOS OBRIGATÓRIOS
if (empty($_POST["id"])) {
  $_SESSION["mensagem-tipo"] = "negativo";
  $_SESSION["mensagem-conteudo"] = "<strong>Erro!: </strong>Ocorreu um problema.";
  $_SESSION["form_dados"] = $_POST;
  header("Location: /paciente/editar/" . $_POST["id"] . "");
  exit;
}

if (empty($_POST["nome"])) {
  $_SESSION["mensagem-tipo"] = "negativo";
  $_SESSION["mensagem-conteudo"] = "<strong>Erro!: </strong>Nome deve ter ao menos 3 caracteres.";
  $_SESSION["form_dados"] = $_POST;
  header("Location: /paciente/editar/" . $_POST["id"] . "");
  exit;
}
if (empty($_POST["data-nascimento"])) {
  $_SESSION["mensagem-tipo"] = "negativo";
  $_SESSION["mensagem-conteudo"] = "<strong>Erro!: </strong>Faltou a data de nascimento.";
  $_SESSION["form_dados"] = $_POST;
  header("Location: /paciente/editar/" . $_POST["id"] . "");
  exit;
}
if (empty($_POST["sexo"])) {
  $_SESSION["mensagem-tipo"] = "negativo";
  $_SESSION["mensagem-conteudo"] = "<strong>Erro!: </strong> Faltou informar o sexo";
  $_SESSION["form_dados"] = $_POST;
  header("Location: /paciente/editar/" . $_POST["id"] . "");
  exit;
}
if (empty($_POST["fator-rh"])) {
  $_SESSION["mensagem-tipo"] = "negativo";
  $_SESSION["mensagem-conteudo"] = "<strong>Erro!: </strong> Faltou informar o Tipo Sanguíneo.";
  $_SESSION["form_dados"] = $_POST;
  header("Location: /paciente/editar/" . $_POST["id"] . "");
  exit;
}

$idCpf = idCpf($_POST["cpf"]);
$existeCpf = existeCpf($_POST["cpf"]);
// VERIFICA VALIDADE DE CAMPOS OPCIONAIS
if (!empty($_POST["cpf"])) {
  if (!validarCPF($_POST["cpf"])) {
    $_SESSION["mensagem-tipo"] = "neutro";
    $_SESSION["mensagem-conteudo"] = "CPF inválido!";
    $_SESSION["form_dados"] = $_POST;
    header("Location: /paciente/editar/" . $_POST["id"] . "");
    exit;
  }
  if ($existeCpf === true && $idCpf != $_POST["id"]) {
    $_SESSION["mensagem-tipo"] = "neutro";
    $_SESSION["mensagem-conteudo"] = "CPF já utilizado!";
    $_SESSION["form_dados"] = $_POST;
    header("Location: /paciente/editar/" . $_POST["id"] . "");
    exit;
  }
}
if (!empty($_POST["email"])) {
  if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    $_SESSION["mensagem-tipo"] = "neutro";
    $_SESSION["mensagem-conteudo"] = "Endereço de e-mail incorreto.";
    $_SESSION["form_dados"] = $_POST;
    header("Location: /paciente/editar/" . $_POST["id"] . "");
    exit;
  }
}
if (!empty($_POST["tel"])) {
  if (!validarTelefone($_POST["tel"])) {
    $_SESSION["mensagem-tipo"] = "neutro";
    $_SESSION["mensagem-conteudo"] = "Telefone incorreto.";
    $_SESSION["form_dados"] = $_POST;
    header("Location: /paciente/editar/" . $_POST["id"] . "");
    exit;
  }
}

$mysqli = require  "../../auth/database.php";

$sql = "UPDATE pacientes
        SET
          nome = ?,
          data_nascimento = ?,
          telefone = ?,
          email = ?,
          sexo = ?,
          cpf = ?,
          tipo_sanguineo = ?,
          alergias = ?,
          historico_medico = ?,
          observacoes = ?,
          ativo = ?
        WHERE id = ?
        ";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
  $_SESSION["mensagem-tipo"] = "negativo";
  $_SESSION["mensagem-conteudo"] = "<strong>Erro SQL: </strong>" . $mysqli->error;
  $_SESSION["form_dados"] = $_POST;
  header("Location: /paciente/editar/" . $_POST["id"] . "");
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
$id = $_POST["id"];

// Bind dos parâmetros
$stmt->bind_param(
  "ssssssssssii",  // Tipos dos dados
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
  $ativo,
  $id
);

if ($stmt->execute()) {
  unset($_SESSION["form_dados"]);
  $_SESSION["mensagem-tipo"] = "positivo";
  $_SESSION["mensagem-conteudo"] = "O cadastro de <strong>"
    . $_POST["nome"]
    . " </strong> foi atualizado com sucesso!";
  header("Location: /paciente/editar/" . $_POST["id"] . "");
  exit;
} else {
  $_SESSION["mensagem-tipo"] = "negativo";
  $_SESSION["mensagem-conteudo"] = "Erro ao atualizar o cadastro do paciente: " . $stmt->error;
  $_SESSION["form_dados"] = $_POST;
  header("Location: /paciente/editar/" . $_POST["id"] . "");
  exit;
}
