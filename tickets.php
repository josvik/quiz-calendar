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
if (!$logged_in )
{
  echo $not_logged_in_message;
} else {
    $tickets = R::findAll( 'ticket' , ' ORDER BY time ASC ' );
    ?>
    <h3>Lodd:</h3>
    <table class="pure-table">
          <thead>
            <tr>
              <th>#</th>
              <th>Navn</th>
              <th>Oppgave</th>
              <th>Tidspunkt</th>
            </tr>
          </thead>
          <tbody>
    <?php
    $row = 1;
    $dt = new DateTime();
    $dt->setTimezone(TIMEZONE);

    foreach ($tickets as $ticket) {
        $dt->setTimestamp(intval($ticket['time']));
        $tickettime = $dt->format('Y-m-d H:i:s');
        if ($ticket['user_id'] == $user_id)
            echo "            <tr class=\"pure-table-me\">\n";
        else if ($row % 2 == 0)
            echo "            <tr class=\"pure-table-odd\">\n";
        else
            echo "            <tr>\n";
        echo "              <td>" . $ticket['number'] . "</td>\n";
        echo "              <td>" . $ticket['username'] . "</td>\n";
        echo "              <td>" . $ticket['taskday'] . "</td>\n";
        echo "              <td>" . $tickettime . "</td>\n";
        echo "            </tr>\n";
        $row++;
    }
}
echo "          </tbody>";
echo "    </table>";
?>

        </div><!--class="content"-->
    </div><!--id="main"-->
<?php
require 'foot.php';
?>