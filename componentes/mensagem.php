<?php

function getMensagemClasse()
{
  if (isset($_SESSION["mensagem-tipo"])) {
    if ($_SESSION["mensagem-tipo"] == "positivo") {
      return "alert-success";
    } elseif ($_SESSION["mensagem-tipo"] == "neutro") {
      return "alert-warning";
    } elseif ($_SESSION["mensagem-tipo"] == "negativo") {
      return "alert-danger";
    }
  }
  return ""; // Retorna vazio se não houver tipo definido ou sessão não existir
}
?>

<div class="container col-11">
  <div class="alert <?php echo getMensagemClasse(); ?> alert-dismissible fade show mt-4" role="alert">
    <?php echo $_SESSION["mensagem-conteudo"]; ?>
    <button type=" button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
</div>
