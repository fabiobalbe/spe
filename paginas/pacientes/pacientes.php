<?php
require_once DIR_ABS . '/spe/auth/access_control.php';
require_once DIR_ABS . '/spe/biblioteca/calcula-idade.php';

$mysqli = require_once DIR_ABS . "/spe/auth/database.php";

$sql = "SELECT id, nome, data_nascimento, telefone FROM pacientes";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
  die("Erro de conexão com o DB!");
}

$stmt->execute();

$result = $stmt->get_result();

$stmt->close();

?>

<!-- Título e botão cancelar -->
<div class="row">
  <div class="col-12 d-flex">
    <h2>Lista de pacientes cadastrados:</h2>

    <div class="d-flex ms-auto">
      <a href="/pacientes/novo-paciente" class="btn btn-primary d-flex align-items-center">
        Cadastrar novo paciente
      </a>
    </div>

  </div>

</div>

<!-- Tabela -->
<div class="row mt-3 table-responsive link-underline-opacity-0">
  <div class="col-12 d-flex mx-auto">

    <table class="table table-striped table-hover rounded-2 overflow-hidden">

      <thead>
        <tr class="table-secondary">
          <th scope="col">Nome</th>
          <th scope="col">Idade</th>
          <th scope="col">Telefone</th>
          <th scope="col">Última consulta</th>
        </tr>
      </thead>
      <tbody>

        <?php
        // Itera sobre os resultados
        while ($row = $result->fetch_assoc()) {

        ?>

          <tr onclick="window.location.href='/paciente/<?php echo $row['id']; ?>';"
            style="cursor: pointer;">
            <td><?php echo $row['nome']; ?></td>
            <td><?php echo calcularIdade($row['data_nascimento']); ?></td>
            <td>
              <a class="link-success link-underline-opacity-100-hover"
                href="https://wa.me/<?php echo $row['telefone']; ?>"
                target="_blank">
                <?php echo $row['telefone']; ?>
              </a>
            </td>
            <td>29/02/2024</td>
          </tr>

        <?php
        }
        ?>

      </tbody>

    </table>

  </div>

</div>
