<?php
class ProductController {

  // Server-rendered Products page (with Add to Cart form support)
  public function index(){
    $products = Database::query("
      SELECT p.*, c.name AS category, u.name AS seller_name
      FROM products p
      LEFT JOIN categories c ON c.id = p.category_id
      JOIN users u ON u.id = p.seller_id
      WHERE p.status='active'
      ORDER BY p.id DESC
    ")->fetchAll();

    view('products/list', ['products' => $products]);
  }

  // Ajax/JSON endpoint (keep for requirement)
  public function apiList(){
    header('Content-Type: application/json; charset=utf-8');

    $q = trim($_GET['q'] ?? '');
    $cat = (int)($_GET['category_id'] ?? 0);
    $min = $_GET['min'] ?? '';
    $max = $_GET['max'] ?? '';

    $where = ["p.status='active'"];
    $params = [];

    if ($q !== '') {
      $where[] = "(p.title LIKE ? OR p.origin LIKE ? OR p.tea_type LIKE ?)";
      $params[] = "%$q%";
      $params[] = "%$q%";
      $params[] = "%$q%";
    }

    if ($cat > 0) {
      $where[] = "p.category_id = ?";
      $params[] = $cat;
    }

    if ($min !== '' && is_numeric($min)) {
      $where[] = "p.price >= ?";
      $params[] = $min;
    }

    if ($max !== '' && is_numeric($max)) {
      $where[] = "p.price <= ?";
      $params[] = $max;
    }

    $sql = "
      SELECT p.id,p.title,p.origin,p.tea_type,p.price,p.stock,
             c.name AS category,
             u.name AS seller_name
      FROM products p
      LEFT JOIN categories c ON c.id=p.category_id
      JOIN users u ON u.id=p.seller_id
      WHERE " . implode(" AND ", $where) . "
      ORDER BY p.id DESC
      LIMIT 50
    ";

    $rows = Database::query($sql, $params)->fetchAll();
    echo json_encode(['ok'=>true,'data'=>$rows]);
  }
}
