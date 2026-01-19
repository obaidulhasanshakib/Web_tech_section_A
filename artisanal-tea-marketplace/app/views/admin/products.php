<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>Admin: Products</h2>

<?php foreach($rows as $p): ?>
  <div class="card">
    <b><?= e($p['title']) ?></b>
    <div>Seller: <?= e($p['seller_name']) ?> | Category: <?= e($p['category'] ?? '-') ?></div>
    <div>Price: ৳<?= e($p['price']) ?> | Stock: <?= (int)$p['stock'] ?> | Status: <b><?= e($p['status']) ?></b></div>

    <form method="post" action="/artisanal-tea/public/admin/products/remove" style="margin-top:10px;">
      <input type="hidden" name="csrf" value="<?= e(Csrf::token()) ?>">
      <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
      <button class="danger" type="submit">Remove (Inactive)</button>
    </form>
  </div>
<?php endforeach; ?>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
