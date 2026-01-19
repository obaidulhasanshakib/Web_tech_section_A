<?php
class DashboardController {
  public function index(){
    if (empty($_SESSION['user'])) {
      redirect('/artisanal-tea/public/login');
    }
    view('dashboard/index');
  }
}
