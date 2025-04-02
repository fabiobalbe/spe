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
<!-- Primeira linha: Título e botão voltar -->
<div class="row">
  <div class="col-12 d-flex">
    <h2>Detalhes do paciente:</h2>
    <div class="d-flex ms-auto">
      <a href="/paciente/editar/<?php echo htmlspecialchars($idPaciente); ?>" class="btn btn-outline-warning d-flex align-items-center">
        Editar
      </a>

      <a href="/pacientes" class="btn btn-outline-secondary d-flex align-items-center ms-2">
        Voltar
      </a>

    </div>
  </div>
</div>

<!-- Segunda Linha: Dados do paciente -->
<div class="row mt-3">

  <div class="col-6 d-flex">
    <div class="card w-100 d-flex">
      <div class="card-body">
        <div class="w100 d-flex align-items-center">
          <h4 class="mt-1">
            <?php echo htmlspecialchars($row['nome']);

            if ($row['ativo'] == true) {
              echo "<span class=\"badge text-bg-primary ms-2\">Ativo</span>";
            } else {

              echo "<span class=\"badge text-bg-secondary ms-2\">Arquivado</span>";
            }
            ?>
          </h4>
        </div>
        </br>
        <p>
          <strong>
            <small class="text-body-secondary">Idade: </small>
          </strong>
          <?php echo calcularIdade(htmlspecialchars($row['data_nascimento'])) . " anos."; ?>
        </p>

        <p>
          <strong>
            <small class="text-body-secondary">Sexo: </small>
          </strong>
          <?php echo htmlspecialchars($row['sexo']); ?>
        </p>

        <p>
          <strong>
            <small class="text-body-secondary">Típo sanguíneo: </small>
          </strong>
          <?php echo htmlspecialchars($row['tipo_sanguineo']); ?>
        </p>

        <p>
          <strong>
            <small class="text-body-secondary">CPF: </small>
          </strong>
          <?php echo htmlspecialchars($row['cpf']); ?>
        </p>

      </div>
    </div>
  </div>

  <div class="col-6 d-flex">
    <div class="card w-100 d-flex">
      <div class="card-body">

        <h4>
          Informações de contato:
        </h4>
        </br>

        <p>
          <strong>
            <small class="text-body-secondary">Telefone: </small>
          </strong>
          <a href="http://wa.me/<?php echo htmlspecialchars($row['telefone']); ?>">
            <?php echo htmlspecialchars($row['telefone']); ?>
          </a>
        </p>

        <p>
          <strong>
            <small class="text-body-secondary">E-mail: </small>
          </strong>
          <a href="mailto:<?php echo htmlspecialchars($row['email']); ?>">
            <?php echo htmlspecialchars($row['email']); ?>
          </a>
        </p>

      </div>
    </div>
  </div>
</div>


<!-- Terceira Linha: Dados médicos do paciente -->
<div class="row mt-3">

  <div class="col-12 d-flex">
    <div class="card w-100 d-flex">
      <div class="card-body">

        <h4>
          Informações médicas:
        </h4>
        </br>

        <strong>
          <small class="text-body-secondary">Alergias: </small>
        </strong>
        </br>
        <?php echo htmlspecialchars($row['alergias']); ?>
        </p>

        <p>
          <strong>
            <small class="text-body-secondary">Observações: </small>
          </strong>
          </br>
          <?php echo htmlspecialchars($row['observacoes']); ?>
        </p>

        <p>
          <strong>
            <small class="text-body-secondary">Histórico médico: </small>
          </strong>
          </br>
          <?php echo htmlspecialchars($row['historico_medico']); ?>
        </p>

      </div>
    </div>
  </div>
</div>
