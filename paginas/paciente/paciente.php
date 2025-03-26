<?php
require_once DIR_ABS . '/spe/auth/access_control.php';
require_once DIR_ABS . '/spe/biblioteca/calcula-idade.php';

$mysqli = require_once DIR_ABS . "/spe/auth/database.php";

$sql = "SELECT * FROM pacientes WHERE id = 1";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
  die("Erro de conexão com o DB!");
}

$stmt->execute();

$result = $stmt->get_result();

$stmt->close();

$row = $result->fetch_assoc();

?>
<!-- Título e botão cancelar -->
<div class="row">
  <div class="col-12 d-flex">
    <h2>Detalhes do paciente:</h2>

    <div class="d-flex ms-auto">
      <a href="/pacientes" class="btn btn-warning d-flex align-items-center">
Voltar
      </a>
    </div>

  </div>

</div>

<span><?php echo $row['nome']; ?></span>
