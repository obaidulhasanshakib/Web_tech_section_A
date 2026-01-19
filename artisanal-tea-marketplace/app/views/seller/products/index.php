<?php require __DIR__ . '/../../layouts/header.php'; ?>

<h2>My Products (Seller)</h2>

<p>
  <a href="/artisanal-tea/public/seller/products/create">+ Add New Product</a>
</p>

<?php if (empty($products)): ?>
  <div class="card">
    <p>No products yet.</p>
  </div>
<?php else: ?>
  <?php foreach ($products as $p): ?>
    <div class="card">
      <h3 style="margin:0 0 6px;"><?= e($p['title']) ?></h3>

      <p style="margin:0;">
        <b>Category:</b> <?= e($p['category']) ?> |
        <b>Price:</b> ৳<?= e($p['price']) ?> |
        <b>Stock:</b> <?= e($p['stock']) ?> |
        <b>Status:</b> <?= e($p['status']) ?>
      </p>

      <p style="margin-top:10px;">
        <a href="/artisanal-tea/public/seller/products/edit?id=<?= (int)$p['id'] ?>">Edit</a>

        <form method="post" action="/artisanal-tea/public/seller/products/delete" style="display:inline;">
          <input type="hidden" name="csrf" value="<?= e(Csrf::token()) ?>">
          <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
          <button class="danger" type="submit" style="padding:6px 10px;">Delete</button>
        </form>
      </p>
    </div>
  <?php endforeach; ?>
<?php endif; ?>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
