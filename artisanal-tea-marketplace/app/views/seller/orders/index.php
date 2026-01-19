<?php require __DIR__ . '/../../layouts/header.php'; ?>

<h2>Seller Orders</h2>

<?php if (empty($rows)): ?>
  <div class="card">No orders yet.</div>
<?php else: ?>
  <?php foreach($rows as $r): ?>
    <div class="card">
      <b>Order #<?= (int)$r['order_id'] ?></b>
      <div>Customer: <?= e($r['customer_name']) ?> | Status: <b><?= e($r['status']) ?></b> | Date: <?= e($r['created_at']) ?></div>
      <div><?= e($r['title_snapshot']) ?> — ৳<?= e($r['price_snapshot']) ?> × <?= (int)$r['qty'] ?> = ৳<?= e($r['line_total']) ?></div>

      <form method="post" action="/artisanal-tea/public/seller/orders/status" style="margin-top:10px; display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
        <input type="hidden" name="csrf" value="<?= e(Csrf::token()) ?>">
        <input type="hidden" name="order_id" value="<?= (int)$r['order_id'] ?>">

        <select name="status" style="width:220px;">
          <option value="pending"   <?= ($r['status']==='pending')?'selected':'' ?>>pending</option>
          <option value="shipped"   <?= ($r['status']==='shipped')?'selected':'' ?>>shipped</option>
          <option value="delivered" <?= ($r['status']==='delivered')?'selected':'' ?>>delivered</option>
          <option value="cancelled" <?= ($r['status']==='cancelled')?'selected':'' ?>>cancelled</option>
        </select>

        <button type="submit">Update Status</button>
      </form>
    </div>
  <?php endforeach; ?>
<?php endif; ?>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
