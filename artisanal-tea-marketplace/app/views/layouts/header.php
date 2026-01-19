<!doctype html>
<html>
<head>
  <meta charset="utf-8"/>
  <title>Artisanal Tea Marketplace</title>
  <link rel="stylesheet" href="/artisanal-tea/public/assets/css/style.css">
</head>
<body>

<header class="topbar">
  <div class="topbar-inner">
    <div class="brand">Artisanal Tea</div>

    <nav class="navlinks">
      <a href="/artisanal-tea/public/">Home</a>
      <a href="/artisanal-tea/public/products">Products</a>

      <?php if (!empty($_SESSION['user'])): ?>
        <a href="/artisanal-tea/public/cart">Cart</a>
        <a href="/artisanal-tea/public/orders">Orders</a>

        <a href="/artisanal-tea/public/dashboard">Dashboard</a>
        <a href="/artisanal-tea/public/profile">Profile</a>
        <a href="/artisanal-tea/public/password">Password</a>

        <?php if (($_SESSION['user']['role'] ?? '') === 'seller'): ?>
          <a href="/artisanal-tea/public/seller/products">Seller</a>
          <a href="/artisanal-tea/public/seller/orders">Seller Orders</a>
        <?php endif; ?>

        <?php if (($_SESSION['user']['role'] ?? '') === 'admin'): ?>
          <a href="/artisanal-tea/public/admin">Admin</a>
        <?php endif; ?>

        <form method="post" action="/artisanal-tea/public/logout" class="inline-form">
          <input type="hidden" name="csrf" value="<?= e(Csrf::token()) ?>">
          <button type="submit" class="btn-ghost">Logout</button>
        </form>
      <?php else: ?>
        <a href="/artisanal-tea/public/login">Login</a>
        <a href="/artisanal-tea/public/register">Register</a>
      <?php endif; ?>
    </nav>
  </div>
</header>

<main class="container">

<?php if (!empty($_SESSION['flash'])): ?>
  <div class="flash">
    <?= e($_SESSION['flash']); unset($_SESSION['flash']); ?>
  </div>
<?php endif; ?>
