<?php
define('ACCESS_ALLOWED', true);
require 'auth/verifica.php';

$nome_pagina = "Inicio";
require 'config.php';

include_once __DIR__ . '/componentes/topo.php';
?>

</head>

<body class="bg-success">

  <?php include_once __DIR__ . '/componentes/barra-nav.php'; ?>

  <div class="container col-11 bg-light text-dark mx-auto p-3 mt-4 rounded-2 shadow altura-85">

    <?php include_once __DIR__ . '/paginas/painel.php'; ?>

  </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</html>
