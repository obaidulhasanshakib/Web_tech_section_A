<?php
class AdminController {

  private function requireAdmin(){
    if (empty($_SESSION['user'])) redirect('/artisanal-tea/public/login');
    if (($_SESSION['user']['role'] ?? '') !== 'admin'){
      $_SESSION['flash'] = "Admin only!";
      redirect('/artisanal-tea/public/dashboard');
    }
  }

  public function dashboard(){
    $this->requireAdmin();

    $stats = [
      'users'   => (int)Database::query("SELECT COUNT(*) c FROM users")->fetch()['c'],
      'sellers' => (int)Database::query("SELECT COUNT(*) c FROM users WHERE role='seller'")->fetch()['c'],
      'pending' => (int)Database::query("SELECT COUNT(*) c FROM users WHERE role='seller' AND seller_status='pending'")->fetch()['c'],
      'products'=> (int)Database::query("SELECT COUNT(*) c FROM products")->fetch()['c'],
      'orders'  => (int)Database::query("SELECT COUNT(*) c FROM orders")->fetch()['c'],
      'revenue' => (float)Database::query("SELECT COALESCE(SUM(total),0) s FROM orders")->fetch()['s'],
    ];

    view('admin/dashboard', ['stats'=>$stats]);
  }

  public function users(){
    $this->requireAdmin();
    $rows = Database::query("SELECT id,role,name,email,status,seller_status,created_at FROM users ORDER BY id DESC")->fetchAll();
    view('admin/users', ['rows'=>$rows]);
  }

  public function sellerStatus(){
    $this->requireAdmin();
    if (!Csrf::check($_POST['csrf'] ?? '')) die("CSRF failed!");

    $id = (int)($_POST['id'] ?? 0);
    $action = $_POST['action'] ?? '';

    $u = Database::query("SELECT id,role FROM users WHERE id=?", [$id])->fetch();
    if (!$u || $u['role'] !== 'seller'){
      $_SESSION['flash'] = "Seller not found!";
      redirect('/artisanal-tea/public/admin/users');
    }

    if ($action === 'approve'){
      Database::query("UPDATE users SET seller_status='approved', status='active' WHERE id=?", [$id]);
      $_SESSION['flash'] = "Seller approved!";
    } elseif ($action === 'reject'){
      Database::query("UPDATE users SET seller_status='rejected' WHERE id=?", [$id]);
      $_SESSION['flash'] = "Seller rejected!";
    } elseif ($action === 'block'){
      Database::query("UPDATE users SET status='blocked' WHERE id=?", [$id]);
      $_SESSION['flash'] = "Seller blocked!";
    } elseif ($action === 'unblock'){
      Database::query("UPDATE users SET status='active' WHERE id=?", [$id]);
      $_SESSION['flash'] = "Seller unblocked!";
    } else {
      $_SESSION['flash'] = "Invalid action!";
    }

    redirect('/artisanal-tea/public/admin/users');
  }

  public function categories(){
    $this->requireAdmin();
    $cats = Database::query("SELECT id,name FROM categories ORDER BY name")->fetchAll();
    view('admin/categories', ['cats'=>$cats]);
  }

  public function createCategory(){
    $this->requireAdmin();
    if (!Csrf::check($_POST['csrf'] ?? '')) die("CSRF failed!");

    $name = trim($_POST['name'] ?? '');
    if ($name === '' || strlen($name) < 2){
      $_SESSION['flash'] = "Category name too short!";
      redirect('/artisanal-tea/public/admin/categories');
    }

    $exists = Database::query("SELECT id FROM categories WHERE name=?", [$name])->fetch();
    if ($exists){
      $_SESSION['flash'] = "Category already exists!";
      redirect('/artisanal-tea/public/admin/categories');
    }

    Database::query("INSERT INTO categories(name) VALUES(?)", [$name]);
    $_SESSION['flash'] = "Category created!";
    redirect('/artisanal-tea/public/admin/categories');
  }

  public function deleteCategory(){
    $this->requireAdmin();
    if (!Csrf::check($_POST['csrf'] ?? '')) die("CSRF failed!");

    $id = (int)($_POST['id'] ?? 0);
    // optional: prevent delete if products exist
    $has = Database::query("SELECT 1 FROM products WHERE category_id=? LIMIT 1", [$id])->fetch();
    if ($has){
      $_SESSION['flash'] = "Cannot delete: products exist in this category.";
      redirect('/artisanal-tea/public/admin/categories');
    }

    Database::query("DELETE FROM categories WHERE id=?", [$id]);
    $_SESSION['flash'] = "Category deleted!";
    redirect('/artisanal-tea/public/admin/categories');
  }

  public function products(){
    $this->requireAdmin();
    $rows = Database::query("
      SELECT p.id,p.title,p.price,p.stock,p.status,p.created_at,
             c.name AS category, u.name AS seller_name
      FROM products p
      LEFT JOIN categories c ON c.id=p.category_id
      JOIN users u ON u.id=p.seller_id
      ORDER BY p.id DESC
      LIMIT 200
    ")->fetchAll();

    view('admin/products', ['rows'=>$rows]);
  }

  public function removeProduct(){
    $this->requireAdmin();
    if (!Csrf::check($_POST['csrf'] ?? '')) die("CSRF failed!");

    $id = (int)($_POST['id'] ?? 0);
    // soft remove:
    Database::query("UPDATE products SET status='inactive' WHERE id=?", [$id]);
    $_SESSION['flash'] = "Product removed (inactive)!";
    redirect('/artisanal-tea/public/admin/products');
  }

  public function reports(){
    $this->requireAdmin();
    view('admin/reports');
  }

  // Ajax/JSON report endpoint
  public function reportsJson(){
    $this->requireAdmin();
    header('Content-Type: application/json; charset=utf-8');

    $orders = (int)Database::query("SELECT COUNT(*) c FROM orders")->fetch()['c'];
    $revenue = (float)Database::query("SELECT COALESCE(SUM(total),0) s FROM orders")->fetch()['s'];
    $top = Database::query("
      SELECT oi.seller_id, u.name AS seller_name, COALESCE(SUM(oi.line_total),0) revenue
      FROM order_items oi
      JOIN users u ON u.id=oi.seller_id
      GROUP BY oi.seller_id
      ORDER BY revenue DESC
      LIMIT 5
    ")->fetchAll();

    echo json_encode(['ok'=>true,'data'=>[
      'orders'=>$orders,
      'revenue'=>$revenue,
      'top_sellers'=>$top
    ]]);
  }
}
