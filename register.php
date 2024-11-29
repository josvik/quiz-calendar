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
          <h2 class="content-subhead">Ny bruker</h2>
<?php 

$name = null;
$email = null;

$typedname = "";
$typedemail = "";
$errormessages = [];

if (isset($_POST['name']) && isset($_POST['email'])) {
  $typedname = $_POST['name'];
  $typedemail = $_POST['email'];

  $name = sanitizeInput($_POST['name']);
  if (strlen(trim($name)) == 0)
    $errormessages[] = "Mangler brukernavn.";
  
  $email = sanitizeInput($_POST['email']);
  if (!validateEmail($email)){
    $errormessages[] = "E-post er ikke gyldig";
    $email = null;
  }
}

$emailsent = False;

if (!empty($name) && !empty($email)){
  $user = R::findOne('user', ' email = ?', [$email] );
  if ($user == null) {
    $user = R::dispense('user');
    $user->email = $email;
    
    $user->newname = $name;
    $auth_token = bin2hex(random_bytes(16));
    $user->newauthtoken = $auth_token;
    $user->sendemail = True;
    $user->admin = False;
    R::store($user);
    
    $login = R::dispense('login');
    $login->email = $user->email;
    $login->ipaddr = $_SERVER['REMOTE_ADDR'];
    $login->logintime = time();
    $login->type = "register";
    R::store($login);
  }
  require 'sendemail.php';
  $emailsent = sendLogin($user);
  if (! $emailsent)
    $errormessages[] = "En feil oppsto under utsending av e-post";
}
if ($emailsent){
  echo "<div class=\"answerfeedback answercorrect\"><h3>En innloggingslenke er sendt til " . $user->email . "</h3></div>";
}
else
{
?>
    
  <p>Registrer deg med ønsket kallenavn og e-post. <br>
  En innloggingslenke sendes til din e-post, denne bruker du til å logge deg inn.</p>
  <?php
  if (count($errormessages) > 0 )
    echo "<div class=\"answerfeedback answerwrong\"><h3>" . implode("<br>", $errormessages) . "</h3></div>";
  ?>
  <form method="POST" class="pure-form">
    <div>
      <label for="name">Kallenavn</label>
      <input autofocus type="text" id="name" name="name" style="max-width:50%; display: inline-block; margin-right:15px" value="<?php echo $typedname; ?>">
    </div>
    <div>
      <label for="email">E-post</label>
      <input type="email" id="email" name="email" style="max-width:50%; display: inline-block; margin-right:15px" value="<?php echo $typedemail; ?>">
    </div>

    <br>
    <div>
      <button type="submit" style="left: 20%;position: relative;padding: 5px;">Send</button>
    </div>
    <br>
  </form>
<?php
}
?>

          <p>Husk å sjekke søppelpost (spam-folder).<br>
          Informasjonskapsler(cookies) brukes til å huske innlogging.</p>
        </div><!--class="content"-->
    </div><!--id="main"-->
<?php
require 'foot.php';
?>