<?php

function idCpf($cpf)
{
  $mysqli = require_once dirname(__DIR__) . "/auth/database.php";

  $sql = "SELECT id FROM pacientes WHERE cpf =" . $cpf;

  $stmt = $mysqli->stmt_init();

  if (!$stmt->prepare($sql)) {
    die("Erro de conexão com o DB!");
  }

  $stmt->execute();

  $result = $stmt->get_result();

  $row = $result->fetch_assoc();

  $stmt->close();

  return $row["id"];
}

//echo idCpf("03757441001");

