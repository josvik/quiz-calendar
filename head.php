<?php
require 'db.php';
require 'common.php';
$page_title = "Quiz-kalender";
$page_subtitle = "En julekalender med allsidige oppgaver";
$logged_in = false;
$user_id = 0;
$is_admin = false;
$not_logged_in_message = "<p>Du er ikke logget inn, bruk innloggingslenken du fikk i e-post. <br><a href=\"register.php\">Registrer bruker</a> hvis du ikke har gjort det enda.</p><p>Du kan registrere deg med samme e-post for å få tilsendt ny lenke.</p>";
if (isset($_COOKIE['token']))
{
  $user = dbGetUser($_COOKIE['token']);
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
<!DOCTYPE html>
<html lang="nb">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $page_subtitle; ?>">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="layout/pure/pure-min.css">
    <link rel="stylesheet" href="layout/pure/grids-responsive-min.css">
    <link rel="stylesheet" href="layout/pure/side-menu-styles.css">
    <link rel="stylesheet" href="layout/style.css?v=0.42">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
  </head>
<body>
  <div id="layout">