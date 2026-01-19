<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>Admin Dashboard</h2>

<div class="card">
  <p><b>Total Users:</b> <?= (int)$stats['users'] ?></p>
  <p><b>Total Sellers:</b> <?= (int)$stats['sellers'] ?> (Pending: <?= (int)$stats['pending'] ?>)</p>
  <p><b>Total Products:</b> <?= (int)$stats['products'] ?></p>
  <p><b>Total Orders:</b> <?= (int)$stats['orders'] ?></p>
  <p><b>Total Revenue:</b> ৳<?= number_format((float)$stats['revenue'], 2) ?></p>

  <p style="margin-top:10px;">
    <a href="/artisanal-tea/public/admin/users">Manage Users/Sellers</a> |
    <a href="/artisanal-tea/public/admin/categories">Manage Categories</a> |
    <a href="/artisanal-tea/public/admin/products">Manage Products</a> |
    <a href="/artisanal-tea/public/admin/reports">Reports</a>
  </p>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
