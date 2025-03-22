<?php
require_once dirname(__DIR__) . '/auth/access_control.php';

function validarTelefone($numero)
{
  // Remove qualquer caractere que não seja número
  $numero = preg_replace('/\D/', '', $numero);

  // Expressão regular para validar telefone fixo (8 dígitos) ou celular (9 dígitos, começando com 9)
  if (preg_match('/^\d{2}(\d{8}|\d{9})$/', $numero)) {
    return true; // Número válido
  }

  return false; // Número inválido
}
