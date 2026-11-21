<?php
if (!isset($titulo)) { $titulo = 'LogiControl'; }
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($titulo) ?> | LogiControl</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="/logocontrol/assets/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand fw-bold" href="/logocontrol/index.php">🚚 LogiControl</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="menu">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="/logocontrol/index.php">Início</a></li>
        <li class="nav-item"><a class="nav-link" href="/logocontrol/produtos/index.php">Produtos</a></li>
        <li class="nav-item"><a class="nav-link" href="/logocontrol/enderecos/index.php">Endereços</a></li>
        <li class="nav-item"><a class="nav-link" href="/logocontrol/transportadores/index.php">Transportadores</a></li>
        <li class="nav-item"><a class="nav-link" href="/logocontrol/fretes/index.php">Fretes</a></li>
        <li class="nav-item"><a class="nav-link" href="/logocontrol/relatorios/index.php">Relatórios</a></li>
      </ul>
    </div>
  </div>
</nav>
<main class="container py-4">
