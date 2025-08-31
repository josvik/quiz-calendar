<?php
require 'init_page.php';

$joingroupval = "";
if (isset($_GET["joingroup"]))
    $joingroupval = "?joingroup=" . $_GET["joingroup"];
$not_logged_in_message = $texts['welcome_paragraph'] . $texts["info_time"] . $texts["info_good_luck"] . "
<br><br><hr>
<p>
For å delta i Quiz-kalenderen må du være innlogget.<br>
Vennligst bruk innloggingslenken du mottok på e-post for å få tilgang til dagens oppgaver.</p>

<p><b>Har du ikke registrert deg ennå?</b><br>
<a href=\"register.php". $joingroupval . "\">Opprett en bruker her</a> for å bli med på moroa!</p>

<p><b>Finner du ikke innloggingslenken?</b><br>
Ingen problem! <a href=\"register.php". $joingroupval . "\">Registrer deg på nytt med samme e-postadresse</a> for å få tilsendt en ny innloggingslenke.</p>";
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
    <link rel="stylesheet" href="layout/style.css?v=0.43">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
  </head>
<body>
  <div id="layout">