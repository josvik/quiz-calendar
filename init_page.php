<?php
require 'db.php';
require 'common.php';
$texts = include 'texts.php';

$page_title = $texts["page_title"];
$page_subtitle = $texts['page_subtitle'];
$logged_in = false;
$user_id = 0;
$is_admin = false;

$usage = R::dispense('usage');
$usage->time = time();
$usage->ipaddr = $_SERVER['REMOTE_ADDR'];
$usage->url = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$usage->post = json_encode($_POST);

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

    $usage->userid = $user->id;
    $usage->email = $user->email;
  }
  else 
  {
    setcookie("token", "", time() - 3600);
  }
}
if (!$is_admin)
    R::store($usage);
?>
