<?php
require_once __DIR__ . '/../config/config.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Rust Server - Loja & VIP</title>
  <link rel="stylesheet" href="/assets/css/style.css" />
</head>
<body>
<header class="site-header">
  <div class="container">
    <a href="/public/index.php" class="logo">RUST<span>SERVER</span></a>
    <nav>
      <a href="/public/index.php">Home</a>
      <a href="/public/store.php">Loja</a>
      <a href="/public/vip.php">VIP</a>
      <a href="/public/donate.php">Doar</a>
      <?php if (!empty($_SESSION['user'])): ?>
        <a href="/public/dashboard.php">Painel</a>
        <?php if ($_SESSION['user']['role'] === 'admin'): ?>
          <a href="/public/admin/index.php">Admin</a>
        <?php endif; ?>
        <a href="/public/logout.php">Sair</a>
      <?php else: ?>
        <a href="/public/login.php">Entrar</a>
        <a class="btn btn-primary" href="/public/register.php">Criar conta</a>
      <?php endif; ?>
    </nav>
  </div>
</header>
<main class="container">
