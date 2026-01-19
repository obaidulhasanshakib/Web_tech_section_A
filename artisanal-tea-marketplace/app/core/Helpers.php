<?php
function e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

function redirect($path){
  header("Location: {$path}");
  exit;
}

function view($path, $data = []){
  extract($data);
  require __DIR__ . "/../views/{$path}.php";
}
