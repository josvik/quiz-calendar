<?php 

setcookie('token', '', time()-3600);

if (isset($_GET['authtoken']) && isset($_GET['email'])) {
  require("db.php");
  require 'common.php';
  $user = R::findOne('user', ' newauthtoken = ? AND LOWER(email) = LOWER(?)', [$_GET['authtoken'], $_GET['email']] );
  if ($user == null) {
    echo "Feil token";
  }
  else {    
    $user->name = $user->newname;
    $user->authtoken = $user->newauthtoken;
    R::store($user);
    
    $login = R::dispense('login');
    $login->email = $user->email;
    $login->ipaddr = $_SERVER['REMOTE_ADDR'];
    $login->logintime = time();
    $login->type = "login";
    R::store($login);
    
    setcookie('token', $_GET['authtoken'], time()+3600*24*30);
    $baseurl = getBaseUrl();
    $newpage = $baseurl;
    if (isset($_GET["joingroup"]))
        $newpage = $baseurl . "profile.php?joingroup=" . $_GET["joingroup"];
    header('Location: ' . $newpage);
  }
} else {

  require 'head.php';
  require 'menu.php';
?>
    <div id="main">
        <div class="header siteheader">
            <h1><?php echo $page_title; ?></h1>
            <h2><?php echo $page_subtitle; ?></h2>
        </div>
        <div class="content">
          <h2 class="content-subhead">Innlogging</h2>
<?php
  if (isset($_POST['email'])) {
    

    $email = sanitizeInput($_POST['email']);
    if (!validateEmail($email))
      $email = null;
    
    $user = null;
    if (!empty($email))
      $user = R::findOne('user', ' LOWER(email) = LOWER(?) AND newauthtoken IS NOT NULL', [$email] );

    if ($user != null) {
      require 'sendemail.php';
      $emailsent = sendLogin($user);
      if ($emailsent)
        echo "E-post sendt";
      else
        $errormessages[] = "En feil oppsto under utsending av e-post";
    } else 
      echo "<p>Ingen bruker funnet. Du kan opprette en bruker <a href=\"register.php\"> her</a>.</p>";
    
  } else {
?>

  <p>Skriv inn din e-post og så sendes innloggingslenke, denne bruker du til å logge deg inn.</p>
  <form method="POST" class="pure-form">
    <div>
      <label for="email">E-post</label>
      <input type="email" id="email" name="email" style="max-width:50%; display: inline-block; margin-right:15px" value="">
    </div>
    <br>
    <div>
      <button type="submit" style="left: 20%;position: relative;padding: 5px;">Send</button>
    </div>
    <br>
  </form>
  <p>Informasjonskapsler(cookies) brukes kun til å huske innlogging.</p>
<?php
  }
}
?>
        </div><!--class="content"-->
    </div><!--id="main"-->
<?php
require 'foot.php';
?>