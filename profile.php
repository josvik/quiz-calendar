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
<?php
if (!$logged_in)
{
  print($not_logged_in_message);
} else {
?>
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
              <input autofocus type="text" id="name" name="name" style="width:50%; display: inline-block; margin-right:15px" value="<?php echo $user->name ?>">
            </div>
            <div>
              <label for="email">E-post</label>
              <input type="email" id="email" name="email" style="width:50%; display: inline-block; margin-right:15px" value="<?php echo $user->email ?>">
            </div>
            <div>
              <label for="sendmail">Tillat:</label>
              <input type="checkbox" id="sendmail" name="sendmail" value="1" <?php if ($user->sendemail) echo "checked"; ?>>
              Send meg e-post når kalenderen starter og en påminnelse en gang i uka.
              </input>
            </div>
            <br>
            <div>
              <button type="submit" name="profil" style="left: 20%;position: relative; padding: 5px;">Lagre</button>
            </div>
          </form>
          <br>
          <a href="deleteme.php">Slett min bruker</a>
          <a style="margin-left: 50px;" href="logout.php">Logg ut</a>
          <br><br>
          <hr>
<?php
$groupId = 0;
if (isset($_POST["groupid"])) {
    $groupId = intval($_POST["groupid"]);
}
if (isset($_POST["savegroup"])) {
    $groupname = sanitizeInput($_POST['groupname']);
    $checkgroupname = R::findOne( 'group', ' id != ? AND name LIKE ? ', [$groupId, $groupname ] );
    if ($checkgroupname){
        print("<div class=\"answerfeedback answerwrong\"><h3>Bandenavnet er opptatt!</h3></div>");
    } else {
        if ($groupId > 0){
            //$group = R::load( 'group', $_POST["groupid"]);
            $group = R::load( 'group', $groupId);
        } else {
            $group = R::dispense('group');
        }
        $group->name = $groupname;
        $group->ownerid = $user->id;
        R::store($group);
        $user->sharedGroupList[] = $group;
        R::store($user);
    }
} else if (isset($_POST["deletegroup"]) && isset($_POST["groupid"])) {
    $group = R::load( 'group', $_POST["groupid"]);
    R::trash($group);
} else if (isset($_POST["leavegroup"]) && isset($_POST["groupid"])) {
    foreach ($user->sharedGroupList as $key => $group) {
        if ($group->id == $_POST["groupid"]){
            unset($user->sharedGroupList[$key]);
            break;
        }
    }
    R::store($user);
} else if ( isset($_GET["joingroup"])) {
    $group = R::load( 'group', $_GET["joingroup"]);
    $user->sharedGroupList[] = $group;
    R::store($user);
}
?>
          <h2 class="content-subhead">Bander</h2>
          <br>
          <b>Medlem i bander:</b>
          <br>
<?php
$useringroups = array();
if ($user->sharedGroupList) {
    foreach( $user->sharedGroupList as $group ) {
        $useringroups[] = $group->id;
        print("          <div style=\"padding-bottom: 38px;\"> ");
        print("          <h3 style=\"/*! display: inline; */ margin-bottom: 0;\">" . $group->name . "</h3>");
        print("          <a style=\"/*! float: right; */\" href=\"scoreview.php?group=" . $group->id . "\">Poengoversikt</a><br>");
        print("          Invitasjonslenke: <nobr>" . getBaseUrl() . "profile.php?joingroup=" . $group->id . "</nobr>");
?>
          <form method="POST" class="pure-form">
              <div style="display: grid; float: right; grid-template-columns: auto 90px 90px">
                  <input type="hidden" name="groupid" value=" <?php print($group->id); ?> ">
<?php
if($group->ownerid == $user->id) {
?>
                  <input type="text" id="groupname_<?php print($group->id); ?>" name="groupname" style="grid-column: 1; grid-row: 1; height: 30px; margin-right:5px; visibility:hidden" value="<?php print($group->name); ?>">
                  <button type="submit" name="savegroup" class="pure-button" style="grid-column: 2; grid-row: 1; width: 85px; height: 30px; margin: 0;">Lagre</button>
                  <button type="button" class="pure-button" style="grid-column: 2; grid-row: 1; width: 85px; height: 30px;" onclick="this.hidden=true; getElementById('groupname_<?php print($group->id); ?>').style.visibility='visible';">Endre</button>
                  <button type="submit" name="deletegroup" class="pure-button" style="grid-column: 3; grid-row: 1; width: 85px; height: 30px; margin: 0;">Sikker?</button>
                  <button type="button" class="pure-button" style="grid-column: 3; grid-row: 1; width: 85px; height: 30px;" onclick="this.hidden=true">Slett</button>
<?php } else { ?>
                  <button type="submit" name="leavegroup" class="pure-button" style="grid-column: 3; grid-row: 1; width: 85px; height: 30px; margin: 0;">Sikker?</button>
                  <button type="button" class="pure-button" style="grid-column: 3; grid-row: 1; width: 85px; height: 30px;" onclick="this.hidden=true">Meld ut</button>
<?php } ?>
              </div>
          </form>
      </div>
      <hr>
<?php
    }
} else {
    print("- Ingen -");
}
?>
          <br>
          <br>
          <br>
          <b>Andre bander:</b><br>
<?php
$allgroups = R::findAll( 'group' );
foreach( $allgroups as $group ) {

    if (! in_array($group->id, $useringroups)){
?>
          <div style="padding-bottom: 40px;">
          <h3 style="margin-bottom: 0;"><?php print($group->name); ?> </h3>
          <a href="scoreview.php?group=<?php print($group->id); ?>">Poengoversikt</a>
          <form method="GET" class="pure-form">
              <div style="display: grid; float: right; grid-template-columns: auto 90px 90px">
                  <input type="hidden" name="joingroup" value="<?php print($group->id); ?>">
                  <button type="submit" class="pure-button" style="grid-column: 3; grid-row: 1; width: 85px; height: 30px; margin: 0;">Sikker?</button>
                  <button type="button" class="pure-button" style="grid-column: 3; grid-row: 1; width: 85px; height: 30px;" onclick="this.hidden=true">Bli med</button>
              </div>
          </form>
      </div>
      <hr>
<?php
    }
}
?>
      <br>
      Lag en ny bande:<br>
      <form method="POST" class="pure-form">
          <div>
              <label for="groupname">Navn</label>
              <input type="text" id="groupname" name="groupname" style="width:50%; display: inline-block; margin-right:15px">
              <button type="submit" name="savegroup" style="position: relative; padding: 5px;">Lagre</button>
          </div>
          <br>
      </form>
<?php } ?>
    </div><!--class="content"-->
</div><!--id="main"-->
<?php
require 'foot.php';
?>