<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>My Cart</h2>

<?php if (empty($items)): ?>
  <div class="card">Cart is empty. <a href="/artisanal-tea/public/products">Browse products</a></div>
<?php else: ?>
  <?php foreach($items as $it): ?>
    <div class="card">
      <b><?= e($it['title']) ?></b>
      <div>Seller: <?= e($it['seller_name']) ?> | Price: ৳<?= e($it['price']) ?> | Stock: <?= e($it['stock']) ?></div>

      <div style="margin-top:10px; display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
        <form method="post" action="/artisanal-tea/public/cart/update" style="display:flex; gap:10px; align-items:center; margin:0;">
          <input type="hidden" name="csrf" value="<?= e(Csrf::token()) ?>">
          <input type="hidden" name="product_id" value="<?= (int)$it['product_id'] ?>">
          <input name="qty" type="number" min="1" value="<?= (int)$it['qty'] ?>" style="width:120px;">
          <button type="submit">Update Qty</button>
        </form>

        <form method="post" action="/artisanal-tea/public/cart/remove" style="margin:0;">
          <input type="hidden" name="csrf" value="<?= e(Csrf::token()) ?>">
          <input type="hidden" name="product_id" value="<?= (int)$it['product_id'] ?>">
          <button class="danger" type="submit">Remove</button>
        </form>
      </div>
    </div>
  <?php endforeach; ?>

  <div class="card">
    <b>Total: ৳<?= number_format($total, 2) ?></b>

    <form method="post" action="/artisanal-tea/public/checkout" style="margin-top:12px;">
      <input type="hidden" name="csrf" value="<?= e(Csrf::token()) ?>">
      <button type="submit">Place Order</button>
    </form>
  </div>
<?php endif; ?>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
