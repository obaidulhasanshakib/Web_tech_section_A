<?php
class SellerOrderController {

  private function requireSeller(){
    if (empty($_SESSION['user'])) redirect('/artisanal-tea/public/login');
    if (($_SESSION['user']['role'] ?? '') !== 'seller'){
      $_SESSION['flash'] = "Only sellers can access.";
      redirect('/artisanal-tea/public/dashboard');
    }
  }

  public function index(){
    $this->requireSeller();
    $sid = (int)$_SESSION['user']['id'];

    $rows = Database::query("
      SELECT oi.order_id, oi.title_snapshot, oi.qty, oi.price_snapshot, oi.line_total,
             o.status, o.created_at,
             u.name AS customer_name
      FROM order_items oi
      JOIN orders o ON o.id = oi.order_id
      JOIN users u ON u.id = o.user_id
      WHERE oi.seller_id=?
      ORDER BY oi.order_id DESC, oi.id DESC
    ", [$sid])->fetchAll();

    view('seller/orders/index', ['rows'=>$rows]);
  }

  public function updateStatus(){
    $this->requireSeller();
    if (!Csrf::check($_POST['csrf'] ?? '')) die("CSRF failed!");

    $orderId = (int)($_POST['order_id'] ?? 0);
    $status = $_POST['status'] ?? 'pending';
    if (!in_array($status, ['pending','shipped','delivered','cancelled'], true)) $status='pending';

    $sid = (int)$_SESSION['user']['id'];
    $ok = Database::query("SELECT 1 FROM order_items WHERE order_id=? AND seller_id=? LIMIT 1", [$orderId,$sid])->fetch();
    if (!$ok){
      $_SESSION['flash'] = "Not allowed.";
      redirect('/artisanal-tea/public/seller/orders');
    }

    Database::query("UPDATE orders SET status=? WHERE id=?", [$status,$orderId]);

    $_SESSION['flash'] = "Order status updated!";
    redirect('/artisanal-tea/public/seller/orders');
  }
}
