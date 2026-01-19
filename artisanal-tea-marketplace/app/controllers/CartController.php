<?php
class CartController {

  private function requireLogin(){
    if (empty($_SESSION['user'])) redirect('/artisanal-tea/public/login');
  }

  public function index(){
    $this->requireLogin();
    $uid = (int)$_SESSION['user']['id'];

    $items = Database::query("
      SELECT ci.product_id, ci.qty,
             p.title, p.price, p.stock,
             u.name AS seller_name
      FROM cart_items ci
      JOIN products p ON p.id = ci.product_id
      JOIN users u ON u.id = p.seller_id
      WHERE ci.user_id=?
      ORDER BY ci.id DESC
    ", [$uid])->fetchAll();

    $total = 0;
    foreach($items as $it){
      $total += ((float)$it['price']) * (int)$it['qty'];
    }

    view('cart/index', ['items'=>$items, 'total'=>$total]);
  }

  public function add(){
    $this->requireLogin();
    if (!Csrf::check($_POST['csrf'] ?? '')) die("CSRF failed!");

    $uid = (int)$_SESSION['user']['id'];
    $pid = (int)($_POST['product_id'] ?? 0);
    $qty = (int)($_POST['qty'] ?? 1);
    if ($qty < 1) $qty = 1;

    $p = Database::query("SELECT id, stock, status FROM products WHERE id=?", [$pid])->fetch();
    if (!$p || $p['status'] !== 'active') {
      $_SESSION['flash'] = "Product not available!";
      redirect('/artisanal-tea/public/products');
    }

    $existing = Database::query("SELECT id, qty FROM cart_items WHERE user_id=? AND product_id=?", [$uid,$pid])->fetch();
    if ($existing){
      $newQty = (int)$existing['qty'] + $qty;
      Database::query("UPDATE cart_items SET qty=? WHERE id=?", [$newQty, (int)$existing['id']]);
    } else {
      Database::query("INSERT INTO cart_items(user_id, product_id, qty) VALUES(?,?,?)", [$uid,$pid,$qty]);
    }

    $_SESSION['flash'] = "Added to cart!";
    redirect('/artisanal-tea/public/cart');
  }

  public function update(){
    $this->requireLogin();
    if (!Csrf::check($_POST['csrf'] ?? '')) die("CSRF failed!");

    $uid = (int)$_SESSION['user']['id'];
    $pid = (int)($_POST['product_id'] ?? 0);
    $qty = (int)($_POST['qty'] ?? 1);
    if ($qty < 1) $qty = 1;

    Database::query("UPDATE cart_items SET qty=? WHERE user_id=? AND product_id=?", [$qty,$uid,$pid]);

    $_SESSION['flash'] = "Cart updated!";
    redirect('/artisanal-tea/public/cart');
  }

  public function remove(){
    $this->requireLogin();
    if (!Csrf::check($_POST['csrf'] ?? '')) die("CSRF failed!");

    $uid = (int)$_SESSION['user']['id'];
    $pid = (int)($_POST['product_id'] ?? 0);

    Database::query("DELETE FROM cart_items WHERE user_id=? AND product_id=?", [$uid,$pid]);

    $_SESSION['flash'] = "Removed from cart!";
    redirect('/artisanal-tea/public/cart');
  }
}
