<?php

function validarCPF($cpf)
{
  // Remove caracteres não numéricos
  $cpf = preg_replace('/\D/', '', $cpf);

  // Verifica se tem 11 dígitos
  if (strlen($cpf) != 11) {
    return false;
  }

  // Elimina CPFs inválidos conhecidos
  if (preg_match('/^(.)\1{10}$/', $cpf)) {
    return false;
  }

  // Calcula e verifica os dígitos verificadores
  for ($t = 9; $t < 11; $t++) {
    $d = 0;
    for ($c = 0; $c < $t; $c++) {
      $d += $cpf[$c] * (($t + 1) - $c);
    }
    $d = ((10 * $d) % 11) % 10;
    if ($cpf[$t] != $d) {
      return false;
    }
  }

  return true;
}
