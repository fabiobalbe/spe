<?php
require_once DIR_ABS . '/spe/auth/access_control.php';

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
    <h2>Editar cadastro do paciente: <?php echo htmlspecialchars($row['nome']); ?></h2>
    <div class="d-flex ms-auto">
      <button type="button" class="btn btn-outline-danger" onclick="history.back()">Descartar</button>
    </div>
  </div>
</div>

<!-- Formulário -->
<script src="/paginas/editar/valida-edita-paciente.js" defer></script>
<div class="row">
  <div class="col-12 d-flex align-items-center mt-3">
    <form action="" method="POST" id="form-paciente" novalidate class="w-100">
      <?php
      function getFormData($campo, $default = '')
      {
        return isset($_SESSION['form_dados'][$campo]) ?
          htmlspecialchars($_SESSION['form_dados'][$campo]) : $default;
      }

      ?>
      <!-- Primeira Linha -->
      <div class="row g-2">
        <div class="col-6">
          <label for="nome">Nome</label>
          <input
            type="text"
            class="form-control"
            id="nome"
            name="nome"
            placeholder="Nome completo do paciente"
            value="<?php echo htmlspecialchars($row['nome']); ?>"
            required>
          <div class="invalid-feedback">
            O nome é obrigatório e deve ter pelo menos 3 caracteres.
          </div>
        </div>

        <div class="col-3">
          <label for="data-nascimento">Data de nascimento</label>
          <input
            type="date"
            class="form-control"
            id="data-nascimento"
            name="data-nascimento"
            value="<?php echo htmlspecialchars($row['data_nascimento']); ?>"
            required>
          <div class="invalid-feedback">
            Informe a data de nascimento.
          </div>
        </div>

        <div class="col-3">
          <label for="sexo">Sexo</label>
          <select id="sexo" class="form-select" name="sexo" required>
            <option value="" <?php echo htmlspecialchars($row['sexo']) === '' ? 'selected' : ''; ?>>Escolher sexo...</option>
            <option value="F" <?php echo htmlspecialchars($row['sexo'])  === 'F' ? 'selected' : ''; ?>>Feminino</option>
            <option value="M" <?php echo htmlspecialchars($row['sexo']) === 'M' ? 'selected' : ''; ?>>Masculino</option>
          </select>
          <div class="invalid-feedback">
            Selecione o sexo do paciente.
          </div>
        </div>

      </div>

      <!-- Segunda Linha -->
      <div class="row mt-1 g-2">
        <div class="col-3">
          <label for="fator-rh">Tipo sanguíneo</label>
          <select id="fator-rh" class="form-select" name="fator-rh" required>
            <option value="" <?php echo htmlspecialchars($row['tipo_sanguineo']) === '' ? 'selected' : ''; ?>>Escolher Fator RH...</option>
            <option value="A+" <?php echo htmlspecialchars($row['tipo_sanguineo']) === 'A+' ? 'selected' : ''; ?>>A+</option>
            <option value="A-" <?php echo htmlspecialchars($row['tipo_sanguineo']) === 'A-' ? 'selected' : ''; ?>>A-</option>
            <option value="B+" <?php echo htmlspecialchars($row['tipo_sanguineo']) === 'B+' ? 'selected' : ''; ?>>B+</option>
            <option value="B-" <?php echo htmlspecialchars($row['tipo_sanguineo']) === 'B-' ? 'selected' : ''; ?>>B-</option>
            <option value="AB+" <?php echo htmlspecialchars($row['tipo_sanguineo']) === 'AB+' ? 'selected' : ''; ?>>AB+</option>
            <option value="AB-" <?php echo htmlspecialchars($row['tipo_sanguineo']) === 'AB-' ? 'selected' : ''; ?>>AB-</option>
            <option value="O+" <?php echo htmlspecialchars($row['tipo_sanguineo']) === 'O+' ? 'selected' : ''; ?>>O+</option>
            <option value="O-" <?php echo htmlspecialchars($row['tipo_sanguineo']) === 'O-' ? 'selected' : ''; ?>>O-</option>
            <option value="Desconhecido" <?php echo htmlspecialchars($row['tipo_sanguineo']) === 'Desconhecido' ? 'selected' : ''; ?>>Desconhecido</option>
          </select>
          <div class="invalid-feedback">
            Selecione o fator RH.
          </div>
        </div>

        <div class="col-3">
          <label for="cpf">CPF</label>
          <input
            type="text"
            class="form-control"
            id="cpf"
            name="cpf"
            placeholder="000.000.000-00"
            value="<?php echo htmlspecialchars($row['cpf']); ; ?>">
          <div class="invalid-feedback">
            CPF inválido!
          </div>
        </div>
        <div class="col-3">
          <label for="email">E-Mail</label>
          <input
            type="email"
            class="form-control"
            id="email"
            name="email"
            placeholder="nome@provedor.com"
            value="<?php echo htmlspecialchars($row['email']); ?>">
          <div class="invalid-feedback">
            Email inválido!
          </div>
        </div>
        <div class="col-3">
          <label for="tel">Telefone</label>
          <input
            type="tel"
            class="form-control"
            id="tel"
            name="tel"
            placeholder="(31) 9-1111-0000"
            value="<?php echo  htmlspecialchars($row['telefone']); ?>">
          <div class="invalid-feedback">
            Telefone inválido!
          </div>
        </div>
      </div>

      <!-- Terceira Linha -->
      <div class="row mt-1 g-2">
        <div class="col-6">
          <label for="alergias">Alergias</label>
          <textarea
            class="form-control"
            id="alergias"
            name="alergias"
            rows="3"><?php echo htmlspecialchars($row['alergias']); ?></textarea>
        </div>
        <div class="col-6">
          <label for="obs">Observações</label>
          <textarea
            class="form-control"
            id="obs"
            name="obs"
            rows="3"><?php echo htmlspecialchars($row['observacoes']); ?></textarea>
        </div>
      </div>

      <!-- Quarta Linha -->
      <div class="row mt-1 g-2">
        <div class="col-12">
          <label for="historico">Histórico médico</label>
          <textarea
            class="form-control"
            id="historico"
            name="historico"
            rows="6"><?php echo htmlspecialchars($row['historico_medico']); ?></textarea>
        </div>
      </div>

      <!-- Botões -->
      <div class="row mt-5 g-2">
        <div class="col-6">
          <button type="submit" class="btn w-30 btn-outline-success">Salvar alterações</button>
          <button type="submit" class="btn w-30 btn-outline-warning">Arquivar cadastro</button>
          <button type="submit" class="btn w-30 btn-outline-danger">Excluir cadastro</button>
        </div>
      </div>

    </form>
  </div>
</div>
<script src="../../biblioteca/before-unload.js" defer></script>
