<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>Admin: Categories</h2>

<div class="card form-stacked">
  <form method="post" action="/artisanal-tea/public/admin/categories/create">
    <input type="hidden" name="csrf" value="<?= e(Csrf::token()) ?>">
    <div class="field">
      <label>New Category Name</label>
      <input name="name" required minlength="2" placeholder="e.g., Green Tea">
    </div>
    <button type="submit">Add Category</button>
  </form>
</div>

<?php foreach($cats as $c): ?>
  <div class="card" style="display:flex;justify-content:space-between;align-items:center;gap:10px;">
    <b><?= e($c['name']) ?></b>
    <form method="post" action="/artisanal-tea/public/admin/categories/delete" style="margin:0;">
      <input type="hidden" name="csrf" value="<?= e(Csrf::token()) ?>">
      <input type="hidden" name="id" value="<?= (int)$c['id'] ?>">
      <button class="danger" type="submit">Delete</button>
    </form>
  </div>
<?php endforeach; ?>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
