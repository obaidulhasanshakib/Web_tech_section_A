<?php
class User {
  public static function findByEmail($email){
    return Database::query("SELECT * FROM users WHERE email = ?", [$email])->fetch();
  }

  public static function create($role, $name, $email, $password){
    $exists = self::findByEmail($email);
    if ($exists) return false;

    $hash = password_hash($password, PASSWORD_BCRYPT);

    $sellerStatus = null;
    if ($role === 'seller') $sellerStatus = 'pending';

    Database::query(
      "INSERT INTO users(role,name,email,password_hash,seller_status) VALUES (?,?,?,?,?)",
      [$role,$name,$email,$hash,$sellerStatus]
    );

    return true;
  }
}
