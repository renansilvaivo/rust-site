<?php include __DIR__.'/../includes/header.php'; ?>
<h1>Criar conta</h1>
<form class="card" method="post" action="/api/auth.php">
  <input type="hidden" name="action" value="register" />
  <label>E-mail <input class="input" type="email" name="email" required /></label>
  <label>Senha <input class="input" type="password" name="password" required /></label>
  <label>Nickname no jogo (opcional) <input class="input" type="text" name="nickname" /></label>
  <label>Steam ID (opcional) <input class="input" type="text" name="steam_id" /></label>
  <button class="btn btn-primary">Criar</button>
</form>
<?php include __DIR__.'/../includes/footer.php'; ?>
