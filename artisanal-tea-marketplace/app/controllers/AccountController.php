<?php
class AccountController {

  private function requireLogin(){
    if (empty($_SESSION['user'])) redirect('/artisanal-tea/public/login');
  }

  public function profile(){
    $this->requireLogin();
    view('account/profile');
  }

  public function updateProfile(){
    $this->requireLogin();
    if (!Csrf::check($_POST['csrf'] ?? '')) die("CSRF failed!");

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($name === '' || $email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $_SESSION['flash'] = "Invalid name/email!";
      redirect('/artisanal-tea/public/profile');
    }

    $uid = $_SESSION['user']['id'];

    // email already used by someone else?
    $exists = Database::query("SELECT id FROM users WHERE email=? AND id<>?", [$email, $uid])->fetch();
    if ($exists) {
      $_SESSION['flash'] = "This email is already used!";
      redirect('/artisanal-tea/public/profile');
    }

    Database::query("UPDATE users SET name=?, email=? WHERE id=?", [$name, $email, $uid]);

    // session update
    $_SESSION['user']['name'] = $name;
    $_SESSION['user']['email'] = $email;

    $_SESSION['flash'] = "Profile updated!";
    redirect('/artisanal-tea/public/profile');
  }

  public function passwordForm(){
    $this->requireLogin();
    view('account/password');
  }

  public function changePassword(){
    $this->requireLogin();
    if (!Csrf::check($_POST['csrf'] ?? '')) die("CSRF failed!");

    $current = $_POST['current_password'] ?? '';
    $new = $_POST['new_password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if (strlen($new) < 6) {
      $_SESSION['flash'] = "New password must be at least 6 characters!";
      redirect('/artisanal-tea/public/password');
    }
    if ($new !== $confirm) {
      $_SESSION['flash'] = "New password and confirm password mismatch!";
      redirect('/artisanal-tea/public/password');
    }

    $uid = $_SESSION['user']['id'];
    $user = Database::query("SELECT password_hash FROM users WHERE id=?", [$uid])->fetch();

    if (!$user || !password_verify($current, $user['password_hash'])) {
      $_SESSION['flash'] = "Current password wrong!";
      redirect('/artisanal-tea/public/password');
    }

    $hash = password_hash($new, PASSWORD_BCRYPT);
    Database::query("UPDATE users SET password_hash=? WHERE id=?", [$hash, $uid]);

    $_SESSION['flash'] = "Password changed successfully!";
    redirect('/artisanal-tea/public/password');
  }
}
