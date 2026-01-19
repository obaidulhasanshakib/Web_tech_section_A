<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>My Profile</h2>

<form class="card form-stacked" method="post" action="/artisanal-tea/public/profile/update">
  <input type="hidden" name="csrf" value="<?= e(Csrf::token()) ?>">

  <div class="field">
    <label>Name</label>
    <input name="name" value="<?= e($_SESSION['user']['name']) ?>" required>
  </div>

  <div class="field">
    <label>Email</label>
    <input name="email" type="email" value="<?= e($_SESSION['user']['email'] ?? '') ?>" required>
  </div>

  <button type="submit">Update Profile</button>
</form>

<p>
  <a href="/artisanal-tea/public/password">Change Password</a>
</p>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
