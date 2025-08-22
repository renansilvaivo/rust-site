<?php include __DIR__.'/../includes/header.php'; ?>
<section class="hero">
  <div class="card">
    <h1>Bem-vindo ao <span class="badge">RUST SERVER</span></h1>
    <p>Servidor otimizado, wipes semanais e comunidade ativa. Conecte-se e domine a ilha!</p>
    <div style="display:flex;gap:10px;flex-wrap:wrap">
      <a class="btn btn-primary" href="steam://connect/127.0.0.1:28015">Jogar Agora</a>
      <a class="btn" href="/public/store.php">Abrir Loja</a>
      <a class="btn" href="/public/vip.php">Pacotes VIP</a>
    </div>
    <p class="small">IP: 127.0.0.1:28015 | Próximo wipe: Sexta-feira</p>
  </div>
  <div class="card">
    <h2>Destaques</h2>
    <ul>
      <li>Fila prioritária para VIPs</li>
      <li>/kits balanceados e eventos semanais</li>
      <li>Proteção ativa contra cheaters</li>
    </ul>
  </div>
</section>

<section style="margin-top:20px">
  <h2>Mais Comprados</h2>
  <div class="grid">
  <?php
    $pdo = db();
    $stmt = $pdo->query('SELECT id, name, description, price FROM products WHERE is_active=1 ORDER BY price DESC LIMIT 4');
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
</section>
<?php include __DIR__.'/../includes/footer.php'; ?>
