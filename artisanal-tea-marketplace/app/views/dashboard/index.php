<?php require __DIR__ . '/../layouts/header.php'; ?>

<h2>Dashboard</h2>

<?php
$user = $_SESSION['user'] ?? [];
$role = $user['role'] ?? 'customer';
$name = $user['name'] ?? 'User';
$email = $user['email'] ?? '';
$status = $user['status'] ?? 'active';

$uid = (int)($user['id'] ?? 0);

$orderCount = 0;
$cartCount = 0;
$reviewCount = 0;
$productCount = 0;
$sellerOrderCount = 0;
$pendingSellers = 0;

if ($uid > 0) {
  // Customer stats
  $orderCount = (int)Database::query("SELECT COUNT(*) c FROM orders WHERE user_id=?", [$uid])->fetch()['c'];
  $cartCount  = (int)Database::query("SELECT COALESCE(SUM(qty),0) c FROM cart_items WHERE user_id=?", [$uid])->fetch()['c'];
  $reviewCount = (int)Database::query("SELECT COUNT(*) c FROM reviews WHERE user_id=?", [$uid])->fetch()['c'];

  // Seller stats
  if ($role === 'seller') {
    $productCount = (int)Database::query("SELECT COUNT(*) c FROM products WHERE seller_id=?", [$uid])->fetch()['c'];
    $sellerOrderCount = (int)Database::query("SELECT COUNT(DISTINCT oi.order_id) c FROM order_items oi WHERE oi.seller_id=?", [$uid])->fetch()['c'];
  }

  // Admin stats
  if ($role === 'admin') {
    $pendingSellers = (int)Database::query("SELECT COUNT(*) c FROM users WHERE role='seller' AND seller_status='pending'")->fetch()['c'];
  }
}
?>

<div class="card">
  <h3 style="margin:0 0 6px;font-size:20px;">Hello, <?= e($name) ?> 👋</h3>
  <p style="margin:0;color:#374151;line-height:1.7;">
    Welcome back to <b>Artisanal Tea Marketplace</b>.
    Manage your account, orders, and activities from here.
  </p>

  <div style="margin-top:10px;display:flex;gap:10px;flex-wrap:wrap;">
    <a href="/artisanal-tea/public/products"><button type="button">Browse Products</button></a>
    <a href="/artisanal-tea/public/profile"><button type="button" class="secondary">Edit Profile</button></a>
    <a href="/artisanal-tea/public/password"><button type="button" class="secondary">Change Password</button></a>
  </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-top:12px;">
  <div class="card">
    <h3 style="margin:0 0 8px;font-size:18px;">Account Summary</h3>
    <p style="margin:0;color:#374151;line-height:1.8;">
      <b>Role:</b> <?= e($role) ?><br>
      <b>Email:</b> <?= e($email) ?><br>
      <b>Status:</b> <?= e($status) ?>
    </p>
    <div style="margin-top:10px;">
      <span class="pill">Secure Session</span>
      <span class="pill">CSRF Protected</span>
      <span class="pill">MVC Structure</span>
    </div>
  </div>

  <div class="card">
    <h3 style="margin:0 0 8px;font-size:18px;">Quick Links</h3>
    <p style="margin:0;color:#374151;line-height:2;">
      <a href="/artisanal-tea/public/cart">🛒 Cart</a><br>
      <a href="/artisanal-tea/public/orders">📦 My Orders</a><br>
      <a href="/artisanal-tea/public/reviews/my">⭐ My Reviews</a><br>
    </p>

    <?php if ($role === 'seller'): ?>
      <hr style="border:none;border-top:1px solid #eef2f7;margin:12px 0;">
      <p style="margin:0;color:#374151;line-height:2;">
        <a href="/artisanal-tea/public/seller/products">🧾 Seller Products</a><br>
        <a href="/artisanal-tea/public/seller/orders">🚚 Seller Orders</a><br>
      </p>
    <?php endif; ?>

    <?php if ($role === 'admin'): ?>
      <hr style="border:none;border-top:1px solid #eef2f7;margin:12px 0;">
      <p style="margin:0;color:#374151;line-height:2;">
        <a href="/artisanal-tea/public/admin">🛠 Admin Dashboard</a><br>
        <a href="/artisanal-tea/public/admin/users">👥 Manage Users</a><br>
        <a href="/artisanal-tea/public/admin/reports">📊 Reports</a><br>
      </p>
    <?php endif; ?>
  </div>
</div>

<div style="display:grid;grid-template-columns:repeat(3, 1fr);gap:12px;margin-top:12px;">
  <div class="card">
    <h3 style="margin:0 0 6px;font-size:16px;">Orders</h3>
    <p style="margin:0;font-size:26px;font-weight:800;"><?= (int)$orderCount ?></p>
    <p style="margin:6px 0 0;color:#6b7280;">Total orders placed</p>
  </div>

  <div class="card">
    <h3 style="margin:0 0 6px;font-size:16px;">Cart Items</h3>
    <p style="margin:0;font-size:26px;font-weight:800;"><?= (int)$cartCount ?></p>
    <p style="margin:6px 0 0;color:#6b7280;">Items currently in cart</p>
  </div>

  <div class="card">
    <h3 style="margin:0 0 6px;font-size:16px;">Reviews</h3>
    <p style="margin:0;font-size:26px;font-weight:800;"><?= (int)$reviewCount ?></p>
    <p style="margin:6px 0 0;color:#6b7280;">Reviews submitted</p>
  </div>
</div>

<?php if ($role === 'seller'): ?>
  <div style="display:grid;grid-template-columns:repeat(2, 1fr);gap:12px;margin-top:12px;">
    <div class="card">
      <h3 style="margin:0 0 6px;font-size:16px;">My Products</h3>
      <p style="margin:0;font-size:26px;font-weight:800;"><?= (int)$productCount ?></p>
      <p style="margin:6px 0 0;color:#6b7280;">Total product listings</p>
    </div>

    <div class="card">
      <h3 style="margin:0 0 6px;font-size:16px;">Seller Orders</h3>
      <p style="margin:0;font-size:26px;font-weight:800;"><?= (int)$sellerOrderCount ?></p>
      <p style="margin:6px 0 0;color:#6b7280;">Orders containing your products</p>
    </div>
  </div>
<?php endif; ?>

<?php if ($role === 'admin'): ?>
  <div class="card" style="margin-top:12px;">
    <h3 style="margin:0 0 8px;font-size:18px;">Admin Highlights</h3>
    <p style="margin:0;color:#374151;line-height:1.8;">
      <b>Pending sellers:</b> <?= (int)$pendingSellers ?><br>
      Review approvals to keep the marketplace trustworthy.
    </p>

    <div style="margin-top:10px;display:flex;gap:10px;flex-wrap:wrap;">
      <a href="/artisanal-tea/public/admin/users"><button type="button">Review Sellers</button></a>
      <a href="/artisanal-tea/public/admin/categories"><button type="button" class="secondary">Categories</button></a>
      <a href="/artisanal-tea/public/admin/reports"><button type="button" class="secondary">Reports</button></a>
    </div>
  </div>
<?php endif; ?>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
