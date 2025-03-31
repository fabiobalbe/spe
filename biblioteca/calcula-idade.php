  <?php
  
// Controle de acesso de importação de componente.
require_once dirname(__DIR__) . '/auth/access_control.php';

function calcularIdade($dataNascimento)
  {
    // Cria um objeto DateTime com a data de nascimento
    $nascimento = new DateTime($dataNascimento);

    // Pega a data atual
    $hoje = new DateTime();

    // Calcula a diferença entre as datas
    $diferenca = $hoje->diff($nascimento);

    // Retorna a idade (em anos)
    return $diferenca->y;
  }
