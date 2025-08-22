<?php include __DIR__.'/../includes/header.php'; include __DIR__.'/../includes/auth_guard.php'; ?>
<h1>Meu Painel</h1>
<div class="grid">
  <div class="card">
    <h3>Minha Conta</h3>
    <p><strong>E-mail:</strong> <?php echo htmlspecialchars($_SESSION['user']['email']); ?></p>
    <p><strong>Nickname:</strong> <?php echo htmlspecialchars($_SESSION['user']['nickname'] ?? '—'); ?></p>
    <p><strong>Steam ID:</strong> <?php echo htmlspecialchars($_SESSION['user']['steam_id'] ?? '—'); ?></p>
    <p><strong>Saldo:</strong> R$ <?php echo number_format((float)$_SESSION['user']['balance'],2,',','.'); ?></p>
  </div>
  <div class="card">
    <h3>Minhas Compras</h3>
    <table class="table">
      <thead><tr><th>ID</th><th>Produto</th><th>Método</th><th>Status</th><th>Criado</th></tr></thead>
      <tbody>
      <?php
      $pdo = db();
      $stmt = $pdo->prepare('SELECT p.id, COALESCE(pr.name, CONCAT("Doação R$ ", p.custom_amount)) AS product_name, p.payment_method, p.status, p.created_at
                             FROM purchases p LEFT JOIN products pr ON pr.id=p.product_id
                             WHERE p.user_id=? ORDER BY p.id DESC');
      $stmt->execute([$_SESSION['user']['id']]);
      foreach ($stmt as $r): ?>
        <tr>
          <td><?php echo (int)$r['id']; ?></td>
          <td><?php echo htmlspecialchars($r['product_name']); ?></td>
          <td><span class="badge"><?php echo htmlspecialchars($r['payment_method']); ?></span></td>
          <td><span class="badge"><?php echo htmlspecialchars($r['status']); ?></span></td>
          <td><?php echo htmlspecialchars($r['created_at']); ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include __DIR__.'/../includes/footer.php'; ?>
