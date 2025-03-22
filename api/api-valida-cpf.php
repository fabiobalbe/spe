<?php
require_once dirname(__DIR__) . '/auth/access_control.php';
require_once dirname(__DIR__) . "/biblioteca/valida-cpf.php";

if (isset($_GET["cpf"])) {
  $cpf = $_GET["cpf"];
  header("Content-Type: application/json");
  echo json_encode(["isValid" => validarCPF($cpf)]);

 } else {
  die("Erro!");
}
