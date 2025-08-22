<?php include __DIR__.'/../includes/header.php'; ?>
<h1>Loja</h1>
<p>Compre itens e pacotes para evoluir mais rápido no servidor.</p>
<div class="grid">
<?php
$pdo = db();
$stmt = $pdo->query('SELECT id, name, description, price FROM products WHERE is_active=1 ORDER BY id DESC');
foreach ($stmt as $p): ?>
  <div class="card">
    <h3><?php echo htmlspecialchars($p['name']); ?></h3>
    <p><?php echo htmlspecialchars($p['description']); ?></p>
    <div class="price">R$ <?php echo number_format($p['price'],2,',','.'); ?></div>
    <div style="margin-top:8px">
      <label><input type="radio" name="payment_method" value="pix" checked /> PIX</label>
      <label><input type="radio" name="payment_method" value="paypal" /> PayPal</label>
    </div>
    <?php if(!empty($_SESSION['user'])): ?>
      <button class="btn btn-primary" data-buy="<?php echo (int)$p['id']; ?>">Comprar</button>
    <?php else: ?>
      <a class="btn btn-primary" href="/public/login.php">Entrar para Comprar</a>
    <?php endif; ?>
  </div>
<?php endforeach; ?>
</div>
<?php include __DIR__.'/../includes/footer.php'; ?>
