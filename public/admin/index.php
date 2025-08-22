<?php include __DIR__.'/../../includes/header.php'; include __DIR__.'/../../includes/auth_guard.php';
if ($_SESSION['user']['role'] !== 'admin') { http_response_code(403); echo '<div class="card">Acesso negado.</div>'; include __DIR__.'/../../includes/footer.php'; exit; }
?>
<h1>Admin</h1>
<div class="grid">
  <div class="card">
    <h3>Novo Produto</h3>
    <form method="post" action="/api/admin.php">
      <input type="hidden" name="action" value="create_product" />
      <label>Nome <input class="input" name="name" required /></label>
      <label>Slug <input class="input" name="slug" required /></label>
      <label>Categoria
        <select class="input" name="category_slug">
          <?php
          $pdo = db();
          foreach ($pdo->query('SELECT slug, name FROM categories') as $c) {
            echo '<option value="'.htmlspecialchars($c['slug']).'">'.htmlspecialchars($c['name']).'</option>';
          }
          ?>
        </select>
      </label>
      <label>Descrição <textarea class="input" name="description"></textarea></label>
      <label>Preço <input class="input" type="number" step="0.01" name="price" required /></label>
      <button class="btn btn-primary">Criar</button>
    </form>
  </div>
  <div class="card">
    <h3>Logs Recentes</h3>
    <table class="table">
      <thead><tr><th>Quando</th><th>Usuário</th><th>Ação</th><th>Meta</th></tr></thead><tbody>
      <?php
      $pdo = db();
      $q = $pdo->query('SELECT l.created_at, u.email, l.action, l.meta FROM logs l LEFT JOIN users u ON u.id=l.user_id ORDER BY l.id DESC LIMIT 50');
      foreach ($q as $row) {
        echo '<tr><td>'.htmlspecialchars($row['created_at']).'</td><td>'.htmlspecialchars($row['email']??'—').'</td><td>'.htmlspecialchars($row['action']).'</td><td class="small">'.htmlspecialchars($row['meta']??'').'</td></tr>';
      }
      ?>
      </tbody></table>
  </div>
</div>
<?php include __DIR__.'/../../includes/footer.php'; ?>
