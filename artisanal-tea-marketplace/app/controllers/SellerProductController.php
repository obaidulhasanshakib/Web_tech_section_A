<?php
class SellerProductController {

  private function requireSeller(){
    if (empty($_SESSION['user'])) redirect('/artisanal-tea/public/login');
    if (($_SESSION['user']['role'] ?? '') !== 'seller') {
      $_SESSION['flash'] = "Only sellers can access this page.";
      redirect('/artisanal-tea/public/dashboard');
    }
  }

  public function index(){
    $this->requireSeller();
    $sid = (int)$_SESSION['user']['id'];

    $rows = Database::query("
      SELECT p.*, c.name AS category
      FROM products p
      LEFT JOIN categories c ON c.id=p.category_id
      WHERE p.seller_id=?
      ORDER BY p.id DESC
    ", [$sid])->fetchAll();

    view('seller/products/index', ['products' => $rows]);
  }

  public function createForm(){
    $this->requireSeller();
    $cats = Database::query("SELECT id,name FROM categories ORDER BY name")->fetchAll();
    view('seller/products/create', ['categories'=>$cats]);
  }

  public function create(){
    $this->requireSeller();
    if (!Csrf::check($_POST['csrf'] ?? '')) die("CSRF failed!");

    $sid = (int)$_SESSION['user']['id'];
    $category_id = (int)($_POST['category_id'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    $origin = trim($_POST['origin'] ?? '');
    $tea_type = trim($_POST['tea_type'] ?? '');
    $price = $_POST['price'] ?? '';
    $stock = $_POST['stock'] ?? '';
    $desc = trim($_POST['description'] ?? '');

    if ($title === '' || !is_numeric($price) || !is_numeric($stock)) {
      $_SESSION['flash'] = "Invalid input! Title required, price/stock numeric.";
      redirect('/artisanal-tea/public/seller/products/create');
    }

    Database::query("
      INSERT INTO products (seller_id, category_id, title, origin, tea_type, price, stock, description, status)
      VALUES (?,?,?,?,?,?,?,?, 'active')
    ", [$sid, $category_id ?: null, $title, $origin ?: null, $tea_type ?: null, $price, (int)$stock, $desc ?: null]);

    $_SESSION['flash'] = "Product added!";
    redirect('/artisanal-tea/public/seller/products');
  }

  public function editForm(){
    $this->requireSeller();
    $sid = (int)$_SESSION['user']['id'];
    $id = (int)($_GET['id'] ?? 0);

    $p = Database::query("SELECT * FROM products WHERE id=? AND seller_id=?", [$id, $sid])->fetch();
    if (!$p) { $_SESSION['flash']="Product not found!"; redirect('/artisanal-tea/public/seller/products'); }

    $cats = Database::query("SELECT id,name FROM categories ORDER BY name")->fetchAll();
    view('seller/products/edit', ['product'=>$p, 'categories'=>$cats]);
  }

  public function update(){
    $this->requireSeller();
    if (!Csrf::check($_POST['csrf'] ?? '')) die("CSRF failed!");

    $sid = (int)$_SESSION['user']['id'];
    $id = (int)($_GET['id'] ?? 0);

    $category_id = (int)($_POST['category_id'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    $origin = trim($_POST['origin'] ?? '');
    $tea_type = trim($_POST['tea_type'] ?? '');
    $price = $_POST['price'] ?? '';
    $stock = $_POST['stock'] ?? '';
    $desc = trim($_POST['description'] ?? '');
    $status = $_POST['status'] ?? 'active';
    if (!in_array($status, ['active','inactive'], true)) $status = 'active';

    if ($title === '' || !is_numeric($price) || !is_numeric($stock)) {
      $_SESSION['flash'] = "Invalid input!";
      redirect('/artisanal-tea/public/seller/products/edit?id='.$id);
    }

    $ok = Database::query("SELECT id FROM products WHERE id=? AND seller_id=?", [$id, $sid])->fetch();
    if (!$ok) { $_SESSION['flash']="Not allowed."; redirect('/artisanal-tea/public/seller/products'); }

    Database::query("
      UPDATE products
      SET category_id=?, title=?, origin=?, tea_type=?, price=?, stock=?, description=?, status=?
      WHERE id=? AND seller_id=?
    ", [$category_id ?: null, $title, $origin ?: null, $tea_type ?: null, $price, (int)$stock, $desc ?: null, $status, $id, $sid]);

    $_SESSION['flash'] = "Product updated!";
    redirect('/artisanal-tea/public/seller/products');
  }

  public function delete(){
    $this->requireSeller();
    if (!Csrf::check($_POST['csrf'] ?? '')) die("CSRF failed!");

    $sid = (int)$_SESSION['user']['id'];
    $id = (int)($_GET['id'] ?? 0);

    Database::query("DELETE FROM products WHERE id=? AND seller_id=?", [$id, $sid]);

    $_SESSION['flash'] = "Product deleted!";
    redirect('/artisanal-tea/public/seller/products');
  }
}
