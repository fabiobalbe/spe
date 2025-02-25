<?php
$host = "localhost";
$dbname = "teste01";
$dbusr = "root";
$dbpw = "";

$mysqli = new mysqli($host, $dbusr, $dbpw, $dbname);

if ($mysqli->connect_errno) {
  die("Erro de conexão com o Banco de Dados" . $mysqli->connect_error);
}

return $mysqli;
