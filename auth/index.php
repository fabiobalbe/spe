<?php require 'verifica.php'; ?>
<!DOCTYPE html>
<html>

<head>
  <title>Criar Usuário</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>

<body>
  <h1>Criar Usuário</h1>
  <form action="criar-usuario.php" method="POST" novalidate>
    <div>
      <label for="name">Nome</label>
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
      <button type="">Enviar</button>
    </div>
  </form>
</body>

</html>
