<?php
require_once dirname(__DIR__) . "/biblioteca/valida-telefone.php";

if (isset($_GET["tel"])) {
  $tel = $_GET["tel"];
  header("Content-Type: application/json");
  echo json_encode(["isValid" => validarTelefone($tel)]);

 } else {
  die("Erro!");
}
