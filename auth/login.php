<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {

  $mysqli = require __DIR__ . "/database.php";

  $sql = sprintf(
    "SELECT * FROM users WHERE email = '%s'",
    $mysqli->real_escape_string($_POST['email'])
  );

  $result = $mysqli->query($sql);

  $user = $result->fetch_assoc();

  var_dump($user);
  exit;
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
  <form method="POST">
    <label for="email">E-Mail</label>
    <input type="email" name="email" id="email">

    <label for="senha">Senha</label>
    <input type="password" name="senha" id="senha">

    <button>Login</button>
  </form>
</body>

</html>
