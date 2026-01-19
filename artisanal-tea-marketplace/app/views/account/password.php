<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>Change Password</h2>

<form class="card form-stacked" method="post" action="/artisanal-tea/public/password/change" id="passForm">
  <input type="hidden" name="csrf" value="<?= e(Csrf::token()) ?>">

  <div class="field">
    <label>Current Password</label>
    <input name="current_password" type="password" required>
  </div>

  <div class="field">
    <label>New Password</label>
    <input name="new_password" type="password" minlength="6" required>
  </div>

  <div class="field">
    <label>Confirm New Password</label>
    <input name="confirm_password" type="password" minlength="6" required>
  </div>

  <button type="submit">Change Password</button>
</form>

<script src="/artisanal-tea/public/assets/js/app.js"></script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
