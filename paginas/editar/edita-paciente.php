<?php
require_once '../../auth/verifica.php';
require_once "../../biblioteca/valida-cpf.php";
require_once "../../biblioteca/valida-telefone.php";
$mysqli = require  "../../auth/database.php";

//PASSA VARIAVEL POST PARA VÁRIAVEL MAIS FÁCIL DE COMPREENDER
$nome = htmlspecialchars($_POST["nome"] ?? "");
$data_nascimento = htmlspecialchars($_POST["data-nascimento"] ?? "");
$sexo = htmlspecialchars($_POST["sexo"] ?? "");
$tipo_sanguineo = htmlspecialchars($_POST["fator-rh"] ?? "");
$cpf = htmlspecialchars($_POST["cpf"] ?? "");
$email = htmlspecialchars($_POST["email"] ?? "");
$telefone = htmlspecialchars($_POST["tel"] ?? "");
$alergias = htmlspecialchars($_POST["alergias"] ?? "");
$observacoes = htmlspecialchars($_POST["obs"] ?? "");
$historico_medico = htmlspecialchars($_POST["historico"] ?? "");
$ativo = 1;
$id = htmlspecialchars($_POST["id"] ?? "");
$acao = htmlspecialchars($_POST["acao"] ?? "");

// VERIFICA CAMPOS OBRIGATÓRIOS
// ID
if (empty($id)) {
  $_SESSION["mensagem-tipo"] = "negativo";
  $_SESSION["mensagem-conteudo"] = "<strong>Erro!: </strong>Ocorreu um problema.";
  $_SESSION["form_dados"] = $_POST;
  header("Location: /paciente/editar/" . $id);
  exit;
}

//NOME
if (empty($nome)) {
  $_SESSION["mensagem-tipo"] = "negativo";
  $_SESSION["mensagem-conteudo"] = "<strong>Erro!: </strong>Nome deve ter ao menos 3 caracteres.";
  $_SESSION["form_dados"] = $_POST;
  header("Location: /paciente/editar/" . $id);
  exit;
}

//DATA DE NASCIMENTO
if (empty($data_nascimento)) {
  $_SESSION["mensagem-tipo"] = "negativo";
  $_SESSION["mensagem-conteudo"] = "<strong>Erro!: </strong>Faltou a data de nascimento.";
  $_SESSION["form_dados"] = $_POST;
  header("Location: /paciente/editar/" . $id);
  exit;
}

//SEXO
if (empty($sexo)) {
  $_SESSION["mensagem-tipo"] = "negativo";
  $_SESSION["mensagem-conteudo"] = "<strong>Erro!: </strong> Faltou informar o sexo";
  $_SESSION["form_dados"] = $_POST;
  header("Location: /paciente/editar/" . $id);
  exit;
}

//FATOR-RH
if (empty($tipo_sanguineo)) {
  $_SESSION["mensagem-tipo"] = "negativo";
  $_SESSION["mensagem-conteudo"] = "<strong>Erro!: </strong> Faltou informar o Tipo Sanguíneo.";
  $_SESSION["form_dados"] = $_POST;
  header("Location: /paciente/editar/" . $id);
  exit;
}

// VERIFICA VALIDADE DE CAMPOS OPCIONAIS
// CPF
if (!empty($cpf)) {
  $cpfValidator = new CPFValidator($mysqli);
  //CPF VALIDO?
  if (!$cpfValidator->validarCPF($cpf)) {
    $_SESSION["mensagem-tipo"] = "neutro";
    $_SESSION["mensagem-conteudo"] = "CPF inválido!";
    $_SESSION["form_dados"] = $_POST;
    header("Location: /paciente/editar/" . $id);
    exit;
  }
  // CPF EXISTE E NÃO PERTENCE AO ID?
  if ($cpfValidator->existeCpf($cpf) === true && $cpfValidator->idCpf($cpf) != $id) {
    $_SESSION["mensagem-tipo"] = "neutro";
    $_SESSION["mensagem-conteudo"] = "CPF já utilizado!";
    $_SESSION["form_dados"] = $_POST;
    header("Location: /paciente/editar/" . $id);
    exit;
  }
}

//EMAIL
if (!empty($email)) {
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION["mensagem-tipo"] = "neutro";
    $_SESSION["mensagem-conteudo"] = "Endereço de e-mail incorreto.";
    $_SESSION["form_dados"] = $_POST;
    header("Location: /paciente/editar/" . $id);
    exit;
  }
}

//TELEFONE
if (!empty($telefone)) {
  if (!validarTelefone($telefone)) {
    $_SESSION["mensagem-tipo"] = "neutro";
    $_SESSION["mensagem-conteudo"] = "Telefone incorreto.";
    $_SESSION["form_dados"] = $_POST;
    header("Location: /paciente/editar/" . $id);
    exit;
  }
}

switch ($acao) {
  case "salvar":
    
    //QUERY MYSQL
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

    //INICIA CONEXÃO
    $stmt = $mysqli->stmt_init();

    //PROBLEMA NA CONEXÃO?
    if (!$stmt->prepare($sql)) {
      $_SESSION["mensagem-tipo"] = "negativo";
      $_SESSION["mensagem-conteudo"] = "<strong>Erro SQL: </strong>" . $mysqli->error;
      $_SESSION["form_dados"] = $_POST;
      header("Location: /paciente/editar/" . $id);
      exit;
    }

    //BIND DE PARÂMETROS
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

    //EXECUTA QUERY COM SEGURANÇA
    if ($stmt->execute()) {
      //DEU CERTO?
      unset($_SESSION["form_dados"]);
      $_SESSION["mensagem-tipo"] = "positivo";
      $_SESSION["mensagem-conteudo"] = "O cadastro de <strong>"
        . $nome
        . " </strong> foi atualizado com sucesso!";
      header("Location: /paciente/editar/" . $id);
      // Fecha recursos
      $stmt->close();
      $mysqli->close();
      exit;
    } else {
      //DEU ERRADO?
      $_SESSION["mensagem-tipo"] = "negativo";
      $_SESSION["mensagem-conteudo"] = "Erro ao atualizar o cadastro do paciente: " . $stmt->error;
      $_SESSION["form_dados"] = $_POST;
      header("Location: /paciente/editar/" . $id);
      $stmt->close();
      $mysqli->close();
      exit;
    }
    break;

  case "arquivar":
    $ativo = 0;
    //QUERY MYSQL
    $sql = "UPDATE pacientes
            SET
              ativo = ?
            WHERE id = ?
            ";

    //INICIA CONEXÃO
    $stmt = $mysqli->stmt_init();

    //PROBLEMA NA CONEXÃO?
    if (!$stmt->prepare($sql)) {
      $_SESSION["mensagem-tipo"] = "negativo";
      $_SESSION["mensagem-conteudo"] = "<strong>Erro SQL: </strong>" . $mysqli->error;
      $_SESSION["form_dados"] = $_POST;
      header("Location: /paciente/editar/" . $id);
      exit;
    }

    //BIND DE PARÂMETROS
    $stmt->bind_param(
      "ii",  // Tipos dos dados
      $ativo,
      $id
    );

    //EXECUTA QUERY COM SEGURANÇA
    if ($stmt->execute()) {
      //DEU CERTO?
      unset($_SESSION["form_dados"]);
      $_SESSION["mensagem-tipo"] = "positivo";
      $_SESSION["mensagem-conteudo"] = "O arquivamento do cadastro de <strong>"
        . $nome
        . " </strong> foi realizado com sucesso!";
      header("Location: /pacientes");
      // Fecha recursos
      $stmt->close();
      $mysqli->close();
      exit;
    } else {
      //DEU ERRADO?
      $_SESSION["mensagem-tipo"] = "negativo";
      $_SESSION["mensagem-conteudo"] = "Erro ao arquivar o cadastro: " . $stmt->error;
      $_SESSION["form_dados"] = $_POST;
      header("Location: /paciente/editar/" . $id);
      $stmt->close();
      $mysqli->close();
      exit;
    }
    break;

  case "desarquivar":
    $ativo = 1;
    //QUERY MYSQL
    $sql = "UPDATE pacientes
            SET
              ativo = ?
            WHERE id = ?
            ";

    //INICIA CONEXÃO
    $stmt = $mysqli->stmt_init();

    //PROBLEMA NA CONEXÃO?
    if (!$stmt->prepare($sql)) {
      $_SESSION["mensagem-tipo"] = "negativo";
      $_SESSION["mensagem-conteudo"] = "<strong>Erro SQL: </strong>" . $mysqli->error;
      $_SESSION["form_dados"] = $_POST;
      header("Location: /paciente/editar/" . $id);
      exit;
    }

    //BIND DE PARÂMETROS
    $stmt->bind_param(
      "ii",  // Tipos dos dados
      $ativo,
      $id
    );

    //EXECUTA QUERY COM SEGURANÇA
    if ($stmt->execute()) {
      //DEU CERTO?
      unset($_SESSION["form_dados"]);
      $_SESSION["mensagem-tipo"] = "positivo";
      $_SESSION["mensagem-conteudo"] = "O desarquivamento do cadastro de <strong>"
        . $nome
        . " </strong> foi realizado com sucesso!";
      header("Location: /paciente/editar/" . $id);
      // Fecha recursos
      $stmt->close();
      $mysqli->close();
      exit;
    } else {
      //DEU ERRADO?
      $_SESSION["mensagem-tipo"] = "negativo";
      $_SESSION["mensagem-conteudo"] = "Erro ao desarquivar o cadastro: " . $stmt->error;
      $_SESSION["form_dados"] = $_POST;
      header("Location: /paciente/editar/" . $id);
      $stmt->close();
      $mysqli->close();
      exit;
    }
    break;

  case "excluir":
    //QUERY MYSQL
    $sql = "DELETE FROM pacientes
            WHERE id = ?
            ";

    //INICIA CONEXÃO
    $stmt = $mysqli->stmt_init();

    //PROBLEMA NA CONEXÃO?
    if (!$stmt->prepare($sql)) {
      $_SESSION["mensagem-tipo"] = "negativo";
      $_SESSION["mensagem-conteudo"] = "<strong>Erro SQL: </strong>" . $mysqli->error;
      $_SESSION["form_dados"] = $_POST;
      header("Location: /paciente/editar/" . $id);
      exit;
    }

    //BIND DE PARÂMETROS
    $stmt->bind_param(
      "i",  // Tipos dos dados
      $id
    );

    //EXECUTA QUERY COM SEGURANÇA
    if ($stmt->execute()) {
      //DEU CERTO?
      unset($_SESSION["form_dados"]);
      $_SESSION["mensagem-tipo"] = "neutro";
      $_SESSION["mensagem-conteudo"] = "<strong>". $nome .
        "</strong> foi excluído do cadastro de pacientes";
      header("Location: /pacientes");
      // Fecha recursos
      $stmt->close();
      $mysqli->close();
      exit;
    } else {
      //DEU ERRADO?
      $_SESSION["mensagem-tipo"] = "negativo";
      $_SESSION["mensagem-conteudo"] = "Erro ao excluir o cadastro: " . $stmt->error;
      $_SESSION["form_dados"] = $_POST;
      header("Location: /paciente/editar/" . $id);
      $stmt->close();
      $mysqli->close();
      exit;
    }
    break;
}

