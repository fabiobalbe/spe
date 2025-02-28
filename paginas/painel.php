<?php include_once dirname(__DIR__) . '/auth/access_control.php'; ?>

<span>Bem vindo <?= $_SESSION["user_name"] ?></span>
<div class="container text-center" style="height: 100%;">
  <div class="row align-items-center" style="height: 100%;">
    <div class="col d-flex align-items-center justify-content-center p-3 rounded-2 bg-warning text-white h-25 shadow">
      <h1>Pacientes</h1>
    </div>
    <div class="col d-flex align-items-center justify-content-center p-3 ms-3 me-3 rounded-2 bg-success text-white h-25 shadow">
      <h1>Nova Consulta</h1>
    </div>
    <div class="col d-flex align-items-center justify-content-center p-3 bg-dark rounded-2 text-white h-25 shadow">
      <h1>Histórico de Atendimento</h1>
    </div>
  </div>
</div>
