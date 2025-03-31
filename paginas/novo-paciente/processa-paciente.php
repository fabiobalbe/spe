<?php
require_once '../../auth/verifica.php';
require_once "../../biblioteca/valida-cpf.php";
require_once "../../biblioteca/valida-telefone.php";
$mysqli = require  "../../auth/database.php";

// VERIFICA CAMPOS OBRIGATÓRIOS
//NOME
if (empty($_POST["nome"])) {
  $_SESSION["mensagem-tipo"] = "negativo";
  $_SESSION["mensagem-conteudo"] = "<strong>Erro!: </strong>Não foi possível cadastrar o paciente.";
  $_SESSION["form_dados"] = $_POST;
  header("Location: /pacientes/novo-paciente");
  exit;
}

//DATA DE NASCIMENTO
if (empty($_POST["data-nascimento"])) {
  $_SESSION["mensagem-tipo"] = "negativo";
  $_SESSION["mensagem-conteudo"] = "<strong>Erro!: </strong>Não foi possível cadastrar o paciente.";
  $_SESSION["form_dados"] = $_POST;
  header("Location: /pacientes/novo-paciente");
  exit;
}

//SEXO
if (empty($_POST["sexo"])) {
  $_SESSION["mensagem-tipo"] = "negativo";
  $_SESSION["mensagem-conteudo"] = "<strong>Erro!: </strong>Não foi possível cadastrar o paciente.";
  $_SESSION["form_dados"] = $_POST;
  header("Location: /pacientes/novo-paciente");
  exit;
}

//FATOR-RH
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

//EMAIL
if (!empty($_POST["email"])) {
  if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    $_SESSION["mensagem-tipo"] = "neutro";
    $_SESSION["mensagem-conteudo"] = "Endereço de e-mail incorreto.";
    $_SESSION["form_dados"] = $_POST;
    header("Location: /pacientes/novo-paciente");
    exit;
  }
}

//TELEFONE
if (!empty($_POST["tel"])) {
  if (!validarTelefone($_POST["tel"])) {
    $_SESSION["mensagem-tipo"] = "neutro";
    $_SESSION["mensagem-conteudo"] = "Telefone incorreto.";
    $_SESSION["form_dados"] = $_POST;
    header("Location: /pacientes/novo-paciente");
    exit;
  }
}

//QUERY MYSQL
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

//INICIA QUERY
$stmt = $mysqli->stmt_init();

//PROBLEMA NA QUERY?
if (!$stmt->prepare($sql)) {
  $_SESSION["mensagem-tipo"] = "negativo";
  $_SESSION["mensagem-conteudo"] = "<strong>Erro SQL: </strong>" . $mysqli->error;
  $_SESSION["form_dados"] = $_POST;
  header("Location: /pacientes/novo-paciente");
  exit;

}

//DÁ NOME MAIS SIMPLES PARA AS VARIÁVEIS _POST
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

//BIND DOS PARÂMETROS
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

//EXECUTA
if ($stmt->execute()) {
  unset($_SESSION["form_dados"]);
  $_SESSION["mensagem-tipo"] = "positivo";
  $_SESSION["mensagem-conteudo"] = "O paciente <strong>"
    . $_POST["nome"]
    . " </strong> foi cadastrado com sucesso!";
  header("Location: /pacientes");
  exit;
} else {
  // DEU ERRADO A EXECUÇÃO?
  $_SESSION["mensagem-tipo"] = "negativo";
  $_SESSION["mensagem-conteudo"] = "Erro ao cadastrar paciente: " . $stmt->error;
  $_SESSION["form_dados"] = $_POST;
  header("Location: /pacientes/novo-paciente");
  exit;
}
