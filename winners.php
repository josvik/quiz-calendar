<?php
require 'head.php';
require 'menu.php';
?>
    <div id="main">
        <div class="header siteheader">
            <h1><?php echo $page_title; ?></h1>
            <h2><?php echo $page_subtitle; ?></h2>
        </div>
        <div class="content">
<?php
if (!$logged_in)
{
  echo $not_logged_in_message;
} else {
?>
    <h2>Vinnere av Quiz-Kalender 2025!!</h2>
    <h3>Vinner med flest poeng og raskeste svar på alle oppgavene tilsammen:</h3>
    <h2>Tobz</h2>
    <br>
<?php
/*    <!--<h3>Vinnere trukket fra alle løste oppgaver</h3>
    <h2></h2>
    <h2></h2>
    <br>
    <p>Trekking: <br>
    BitCoin 26.12.2024<br>
    Laveste verdi: kr 1 083 <b>106</b><br>
    Høyeste verdi: kr 1 133 <b>893</b><br>-->
*/?>
    <p>
        Kalenderen ble avsluttet 26.desember 2025 kl 23:59.
    </p>
<?php
/*    <!--<p>
    Slik foregår trekkingen:<br>
    Korrekt svar på én oppgave gir ett lodd i trekkingen, lodd deles ut med stigende tall etter svartidspunkt. Maks antall lodd per deltaker er 27. (24 oppgaver + 3 ekstraoppgaver)<br>
    Vinnerlodd trekkes fra tilfeldige tall, hentet fra verdiene av BitCoin 26.desember.<br>
    De tre siste siffer fra høyeste og laveste verdi av BitCoin gir to tilfeldige tall. (Verdien er i hele NOK i følge coinmarketcap.com)<br>
    Om ingen lodd treffer, velges tilsvarende tall fra en dag tidligere til vi har et vinnerlodd.<br>
    <br>
    Eksempel: BitCoin 10.desember 2024: <br>
    Laveste verdi: kr 1 095 <b>034</b><br>
    Høyeste verdi: kr 1 053 <b>287</b><br>
    Da vil vinnertallene være: 034 og 287.<br>
    </p>
    <hr>
    <h3>Lodd:</h3>
    Mine lodd er:-->
*/ ?>
    <?php
    /*$tickets = R::find('ticket', ' user_id = ? ORDER BY time ASC ', [ $user_id ] );
    $my_tickets = [];
    foreach ($tickets as $ticket)
        $my_tickets[] = $ticket['number'];
    if (count($my_tickets) < 27)
        echo "(løs flere oppgaver for flere lodd)";
    echo "<br>";
    echo implode(", ", $my_tickets);
    <br>
    <br>
    <!--<a href="tickets.php">Se alle loddene her</a>-->
*/?>
<?php
}
?>
        </div><!--class="content"-->
    </div><!--id="main"-->
<?php
require 'foot.php';
?>