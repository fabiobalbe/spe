<?php
require_once dirname(__DIR__) . '/auth/access_control.php';
?>
<nav class="navbar navbar-expand-lg bg-light">
  <div class="container-fluid col-11">
    <a class="navbar-brand" href="/"><b><?php echo $nome_sistema ?></b></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" href="/">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/pacientes">Pacientes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/nova-consulta">Nova Consulta</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/historico">Histórico de Consultas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/auth/signup.php">Criar novo usuário</a>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
        <a class="nav-link logout fw-bold" href="<?php __DIR__ ?>/auth/logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
