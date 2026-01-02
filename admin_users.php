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
        <h1>Admin brukere</h1>
      </div>

      <div class="content">
<?php
$email = null;
if (isset($_GET["user_id"])){
    $userid = $_GET["user_id"];
    $lookupuser = R::load('user', $userid);
    if (!$lookupuser) {
        echo "<h3>" . $userid . ": Ikke funnet.</h3>\n";
    } else {
        $email = $lookupuser->email;
        echo "<h3>" . $userid . ": " . $lookupuser->name . " - " . $lookupuser->email . "</h3>\n";
        echo "<a href=\"scoreview.php?user_id=" . $userid . "\"> Poengtavle</a><br>\n";
    }
}
$userlogins = null;
if (isset($_GET["email"])) {
    $userlogins = R::find( 'login', ' email LIKE ? ', [ $_GET["email"] ] );
    $usages = R::find( 'usage', ' email LIKE ? ', [ $_GET["email"] ] );
    echo "<h2 class=\"content-subhead\">Logins - E-mail: " . $_GET["email"] . "</h2>\n";
} else if (isset($_GET["ipaddr"])) {
    $ipaddr = $_GET["ipaddr"];
    $userlogins = R::find( 'login', ' ipaddr LIKE ? ', [ $ipaddr ] );
    $usages = R::find( 'usage', ' ipaddr LIKE ? ', [ $ipaddr ] );
    $hostname = gethostbyaddr($ipaddr);
    echo "<h2 class=\"content-subhead\">Logins - IP-address: " . $ipaddr . "</h2>\n";
    echo "Host: ". $hostname . "<br><br>";
}
if ($userlogins || $usages) {
?>
    <table class="pure-table">
      <thead>
        <tr>
          <th>Id</th>
          <th>E-mail</th>
          <th>IP-address</th>
          <th>Time</th>
          <th>Type</th>
        </tr>
      </thead>
      <tbody>
<?php
}
if ($userlogins) {
    $row = 1;
    foreach ($userlogins as $userlogin) {
        $logintime = "";
        if ($userlogin['logintime'] > 0)
            $logintime = date('Y-m-d H:i:s', $userlogin['logintime']);

        if ($row % 2 == 0)
            echo "            <tr class=\"pure-table-odd\">\n";
        else
            echo "            <tr>\n";
        echo "          <td>" . $userlogin['id'] . "</td>\n";
        echo "          <td><a href=\"admin_users.php?email=" . $userlogin['email'] . "\">" . $userlogin['email'] . "</a></td>\n";
        echo "          <td><a href=\"admin_users.php?ipaddr=" . $userlogin['ipaddr'] . "\">" . $userlogin['ipaddr'] . "</a></td>\n";
        echo "          <td>" . $logintime . "</td>\n";
        echo "          <td>" . $userlogin['type'] . "</td>\n";
        echo "        </tr>\n";
        $row++;
    }
}
if ($usages) {
    foreach ($usages as $usage) {
        $usetime = "";
            if ($usage['time'] > 0)
            $usetime = date('Y-m-d_H:i:s', $usage['time']);

        if ($row % 2 == 0)
            echo "            <tr class=\"pure-table-odd\">\n";
        else
            echo "            <tr>\n";
        echo "          <td>" . $usage['id'] . "</td>\n";
        echo "          <td><a href=\"admin_users.php?email=" . $usage['email'] . "\">" . $usage['email'] . "</a></td>\n";
        echo "          <td><a href=\"admin_users.php?ipaddr=" . $usage['ipaddr'] . "\">" . $usage['ipaddr'] . "</a></td>\n";
        echo "          <td>" . $usetime . "</td>\n";
        echo "          <td style=\"white-space: nowrap;\">" . $usage['url'] . "</td>\n";
        if ($usage['post'] != null && $usage['post'] != "[]")
            echo "          <td>" . $usage['post'] . "</td>\n";
        echo "        </tr>\n";
        $row++;
    }
}
echo "    </table>";
?>

        <h2 class="content-subhead">Alle brukere</h2>
    <table class="pure-table">
      <thead>
        <tr>
          <th>Id</th>
          <th>E-mail</th>
          <th>Name</th>
          <th>SendEmail</th>
          <th>SendEmailNextEvent</th>
        </tr>
      </thead>
      <tbody>
<?php
$lookupusers = R::find( 'user' );
$row = 1;
foreach ($lookupusers as $lookupuser) {
    if ($row % 2 == 0)
        echo "            <tr class=\"pure-table-odd\">\n";
    else
        echo "            <tr>\n";
    echo "          <td><a href=\"admin_users.php?user_id=" . $lookupuser['id'] . "\">" . $lookupuser['id'] . "</a></td>\n";
    echo "          <td><a href=\"admin_users.php?email=" . $lookupuser['email'] . "\">" . $lookupuser['email'] . "</a></td>\n";
    echo "          <td>" . $lookupuser['newname'] . "</td>\n";
    echo "          <td>" . $lookupuser['sendemail'] . "</td>\n";
    echo "          <td>" . $lookupuser['sendemailnextevent'] . "</td>\n";
    echo "        </tr>\n";
    $row++;
}
?>
    </table>
<h2 class="content-subhead">Logins - No user</h2>
<?php
$loginsnousers = R::getall( 'SELECT l.* FROM login l LEFT JOIN user u ON l.email = u.email WHERE u.email IS NULL; ');
?>
    <table class="pure-table">
      <thead>
        <tr>
          <th>Id</th>
          <th>E-mail</th>
          <th>IP-address</th>
          <th>Time</th>
          <th>Type</th>
        </tr>
      </thead>
      <tbody>
<?php
    $row = 1;
    foreach ($loginsnousers as $loginsnouser) {
        $logintime = "";
        if ($loginsnouser['logintime'] > 0)
            $logintime = date('Y-m-d H:i:s', $loginsnouser['logintime']);

        if ($row % 2 == 0)
            echo "            <tr class=\"pure-table-odd\">\n";
        else
            echo "            <tr>\n";
        echo "          <td>" . $loginsnouser['id'] . "</td>\n";
        echo "          <td><a href=\"admin_users.php?email=" . $loginsnouser['email'] . "\">" . $loginsnouser['email'] . "</a></td>\n";
        echo "          <td><a href=\"admin_users.php?ipaddr=" . $loginsnouser['ipaddr'] . "\">" . $loginsnouser['ipaddr'] . "</a></td>\n";
        echo "          <td>" . $logintime . "</td>\n";
        echo "          <td>" . $loginsnouser['type'] . "</td>\n";
        echo "        </tr>\n";
        $row++;
    }
    echo "    </table>";
?>
    </table>
<h2 class="content-subhead">Usages - No user</h2>
<?php
if (isset($_GET["showusagesnouser"])) {
    $usagesnousers = R::getall( 'SELECT l.* FROM usage l LEFT JOIN user u ON l.userid = u.id WHERE u.id IS NULL; ');
    ?>
    <table class="pure-table">
      <thead>
        <tr>
          <th>Id</th>
          <th>E-mail</th>
          <th>IP-address</th>
          <th>Time</th>
          <th>Url</th>
          <th>Post</th>
        </tr>
      </thead>
      <tbody>
    <?php
        $row = 1;
        foreach ($usagesnousers as $usagesnouser) {
            $usetime = "";
                if ($usagesnouser['time'] > 0)
                $usetime = date('Y-m-d_H:i:s', $usagesnouser['time']);

            if ($row % 2 == 0)
                echo "            <tr class=\"pure-table-odd\">\n";
            else
                echo "            <tr>\n";
            echo "          <td>" . $usagesnouser['id'] . "</td>\n";
            echo "          <td><a href=\"admin_users.php?email=" . $usagesnouser['email'] . "\">" . $usagesnouser['email'] . "</a></td>\n";
            echo "          <td><a href=\"admin_users.php?ipaddr=" . $usagesnouser['ipaddr'] . "\">" . $usagesnouser['ipaddr'] . "</a></td>\n";
            echo "          <td>" . $usetime . "</td>\n";
            echo "          <td style=\"white-space: nowrap;\">" . $usagesnouser['url'] . "</td>\n";
            echo "          <td>";
            if ($usagesnouser['post'] != null && $usagesnouser['post'] != "[]")
                    echo $usagesnouser['post'];
            echo "</td>\n";
            echo "        </tr>\n";
            $row++;
        }
        echo "    </table>";
    ?>
    </table>
<?php
} else {
    echo "<a href=\"admin_users.php?showusagesnouser=1\">Show usages with no user</a>\n";
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