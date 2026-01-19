<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>Tea Products</h2>

<div class="card form-stacked">
  <div class="field">
    <label>Search</label>
    <input id="q" placeholder="Search by title/origin/type...">
  </div>

  <div class="field">
    <label>Category</label>
    <select id="category_id">
      <option value="0">All</option>
      <?php foreach($categories as $c): ?>
        <option value="<?= (int)$c['id'] ?>"><?= e($c['name']) ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="field">
    <label>Min Price</label>
    <input id="min" type="number" step="0.01" placeholder="0">
  </div>

  <div class="field">
    <label>Max Price</label>
    <input id="max" type="number" step="0.01" placeholder="5000">
  </div>

  <button type="button" id="btnSearch">Apply Filter</button>
</div>

<div id="result" style="margin-top:16px;"></div>

<script src="../public/assets/js/products.js"></script>
<?php require __DIR__ . '/../layouts/footer.php'; ?>
