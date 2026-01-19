<?php
class OrderController {

  private function requireLogin(){
    if (empty($_SESSION['user'])) redirect('/artisanal-tea/public/login');
  }

  public function checkout(){
    $this->requireLogin();
    if (!Csrf::check($_POST['csrf'] ?? '')) die("CSRF failed!");

    $uid = (int)$_SESSION['user']['id'];

    $cart = Database::query("
      SELECT ci.product_id, ci.qty,
             p.title, p.price, p.stock, p.seller_id, p.status
      FROM cart_items ci
      JOIN products p ON p.id=ci.product_id
      WHERE ci.user_id=?
    ", [$uid])->fetchAll();

    if (empty($cart)){
      $_SESSION['flash'] = "Cart is empty!";
      redirect('/artisanal-tea/public/cart');
    }

    foreach($cart as $it){
      if ($it['status'] !== 'active'){
        $_SESSION['flash'] = "One item is not available anymore.";
        redirect('/artisanal-tea/public/cart');
      }
      if ((int)$it['qty'] > (int)$it['stock']){
        $_SESSION['flash'] = "Not enough stock for: ".$it['title'];
        redirect('/artisanal-tea/public/cart');
      }
    }

    // create order
    Database::query("INSERT INTO orders(user_id,status,total) VALUES(?, 'pending', 0)", [$uid]);
    $orderId = (int)Database::pdo()->lastInsertId();

    $total = 0;
    foreach($cart as $it){
      $qty = (int)$it['qty'];
      $price = (float)$it['price'];
      $line = $price * $qty;
      $total += $line;

      Database::query("
        INSERT INTO order_items(order_id, product_id, seller_id, title_snapshot, price_snapshot, qty, line_total)
        VALUES(?,?,?,?,?,?,?)
      ", [$orderId, (int)$it['product_id'], (int)$it['seller_id'], $it['title'], $price, $qty, $line]);

      // reduce stock
      Database::query("UPDATE products SET stock = stock - ? WHERE id=?", [$qty, (int)$it['product_id']]);
    }

    Database::query("UPDATE orders SET total=? WHERE id=?", [$total, $orderId]);

    // clear cart
    Database::query("DELETE FROM cart_items WHERE user_id=?", [$uid]);

    $_SESSION['flash'] = "Order placed! Order #".$orderId;
    redirect('/artisanal-tea/public/orders');
  }

  public function history(){
    $this->requireLogin();
    $uid = (int)$_SESSION['user']['id'];

    $orders = Database::query("
      SELECT * FROM orders WHERE user_id=? ORDER BY id DESC
    ", [$uid])->fetchAll();

    $items = Database::query("
      SELECT oi.*, o.user_id
      FROM order_items oi
      JOIN orders o ON o.id = oi.order_id
      WHERE o.user_id=?
      ORDER BY oi.id DESC
    ", [$uid])->fetchAll();

    view('orders/index', ['orders'=>$orders, 'items'=>$items]);
  }
}
