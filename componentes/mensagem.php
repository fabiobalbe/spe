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
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-circle-fill me-3" viewBox="0 0 15 17">
      <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
    </svg>
    <?php echo $_SESSION["mensagem-conteudo"]; ?>
    <button type=" button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
</div>
<script>
  setTimeout(function() {
    var alerta = document.querySelector('.alert.alert-dismissible');
    if (alerta) {
      var bsAlert = new bootstrap.Alert(alerta);
      bsAlert.close();
    }
  }, 5000);
</script>
