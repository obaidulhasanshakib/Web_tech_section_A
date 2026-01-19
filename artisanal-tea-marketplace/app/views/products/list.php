<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>Products</h2>

<?php if (empty($products)): ?>
  <div class="card">No products found.</div>
<?php else: ?>
  <?php foreach($products as $p): ?>
    <div class="card">
      <b><?= e($p['title']) ?></b>
      <div>
        Category: <?= e($p['category'] ?? '-') ?> |
        Type: <?= e($p['tea_type'] ?? '-') ?> |
        Origin: <?= e($p['origin'] ?? '-') ?>
      </div>
      <div>
        Seller: <?= e($p['seller_name']) ?> |
        Stock: <?= (int)$p['stock'] ?>
      </div>

      <div style="margin-top:8px;">
        <b>৳<?= e($p['price']) ?></b>
      </div>

      <?php if (!empty($_SESSION['user']) && (($_SESSION['user']['role'] ?? '') === 'customer')): ?>
        <form method="post" action="/artisanal-tea/public/cart/add"
              style="margin-top:10px;display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
          <input type="hidden" name="csrf" value="<?= e(Csrf::token()) ?>">
          <input type="hidden" name="product_id" value="<?= (int)$p['id'] ?>">
          <input type="number" name="qty" min="1" value="1" style="width:120px;">
          <button type="submit">Add to Cart</button>
        </form>
      <?php else: ?>
        <div style="margin-top:10px;">
          <span class="pill">Login as customer to buy</span>
        </div>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
<?php endif; ?>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
