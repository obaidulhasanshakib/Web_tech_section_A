<?php
class ReviewController {

  private function requireLogin(){
    if (empty($_SESSION['user'])) redirect('/artisanal-tea/public/login');
  }

  // Customer review submit
  public function create(){
    $this->requireLogin();
    if (!Csrf::check($_POST['csrf'] ?? '')) die("CSRF failed!");

    $uid = (int)$_SESSION['user']['id'];
    $pid = (int)($_POST['product_id'] ?? 0);
    $rating = (int)($_POST['rating'] ?? 0);
    $comment = trim($_POST['comment'] ?? '');

    if ($rating < 1 || $rating > 5){
      $_SESSION['flash'] = "Rating must be 1 to 5";
      redirect('/artisanal-tea/public/orders');
    }

    // must have purchased this product
    $purchased = Database::query("
      SELECT 1
      FROM order_items oi
      JOIN orders o ON o.id = oi.order_id
      WHERE o.user_id=? AND oi.product_id=?
      LIMIT 1
    ", [$uid, $pid])->fetch();

    if (!$purchased){
      $_SESSION['flash'] = "You can review only purchased products!";
      redirect('/artisanal-tea/public/orders');
    }

    // insert or update review (unique user+product)
    $existing = Database::query("SELECT id FROM reviews WHERE user_id=? AND product_id=?", [$uid,$pid])->fetch();

    if ($existing){
      Database::query("UPDATE reviews SET rating=?, comment=? WHERE id=?", [$rating, $comment, (int)$existing['id']]);
      $_SESSION['flash'] = "Review updated!";
    } else {
      Database::query("INSERT INTO reviews(user_id, product_id, rating, comment) VALUES(?,?,?,?)",
        [$uid,$pid,$rating,$comment]
      );
      $_SESSION['flash'] = "Review submitted!";
    }

    redirect('/artisanal-tea/public/orders');
  }

  public function myReviews(){
    $this->requireLogin();
    $uid = (int)$_SESSION['user']['id'];

    $rows = Database::query("
      SELECT r.*, p.title
      FROM reviews r
      JOIN products p ON p.id=r.product_id
      WHERE r.user_id=?
      ORDER BY r.id DESC
    ", [$uid])->fetchAll();

    view('reviews/my', ['rows'=>$rows]);
  }
}
