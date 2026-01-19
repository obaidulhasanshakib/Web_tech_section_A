<?php
class Database {
  private static ?PDO $pdo = null;

  // connection getter
  public static function pdo(): PDO {
    if (self::$pdo instanceof PDO) {
      return self::$pdo;
    }

    $config = require __DIR__ . '/../config/config.php';
    $db = $config['db'];

    $dsn = "mysql:host={$db['host']};dbname={$db['name']};charset={$db['charset']}";

    self::$pdo = new PDO($dsn, $db['user'], $db['pass'], [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    return self::$pdo;
  }

  // run query
  public static function query(string $sql, array $params = []) {
    $stmt = self::pdo()->prepare($sql);
    $stmt->execute($params);
    return $stmt;
  }
}
