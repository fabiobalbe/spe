<?php
require_once DIR_ABS . '/spe/auth/access_control.php';

//HOME
$router->add("/", function () {
  include_once dirname(__DIR__) . '/spe/paginas/painel.php';
}, "Painel");


//PACIENTES
$router->add("/pacientes", function () {
  include_once dirname(__DIR__) . '/spe/paginas/pacientes/pacientes.php';
}, "Pacientes");


//NOVO PACIENTE
$router->add("/pacientes/novo-paciente", function () {
  include_once dirname(__DIR__) . '/spe/paginas/novo-paciente/form-novo-paciente.php';
}, "Cadastro de novo paciente");


//PÁGINA DO PACIENTE
$router->add("/paciente/:id", function ($id) {
  if (!ctype_digit($id) || $id <= 0) {
    header("HTTP/1.0 400 Bad Request");
    echo "ID do paciente deve ser um número inteiro positivo";
    exit;
  }
  $idPaciente = (int)$id; // Força conversão para inteiro
  include_once dirname(__DIR__) . '/spe/paginas/paciente/paciente.php';
}, "Página do paciente");


//EDITAR PACIENTE
$router->add("/paciente/editar/:id", function ($id) {
  if (!ctype_digit($id) || $id <= 0) {
    header("HTTP/1.0 400 Bad Request");
    echo "ID do paciente deve ser um número inteiro positivo";
    exit;
  }
  $idPaciente = (int)$id; // Força conversão para inteiro
  include_once dirname(__DIR__) . '/spe/paginas/editar/form-editar-paciente.php';
}, "Página de edição de paciente");


//NOVA CONSULTA
$router->add("/consultas/nova-consulta", function () {
  echo "Nova Consulta";
}, "Nova Consulta");


//HISTORICO DE ATENDIMENTO
$router->add("/historico", function () {
  echo "HISTÓRICO DE CONSULTAS";
}, "Historico de consultas");


//LOGOUT
$router->add("/logout", function () {
  include_once dirname(__DIR__) . "/spe/auth/logout.php";
});


//SIGNUP
$router->add("/signup", function () {
  header("Location: /auth/signup.php");
  exit();
});
