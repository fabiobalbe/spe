<?php
require_once dirname(__DIR__) . "/auth/verifica.php";
require_once dirname(__DIR__) . "/auth/database.php";
require_once dirname(__DIR__) . "/biblioteca/valida-cpf.php";
$mysqli = require dirname(__DIR__) . "/auth/database.php";

if (isset($_GET["cpf"])) {
  $cpf = $_GET["cpf"];
  $cpfValidator = new CPFValidator($mysqli);
  header("Content-Type: application/json");
  echo json_encode(["id" => $cpfValidator->idCpf($cpf)]);

 } else {
  die("Erro!");
}
