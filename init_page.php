<?php
require 'db.php';
require 'common.php';
$texts = include 'texts.php';

$page_title = $texts["page_title"];
$page_subtitle = $texts['page_subtitle'];
$logged_in = false;
$user_id = 0;
$is_admin = false;

if (isset($_COOKIE['token']) || isset($_GET['token']))
{
    $token = "";
    if (isset($_COOKIE['token']))
        $token = $_COOKIE['token'];
    else
        $token = $_GET['token'];
  $user = dbGetUser($token);
  if ($user != null)
  {
    $logged_in = true;
    $user_id = $user->id;
    $is_admin = $user->admin;
  }
  else 
  {
    setcookie("token", "", time() - 3600);
  }
}
?>
