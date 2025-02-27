<?php

session_start();
require 'auth/verifica.php';

$nome_pagina = "Inicio";
require 'config.php';

include_once 'topo.php';
?>

</head>

<body class="bg-success">

  <?php include_once 'barra-nav.php'; ?>

  <div class="container col-11 bg-light text-dark mx-auto p-3 mt-4 rounded-2 shadow altura-85">
    <div class="container text-center" style="height: 100%;">
      <div class="row align-items-center" style="height: 100%;">
        <h1>Bem vindo <?= $_SESSION["user_id"] ?></h1>
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

  </div>
</body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>
