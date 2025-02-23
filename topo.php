<?php
function titulo($ns, $np)
{
  return $ns . ": " . $np;
}
?>

<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo titulo($nome_sistema, $nome_pagina) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-qwtkzyjppejisv5waru9oferpok6yctnymdr5pnlyt2brjxh0jmhjy6hw+alewih" crossorigin="anonymous">
  <link rel="stylesheet "href="style.css">
