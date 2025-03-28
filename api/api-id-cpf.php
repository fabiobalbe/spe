<?php
require_once dirname(__DIR__) . '/auth/verifica.php';
require_once dirname(__DIR__) . "/auth/database.php";

if (isset($_GET["cpf"])) {
  $cpf = $_GET["cpf"];

  $sql = "SELECT * FROM pacientes WHERE cpf = ?";

  $stmt = $mysqli->stmt_init();

  if (!$stmt->prepare($sql)) {
    die("Erro SQL: " . $mysqli->error);
  }

  $stmt->bind_param(
    "s",
    $cpf
  );

  if ($stmt->execute()) {
    $result = $stmt->get_result();

    $row = $result->fetch_assoc();

    header("Content-Type: application/json");
    echo json_encode(["id" => $row["id"]]);
    exit;
  } else {
    die("Erro SQL: " . $stmt->error);
  }
} else {
  die("ERRO DE API!");
}
