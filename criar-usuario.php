<?php
if (empty($_POST["nome"])) {
  die("Faltou o nome!");
}
if (empty($_POST["email"])) {
  die("Faltou o email!");
}
if (empty($_POST["senha"])) {
  die("Faltou a senha!");
}
if (empty($_POST["confirmar-senha"])) {
  die("Faltou confirmar a senha!");
}
print_r($_POST);
