<?php include __DIR__.'/../includes/header.php'; ?>
<h1>Doação</h1>
<p>Apoie o servidor com um valor livre. Obrigado! ❤️</p>
<?php if(empty($_SESSION['user'])): ?>
  <div class="card"><p>Você precisa entrar para doar.</p><a class="btn btn-primary" href="/public/login.php">Entrar</a></div>
<?php else: ?>
  <form class="card" method="post" action="/api/purchase.php">
    <label>Valor (R$)
      <input class="input" type="number" step="0.01" min="1" name="custom_amount" required />
    </label>
    <label>Método de pagamento
      <select name="payment_method" class="input">
        <option value="pix">PIX</option>
        <option value="paypal">PayPal</option>
      </select>
    </label>
    <input type="hidden" name="product_id" value="">
    <button class="btn btn-primary" type="submit">Doar</button>
  </form>
<?php endif; ?>
<?php include __DIR__.'/../includes/footer.php'; ?>
