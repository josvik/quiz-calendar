<?php
require 'head.php';
require 'menu.php';
?>
<?php
if (!$logged_in) 
{
  echo $not_logged_in_message;
} else if ($is_admin) {
?>
    <div id="main">
      <div class="header siteheader">
        <h1>Admin send e-post</h1>
      </div>

      <div class="content">

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function(){
    $("#mailContent").keyup(function(){
        // Getting the current value of textarea
        var currentText = $(this).val();

        // Setting the Div content
        $("#mailContentHTML").html(currentText);
    });
});
</script>
<?php 

$mailsubject1 = "Quiz-Kalenderen har startet!";
$mailContent1 = "<h3>Velkommen til årets Quiz-kalender!</h3>
      <p>Første luke starter med noe enkelt og t. <br> Dagens ord er: <b>POPOPOPCOCORORNON</b></p>
      <p>Hva kan du gjøre for å dekryptere dette underfundige ordet?</p>
      <br>
      <p>Morgendagens oppgave kommer til å ha et ord som står mer i klartekst.<br>
      Og ikke nok med det, løser du oppgaven så vanker det en ekstraoppgave!</p>
      <br>
      <br>
      <p>Bruk lenken under for å logge inn. <br>Du kan også bruke denne lenken til å logge inn fra andre enheter</p>
      <p><a href=\"%s\">%s</a></p>
      <p>Lykke til, og husk å sjekke dagens oppgave hver dag i adventstiden.</p>
      <hr>
      <p>Hvis du ikke ønsker flere e-poster kan du endre dette under din profil.</p>";

$mailsubject26 = "Quiz-Kalenderen";
$mailContent26 = "<h3>Quiz-kalenderen 2023 er ferdig. Takk!</h3>
      <p>Hei!</p>
      <p>Romjulen er godt i gang og den første Quiz-kalenderen er over for denne gang.<br>
      Jeg er enormt imponert over hvor mange som deltok og hvor mange oppgaver som ble løst. Det ble registrert over 60 deltakere, nesten 50 har svart på minst en oppgave og nesten 20 har løst alle oppgavene.<br>
      Og ikke minst, det er hele ti som har full pott på 290 poeng! Imponerende!</p>
      
      <p>Alle ti kan vente seg en liten premie i nær fremtid.<br>
      Førstepremien går til “<b>FamTvete</b>” som leverte riktig svar på siste oppgave etter 50 minutter.<br>
      Og ekstra premie går til “<b>Tobiaz</b>” som hadde laveste snitt tid på riktig svar, 2t 20min.<br>
      Gratulerer!</p>
      
      <p>Videre er det planer om en ny Quiz-kalender i advent 2024, med muligens litt rarere oppgaver. <br>
      Kanskje dukker det opp noen oppgaver allerede i påsken…<br>
      Jeg håper på din deltakese da også.</p>
      
      <p>Tusen takk til alle som deltok! <br>
      Dette var artig.<br>
      <br>
      Løkk med jula!<br>
      Hilsen Jostein.
";

$mailsubject = $mailsubject1;
$mailContent = $mailContent1;

if (isset($_POST['mailsubject']) && isset($_POST['mailContent'])) {
    $mailsubject = $_POST['mailsubject'];
    $mailContent = $_POST['mailContent'];
}

?>
<div id="mailContentHTML">
<?php echo sprintf($mailContent, "--==login_url==--", "--==login_url==--"); ?>
</div>
<form method="POST">
<div>
    <label for="mailsubject">Emne</label>
    <input type="text" id="mailsubject" name="mailsubject" style="width:50%; display: inline-block; margin-right:15px" value="<?php echo $mailsubject ?>">
</div>
<div>
    <label for="mailContent">Innhold</label>
    <textarea id="mailContent" name="mailContent" rows="20" cols="100"><?php echo $mailContent; ?></textarea>
</div>
<input type="hidden" name="sendpost" value="1">
<?php
  $allusers = R::findAll( 'user');
?>
<div>
  <label>Mottakere</label>
  <ul>
  <?php foreach ($allusers as &$user) { ?>
    <li><input type="checkbox" name="userid[]" value="<?php echo $user->id; ?>"><?php echo $user->email . " - " . $user->name; ?></li>
  <?php } ?>
  </ul>
</div>

<button type="submit" class="pure-button pure-button-primary" style="grid-column: 3; margin: 0px; ">Send</button>
</form>
<?php

if (isset($_POST['sendpost'])){
  require 'sendemail.php';
  
  $userstest = R::findAll( 'user' , ' WHERE admin = 1' );  
  $users1 = R::findAll( 'user' , ' WHERE sendemail = 1' );
  $users26 = R::findAll( 'user' , ' ' );
  
  $users = $users26;
  foreach( $_POST['userid'] as $userid ) {
    $user = R::load('user', $userid);
    if ($user) {
      $login_url = getloginurl($user);
      $content = sprintf($mailContent, $login_url, $login_url);
      $emailsent = sendEmail($user, $mailsubject, $content);
      echo $user->email . ": ";
      if ($emailsent)
        echo "ok<br>";
      else
        echo "En feil oppsto under utsending av e-post";
      echo "<br>";
    }
  }
unset($user);
}
?>        
      </div>
    </div>
<?php
}
?>
<?php
require 'foot.php';
?>