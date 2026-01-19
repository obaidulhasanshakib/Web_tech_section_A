<?php require __DIR__ . '/../../layouts/header.php'; ?>

<h2>Add Product</h2>

<form class="card form-stacked" method="post" action="/artisanal-tea/public/seller/products/create">
  <input type="hidden" name="csrf" value="<?= e(Csrf::token()) ?>">

  <div class="field">
    <label>Title</label>
    <input name="title" required>
  </div>

  <div class="field">
    <label>Category</label>
    <select name="category_id">
      <option value="0">None</option>
      <?php foreach($categories as $c): ?>
        <option value="<?= (int)$c['id'] ?>"><?= e($c['name']) ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="field">
    <label>Origin</label>
    <input name="origin" placeholder="e.g., Japan">
  </div>

  <div class="field">
    <label>Tea Type</label>
    <input name="tea_type" placeholder="e.g., Green">
  </div>

  <div class="field">
    <label>Price</label>
    <input name="price" type="number" step="0.01" required>
  </div>

  <div class="field">
    <label>Stock</label>
    <input name="stock" type="number" required>
  </div>

  <div class="field">
    <label>Description</label>
    <textarea name="description" rows="3"></textarea>
  </div>

  <button type="submit">Save</button>
</form>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
