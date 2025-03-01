<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

  $mysqli = require __DIR__ . "/database.php";

  $sql = sprintf(
    "SELECT * FROM users WHERE email = '%s'",
    $mysqli->real_escape_string($_POST['email'])
  );

  $result = $mysqli->query($sql);

  $user = $result->fetch_assoc();

  if ($user) {
    if (password_verify($_POST["senha"], $user["senha_hash"])) {

      session_start();

      session_regenerate_id();

      $_SESSION["user_id"] = $user["id"];
      $_SESSION["user_name"] = $user["name"];
      $_SESSION["mensagem-tipo"] = "positivo";
      $_SESSION["mensagem-conteudo"] = "Tudo certo no login!";
      header("Location: ../index.php");
      exit;
    }
  }
  $is_invalid = true;
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Login</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>

<body>
  <h1>Login</h1>

  <?php if ($is_invalid): ?>
    <em>Login Inválido</em>
  <?php endif ?>

  <form method="POST">
    <label for="email">E-Mail</label>
    <input type="email" name="email" id="email" value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">

    <label for="senha">Senha</label>
    <input type="password" name="senha" id="senha">

    <button>Login</button>
  </form>
</body>

</html>
