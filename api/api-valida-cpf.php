<?php
require_once dirname(__DIR__) . '/auth/verifica.php';
require_once dirname(__DIR__) . "/biblioteca/valida-cpf.php";

if (isset($_GET["cpf"])) {
  $cpf = $_GET["cpf"];
  $cpfValidator = new CPFValidator();
  header("Content-Type: application/json");
  echo json_encode(["isValid" => $cpfValidator->validarCPF($cpf)]);

 } else {
  die("Erro!");
}
