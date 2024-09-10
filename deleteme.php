<?PHP
require 'head.php';

$deletedmessage = "ikke slettet";
if (isset($_POST["slettmeg"]) && isset($logged_in) && $logged_in) {
  R::trash($user);
  R::exec( 'DELETE FROM taskanswer WHERE user_id == ?', [ $user_id ] );

  setcookie('token', '', time()-3600);
  $logged_in = False;
  $deletedmessage = "Din bruker er slettet.";
}

require 'menu.php';
?>
    <div id="main">
        <div class="header siteheader">
            <h1><?php echo $page_title; ?></h1>
            <h2><?php echo $page_subtitle; ?></h2>
        </div>
        <div class="content">
<?php
if (isset($logged_in) && $logged_in) 
{
?>
          <h2 class="content-subhead">Slett meg?</h2>
          <p>Ved å trykke på knappen nedenfor slettes din bruker og informasjon knyttet til denne.</p>
          <form method="POST" class="pure-form">
            <br>
            <div style="display: grid;">
              <button type="submit" class="pure-button" style="grid-column: 1; grid-row: 1; width: 150px; height: 34px;" name="slettmeg">Helt sikker?</button>
              <button type="button" class="pure-button" style="grid-column: 1; grid-row: 1; width: 150px; height: 34px;" onclick="this.hidden=true">Slett meg</button>
            </div>
            <br>
          </form>
<?php 
} else {
  echo $deletedmessage;
}  
?>
        </div>
    </div>
</body>
</html>
