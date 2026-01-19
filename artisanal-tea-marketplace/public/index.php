<?php
session_set_cookie_params([
  'path' => '/',
  'httponly' => true,
  'samesite' => 'Lax'
]);
session_start();

require_once __DIR__ . '/../app/core/Database.php';
require_once __DIR__ . '/../app/core/Helpers.php';
require_once __DIR__ . '/../app/core/Router.php';
require_once __DIR__ . '/../app/core/Csrf.php';

$router = new Router();

// Home
$router->get('/', ['HomeController','index']);

// Register
$router->get('/register', ['AuthController','registerForm']);
$router->post('/register', ['AuthController','register']);

// Login
$router->get('/login', ['AuthController','loginForm']);
$router->post('/login', ['AuthController','login']);

// Dashboard
$router->get('/dashboard', ['DashboardController','index']);

// Products (Customer browse + API)
$router->get('/products', ['ProductController','index']);
$router->get('/api/products', ['ProductController','apiList']);

// Cart + Orders (Customer)
$router->get('/cart', ['CartController','index']);
$router->post('/cart/add', ['CartController','add']);
$router->post('/cart/update', ['CartController','update']);
$router->post('/cart/remove', ['CartController','remove']);

$router->post('/checkout', ['OrderController','checkout']);
$router->get('/orders', ['OrderController','history']);

// Reviews
$router->post('/reviews/create', ['ReviewController','create']);
$router->get('/reviews/my', ['ReviewController','myReviews']);

// Admin
$router->get('/admin', ['AdminController','dashboard']);
$router->get('/admin/users', ['AdminController','users']);
$router->post('/admin/seller/status', ['AdminController','sellerStatus']);

$router->get('/admin/categories', ['AdminController','categories']);
$router->post('/admin/categories/create', ['AdminController','createCategory']);
$router->post('/admin/categories/delete', ['AdminController','deleteCategory']);

$router->get('/admin/products', ['AdminController','products']);
$router->post('/admin/products/remove', ['AdminController','removeProduct']);

$router->get('/admin/reports', ['AdminController','reports']);
$router->get('/api/admin/reports', ['AdminController','reportsJson']); // Ajax/JSON

// Seller Product Management
$router->get('/seller/products', ['SellerProductController','index']);
$router->get('/seller/products/create', ['SellerProductController','createForm']);
$router->post('/seller/products/create', ['SellerProductController','create']);
$router->get('/seller/products/edit', ['SellerProductController','editForm']);
$router->post('/seller/products/edit', ['SellerProductController','update']);
$router->post('/seller/products/delete', ['SellerProductController','delete']);

// Seller Orders
$router->get('/seller/orders', ['SellerOrderController','index']);
$router->post('/seller/orders/status', ['SellerOrderController','updateStatus']);

// Account Management (Profile + Password)
$router->get('/profile', ['AccountController','profile']);
$router->post('/profile/update', ['AccountController','updateProfile']);

$router->get('/password', ['AccountController','passwordForm']);
$router->post('/password/change', ['AccountController','changePassword']);

// Logout
$router->post('/logout', ['AuthController','logout']);

$router->dispatch();
