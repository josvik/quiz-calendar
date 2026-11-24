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
  echo $texts["info_winners_long"];
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