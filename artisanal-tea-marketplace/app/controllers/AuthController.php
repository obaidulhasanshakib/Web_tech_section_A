<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {

  public function registerForm(){
    view('auth/register');
  }

  public function register(){
    if (!Csrf::check($_POST['csrf'] ?? '')) die("CSRF failed!");

    $role = $_POST['role'] ?? 'customer';
    if (!in_array($role, ['customer','seller'], true)) $role = 'customer';

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($name === '' || $email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
      $_SESSION['flash'] = "Invalid input!";
      redirect('/artisanal-tea/public/register');
    }

    $ok = User::create($role, $name, $email, $password);

    if (!$ok) {
      $_SESSION['flash'] = "Email already exists!";
      redirect('/artisanal-tea/public/register');
    }

    $_SESSION['flash'] = "Registration successful! Now login.";
    redirect('/artisanal-tea/public/login');
  }

  public function loginForm(){
    view('auth/login');
  }

  public function login(){
    if (!Csrf::check($_POST['csrf'] ?? '')) die("CSRF failed!");

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $user = User::findByEmail($email);

    if (!$user || !password_verify($password, $user['password_hash'])) {
      $_SESSION['flash'] = "Wrong email or password!";
      redirect('/artisanal-tea/public/login');
    }

    if ($user['status'] === 'blocked') {
      $_SESSION['flash'] = "Your account is blocked!";
      redirect('/artisanal-tea/public/login');
    }

    if ($user['role'] === 'seller' && $user['seller_status'] !== 'approved') {
      $_SESSION['flash'] = "Seller account pending approval!";
      redirect('/artisanal-tea/public/login');
    }

    unset($user['password_hash']);
    $_SESSION['user'] = $user;

    redirect('/artisanal-tea/public/dashboard');
  }

  public function logout(){
    if (!Csrf::check($_POST['csrf'] ?? '')) die("CSRF failed!");
    session_destroy();
    redirect('/artisanal-tea/public/login');
  }
}
