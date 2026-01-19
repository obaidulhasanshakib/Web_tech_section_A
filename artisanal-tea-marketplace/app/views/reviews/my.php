<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>My Reviews</h2>

<?php if (empty($rows)): ?>
  <div class="card">No reviews yet.</div>
<?php else: ?>
  <?php foreach($rows as $r): ?>
    <div class="card">
      <b><?= e($r['title']) ?></b>
      <div>Rating: <b><?= (int)$r['rating'] ?>/5</b></div>
      <div><?= nl2br(e($r['comment'] ?? '')) ?></div>
      <div style="margin-top:8px;" class="pill"><?= e($r['created_at']) ?></div>
    </div>
  <?php endforeach; ?>
<?php endif; ?>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
