<?php require __DIR__ . '/../../layouts/header.php'; ?>

<h2>Edit Product</h2>

<form class="card form-stacked" method="post" action="/artisanal-tea/public/seller/products/edit?id=<?= (int)$product['id'] ?>">
  <input type="hidden" name="csrf" value="<?= e(Csrf::token()) ?>">

  <div class="field">
    <label>Title</label>
    <input name="title" value="<?= e($product['title']) ?>" required>
  </div>

  <div class="field">
    <label>Category</label>
    <select name="category_id">
      <option value="0">None</option>
      <?php foreach($categories as $c): ?>
        <option value="<?= (int)$c['id'] ?>" <?= ((int)$product['category_id'] === (int)$c['id']) ? 'selected' : '' ?>>
          <?= e($c['name']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="field">
    <label>Origin</label>
    <input name="origin" value="<?= e($product['origin'] ?? '') ?>">
  </div>

  <div class="field">
    <label>Tea Type</label>
    <input name="tea_type" value="<?= e($product['tea_type'] ?? '') ?>">
  </div>

  <div class="field">
    <label>Price</label>
    <input name="price" type="number" step="0.01" value="<?= e($product['price']) ?>" required>
  </div>

  <div class="field">
    <label>Stock</label>
    <input name="stock" type="number" value="<?= e($product['stock']) ?>" required>
  </div>

  <div class="field">
    <label>Status</label>
    <select name="status">
      <option value="active" <?= ($product['status']==='active')?'selected':'' ?>>Active</option>
      <option value="inactive" <?= ($product['status']==='inactive')?'selected':'' ?>>Inactive</option>
    </select>
  </div>

  <div class="field">
    <label>Description</label>
    <textarea name="description" rows="3"><?= e($product['description'] ?? '') ?></textarea>
  </div>

  <button type="submit">Update</button>
</form>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
