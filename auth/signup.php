<?php
require_once dirname(__DIR__) . '/auth/verifica.php';
?>
<!DOCTYPE html>
<html>

<head>
  <title>Criar Usuário</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
  <script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js" defer></script>
  <script src="/auth/js/valida-form-index.js" defer></script>
</head>

<body>
  <h1>Criar Usuário</h1>
  <form action="/auth/criar-usuario.php" method="POST" id="signup" novalidate>
    <div>
      <label for="nome">Nome</label>
      <input type="text" id="nome" name="nome">
    </div>
    <div>
      <label for="email">E-Mail</label>
      <input type="email" id="email" name="email">
    </div>
    <div>
      <label for="senha">Senha</label>
      <input type="password" id="senha" name="senha">
    </div>
    <div>
      <label for="confirmar-senha">Confirmar Senha</label>
      <input type="password" id="confirmar-senha" name="confirmar-senha">
    </div>
    <div>
      <button type="submit">Enviar</button>
    </div>
  </form>
</body>

</html>
