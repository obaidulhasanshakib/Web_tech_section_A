<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>Admin: Users & Sellers</h2>

<?php foreach($rows as $u): ?>
  <div class="card">
    <b><?= e($u['name']) ?></b> (<?= e($u['email']) ?>)
    <div>Role: <b><?= e($u['role']) ?></b> | Status: <b><?= e($u['status']) ?></b>
      <?php if ($u['role'] === 'seller'): ?>
        | Seller: <b><?= e($u['seller_status'] ?? 'pending') ?></b>
      <?php endif; ?>
    </div>

    <?php if ($u['role'] === 'seller'): ?>
      <div style="margin-top:10px; display:flex; gap:10px; flex-wrap:wrap;">
        <form method="post" action="/artisanal-tea/public/admin/seller/status" style="margin:0;">
          <input type="hidden" name="csrf" value="<?= e(Csrf::token()) ?>">
          <input type="hidden" name="id" value="<?= (int)$u['id'] ?>">
          <input type="hidden" name="action" value="approve">
          <button type="submit">Approve</button>
        </form>

        <form method="post" action="/artisanal-tea/public/admin/seller/status" style="margin:0;">
          <input type="hidden" name="csrf" value="<?= e(Csrf::token()) ?>">
          <input type="hidden" name="id" value="<?= (int)$u['id'] ?>">
          <input type="hidden" name="action" value="reject">
          <button class="secondary" type="submit">Reject</button>
        </form>

        <?php if ($u['status'] === 'active'): ?>
          <form method="post" action="/artisanal-tea/public/admin/seller/status" style="margin:0;">
            <input type="hidden" name="csrf" value="<?= e(Csrf::token()) ?>">
            <input type="hidden" name="id" value="<?= (int)$u['id'] ?>">
            <input type="hidden" name="action" value="block">
            <button class="danger" type="submit">Block</button>
          </form>
        <?php else: ?>
          <form method="post" action="/artisanal-tea/public/admin/seller/status" style="margin:0;">
            <input type="hidden" name="csrf" value="<?= e(Csrf::token()) ?>">
            <input type="hidden" name="id" value="<?= (int)$u['id'] ?>">
            <input type="hidden" name="action" value="unblock">
            <button type="submit">Unblock</button>
          </form>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>
<?php endforeach; ?>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
