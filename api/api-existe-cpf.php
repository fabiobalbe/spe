<?php
require_once dirname(__DIR__) . '/auth/access_control.php';
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
    if ($result->num_rows > 0) {
      header("Content-Type: application/json");
      echo json_encode(["isValid" => true]);
    } else {
      header("Content-Type: application/json");
      echo json_encode(["isValid" => false]);
    }
    exit;
  } else {
    die("Erro SQL: " . $stmt->error);
  }
} else {
  die("ERRO DE API!");
}
