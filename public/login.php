<?php include __DIR__.'/../includes/header.php'; ?>
<h1>Entrar</h1>
<form class="card" method="post" action="/api/auth.php">
  <input type="hidden" name="action" value="login" />
  <label>E-mail <input class="input" type="email" name="email" required /></label>
  <label>Senha <input class="input" type="password" name="password" required /></label>
  <button class="btn btn-primary">Entrar</button>
</form>
<p class="small">Não tem conta? <a href="/public/register.php">Crie aqui</a>.</p>
<?php include __DIR__.'/../includes/footer.php'; ?>
