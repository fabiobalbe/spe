<?php
require_once DIR_ABS . '/spe/auth/access_control.php';
require_once DIR_ABS . '/spe/biblioteca/calcula-idade.php';

$mysqli = require_once DIR_ABS . "/spe/auth/database.php";

$sql = "SELECT * FROM pacientes WHERE id = ?";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
  die("Erro de conexão com o DB!");
}

$stmt->bind_param("i", $idPaciente);

$stmt->execute();

$result = $stmt->get_result();

$row = $result->fetch_assoc();

$stmt->close();

if (!$row) {
  echo "Paciente não encontrado";
  exit;
}

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

<span><?php echo htmlspecialchars($row['nome']); ?></span>
