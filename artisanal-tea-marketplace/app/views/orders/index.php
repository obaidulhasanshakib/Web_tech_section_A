<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>My Orders</h2>

<?php if (empty($orders)): ?>
  <div class="card">No orders yet.</div>
<?php else: ?>
  <?php foreach($orders as $o): ?>
    <div class="card">
      <b>Order #<?= (int)$o['id'] ?></b>
      <div>Status: <b><?= e($o['status']) ?></b> | Total: ৳<?= e($o['total']) ?> | Date: <?= e($o['created_at']) ?></div>

      <div style="margin-top:10px;">
        <b>Items:</b>
        <ul style="margin:8px 0 0; padding-left:18px;">
          <?php foreach($items as $it): ?>
            <?php if ((int)$it['order_id'] === (int)$o['id']): ?>
              <li><?= e($it['title_snapshot']) ?> — ৳<?= e($it['price_snapshot']) ?> × <?= (int)$it['qty'] ?> = ৳<?= e($it['line_total']) ?></li>
              <form method="post" action="/artisanal-tea/public/reviews/create" style="margin-top:6px;">
  <input type="hidden" name="csrf" value="<?= e(Csrf::token()) ?>">
  <input type="hidden" name="product_id" value="<?= (int)$it['product_id'] ?>">

  <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
    <select name="rating" style="width:140px;">
      <option value="5">5 ⭐</option>
      <option value="4">4 ⭐</option>
      <option value="3">3 ⭐</option>
      <option value="2">2 ⭐</option>
      <option value="1">1 ⭐</option>
    </select>

    <input type="text" name="comment" placeholder="Write short review..." style="flex:1; min-width:220px;">
    <button type="submit">Submit Review</button>
  </div>
</form>

            <?php endif; ?>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  <?php endforeach; ?>
<?php endif; ?>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
