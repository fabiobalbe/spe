<?php
require_once DIR_ABS . '/spe/auth/access_control.php';
?>
<!-- Título e botão cancelar -->
<div class="row">
  <div class="col-12 d-flex">
    <h2>Cadastro de novo paciente:</h2>
    <div class="d-flex ms-auto">
      <button type="button" class="btn btn-danger" onclick="history.back()">Cancelar</button>
    </div>
  </div>
</div>

<!-- Formulário -->
<script src="/paginas/novo-paciente/valida-form-paciente.js" defer></script>
<div class="row">
  <div class="col-12 d-flex align-items-center mt-3">
    <form action="/paginas/novo-paciente/processa-paciente.php" method="POST" id="form-paciente" novalidate class="w-100">
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
            value="<?php echo getFormData("nome"); ?>"
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
            value="<?php echo getFormData("data-nascimento"); ?>"
            required>
          <div class="invalid-feedback">
            Informe a data de nascimento.
          </div>
        </div>

        <div class="col-3">
          <label for="sexo">Sexo</label>
          <select id="sexo" class="form-select" name="sexo" required>
            <option value="" <?php echo getFormData('sexo') === '' ? 'selected' : ''; ?>>Escolher sexo...</option>
            <option value="F" <?php echo getFormData('sexo') === 'F' ? 'selected' : ''; ?>>Feminino</option>
            <option value="M" <?php echo getFormData('sexo') === 'M' ? 'selected' : ''; ?>>Masculino</option>
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
            <option value="" <?php echo getFormData('fator-rh') === '' ? 'selected' : ''; ?>>Escolher Fator RH...</option>
            <option value="A+" <?php echo getFormData('fator-rh') === 'A+' ? 'selected' : ''; ?>>A+</option>
            <option value="A-" <?php echo getFormData('fator-rh') === 'A-' ? 'selected' : ''; ?>>A-</option>
            <option value="B+" <?php echo getFormData('fator-rh') === 'B+' ? 'selected' : ''; ?>>B+</option>
            <option value="B-" <?php echo getFormData('fator-rh') === 'B-' ? 'selected' : ''; ?>>B-</option>
            <option value="AB+" <?php echo getFormData('fator-rh') === 'AB+' ? 'selected' : ''; ?>>AB+</option>
            <option value="AB-" <?php echo getFormData('fator-rh') === 'AB-' ? 'selected' : ''; ?>>AB-</option>
            <option value="O+" <?php echo getFormData('fator-rh') === 'O+' ? 'selected' : ''; ?>>O+</option>
            <option value="O-" <?php echo getFormData('fator-rh') === 'O-' ? 'selected' : ''; ?>>O-</option>
            <option value="Desconhecido" <?php echo getFormData('fator-rh') === 'Desconhecido' ? 'selected' : ''; ?>>Desconhecido</option>
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
            value="<?php echo getFormData('cpf'); ?>">
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
            value="<?php echo getFormData('email'); ?>">
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
            value="<?php echo getFormData('tel'); ?>">
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
            rows="3"><?php echo getFormData('alergias'); ?></textarea>
        </div>
        <div class="col-6">
          <label for="obs">Observações</label>
          <textarea 
           class="form-control" 
           id="obs" 
           name="obs" 
            rows="3"><?php echo getFormData('obs'); ?></textarea>
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
            rows="6"><?php echo getFormData('historico'); ?></textarea>
        </div>
      </div>

      <!-- Botão de Cadastro -->
      <div class="row mt-5 g-2">
        <div class="col-2">
          <button type="submit" class="btn w-100 btn-success">Cadastrar</button>
        </div>
      </div>

    </form>
  </div>
</div>
<script src="../biblioteca/before-unload.js" defer></script>
