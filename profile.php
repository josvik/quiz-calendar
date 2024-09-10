<?PHP
  require 'head.php';
  require 'menu.php';
?>

    <div id="main">
        <div class="header siteheader">
            <h1><?php echo $page_title; ?></h1>
            <h2><?php echo $page_subtitle; ?></h2>
        </div>
        <div class="content">
          <div style="display: inline-block;">
            <h2 class="content-subhead">Profil</h2>
          </div>
<?php 

$name = null;
$email = null;

if (isset($_POST["profil"]) && $user != null) {
  if (isset($_POST['name'])) {
    $name = sanitizeInput($_POST['name']);
    if (!empty($name)){
      $user->name = $name;
      $user->newname = $name;
    }
  }
  if (isset($_POST['email'])) {
    $email = sanitizeInput($_POST['email']);
    if (validateEmail($email))
      $user->email = $email;
  }
  $user->sendemail = False;
  if (isset($_POST["sendmail"]) && $_POST["sendmail"]==1){
    $user->sendemail = True;
  }
  R::store($user);
  echo "<div class=\"answerfeedback answercorrect\" style=\"display: inline-block;padding: 0px 50px; margin-left: 6vw;\">";
  echo "<h3>Lagret</h3>";
  echo "</div>";
}

?>
          <form method="POST" class="pure-form">
            <div>
              <label for="name">Navn</label>
              <input autofocus type="text" id="name" name="name" style="max-width:50%; display: inline-block; margin-right:15px" value="<?php echo $user->name ?>">
            </div>
            <div>
              <label for="email">E-post</label>
              <input type="email" id="email" name="email" style="max-width:50%; display: inline-block; margin-right:15px" value="<?php echo $user->email ?>">
            </div>
            <div>
              <label for="sendmail">Tillat:</label>
              <input type="checkbox" id="sendmail" name="sendmail" value="1" <?php if ($user->sendemail) echo "checked"; ?>>
              Send meg e-post når kalenderen starter og en påminnelse en gang i uka.
              </input>
            </div>
            <div class="g-recaptcha" data-sitekey="6Lf8fdUoAAAAAEVEcZ1qeJmSUttQKrWDFsfXGY2b" data-action="LOGIN"></div> 
            <br>
            <div>
              <button type="submit" name="profil" style="left: 20%;position: relative; padding: 5px;">Lagre</button>
            </div>
            <br>
          </form>
          <br>
          <br>
          <br>
          <a href="deleteme.php">Slett min bruker</a>
          <br>
          <br>
          <a href="logout.php">Logg ut</a>
        </div><!--class="content"-->
    </div><!--id="main"-->
<?php
require 'foot.php';
?>