<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>Register</h2>

<div class="card form-stacked">
  <form method="post" action="/artisanal-tea/public/register">
    <input type="hidden" name="csrf" value="<?= e(Csrf::token()) ?>">

    <div class="field">
      <label>Name</label>
      <input name="name" required>
    </div>

    <div class="field">
      <label>Email</label>
      <input name="email" type="email" required>
    </div>

    <div class="field">
      <label>Password</label>
      <input name="password" type="password" required>
    </div>

    <div class="field">
      <label>Role</label>
      <select name="role">
        <option value="customer">Customer</option>
        <option value="seller">Tea Seller</option>
      </select>
    </div>

    <button type="submit">Create Account</button>
  </form>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
