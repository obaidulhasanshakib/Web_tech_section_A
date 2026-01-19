<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>Login</h2>

<div class="card form-stacked">
  <form method="post" action="/artisanal-tea/public/login">
    <input type="hidden" name="csrf" value="<?= e(Csrf::token()) ?>">

    <div class="field">
      <label>Email</label>
      <input type="email" name="email" required>
    </div>

    <div class="field">
      <label>Password</label>
      <input type="password" name="password" required>
    </div>

    <button type="submit">Login</button>
  </form>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
