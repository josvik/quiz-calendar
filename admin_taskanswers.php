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
        <h1>Admin svar</h1>
      </div>

      <div class="content">
<?php
if (isset($_GET["task_id"])){
    $taskanswers = R::getAll('
        SELECT ta.*, u.name
        FROM taskanswer ta
        INNER JOIN user u ON (ta.user_id = u.id)
        WHERE ta.task_id = ?
        ORDER BY ta.correct_answer_time DESC
    ', [$_GET["task_id"]]);
?>
        <h2 class="content-subhead">Riktige svar: <?php echo $_GET["day"]; ?></h2>
    <table class="pure-table">
      <thead>
        <tr>
          <th>Navn</th>
          <th>Åpnet</th>
          <th>Riktig</th>
          <th>Hint 1</th>
          <th>Hint 2</th>
          <th>Ekstra</th>
          <th>Poeng</th>
          <th>Sekunder</th>
        </tr>
      </thead>
      <tbody>

<?php
    $row = 1;
    foreach ($taskanswers as $taskanswer) {
        $openedtime = "";
        $answertime = "";
        $answerextratime = "";
        $hint1time = "";
        $hint2time = "";
        if ($taskanswer['opened_time'] > 0)
            $openedtime = date('Y-m-d H:i', $taskanswer['opened_time']);
        if ($taskanswer['correct_answer_time'] > 0)
            $answertime = date('Y-m-d H:i', $taskanswer['correct_answer_time']);
        if ($taskanswer['correct_answerextra_time'] > 0)
            $answerextratime = date('Y-m-d H:i', $taskanswer['correct_answerextra_time']);
        if ($taskanswer['show_hint1'] > 0)
            $hint1time = date('Y-m-d H:i', $taskanswer['show_hint1']);
        if ($taskanswer['show_hint2'] > 0)
            $hint2time = date('Y-m-d H:i', $taskanswer['show_hint2']);

        if ($row % 2 == 0)
            echo "            <tr class=\"pure-table-odd\">\n";
        else
            echo "            <tr>\n";
        echo "          <td>" . $taskanswer['name'] . "</td>\n";
        echo "          <td>" . $openedtime . "</td>\n";
        echo "          <td>" . $answertime . "</td>\n";
        echo "          <td>" . $hint1time . "</td>\n";
        echo "          <td>" . $hint2time . "</td>\n";
        echo "          <td>" . $answerextratime . "</td>\n";
        echo "          <td>" . $taskanswer['score'] . "</td>\n";
        echo "          <td>" . getDaysHoursMinutesFromSeconds($taskanswer['correct_answer_sec']) . "</td>\n";
        echo "        </tr>\n";
        $row++;
    }
    echo "    </table>";


    $wronganswers = R::getAll('
        SELECT wa.*, u.name
        FROM wronganswer wa
        INNER JOIN user u ON (wa.user_id = u.id)
        WHERE wa.task_id = ?
        ORDER BY wa.wrong_time DESC
    ', [$_GET["task_id"]]);
?>
        <h2 class="content-subhead">Feil svar: <?php echo $_GET["day"]; ?></h2>
    <table class="pure-table">
      <thead>
        <tr>
          <th>Navn</th>
          <th>Feil svar</th>
          <th>Tidspunkt</th>
          <th>Ekstra</th>
        </tr>
      </thead>
      <tbody>

<?php
    $row = 1;
    foreach ($wronganswers as $wronganswer) {
        $wrongtime = "";
        if ($wronganswer['wrong_time'] > 0)
            $wrongtime = date('Y-m-d H:i', $wronganswer['wrong_time']);

        if ($row % 2 == 0)
            echo "            <tr class=\"pure-table-odd\">\n";
        else
            echo "            <tr>\n";
        echo "          <td>" . $wronganswer['name'] . "</td>\n";
        echo "          <td>" . $wronganswer['wrong_answer'] . "</td>\n";
        echo "          <td>" . $wrongtime . "</td>\n";
        echo "          <td>" . $wronganswer['extratask'] . "</td>\n";
        echo "        </tr>\n";
        $row++;
    }
    echo "    </table>";
}
?>

        <h2 class="content-subhead">Alle oppgaver</h2>
    <table class="pure-table">
      <thead>
        <tr>
          <th style="width:25%">Oppgave</th>
          <th style="width:15%">Åpnet</th>
          <th style="width:15%">Riktig</th>
          <th style="width:15%">Hint 1</th>
          <th style="width:15%">Hint 2</th>
          <th style="width:15%">Ekstra</th>
          <th style="width:15%">Sekunder</th>
        </tr>
      </thead>
      <tbody>
<?php
$alltaskanswers = R::getAll( '
    SELECT t.id as id, t.day as day,
      COUNT(CASE WHEN ta.opened_time > 0 THEN 1 END) as count_opened,
      COUNT(CASE WHEN ta.correct_answer_time > 0 THEN 1 END) as count_correctanswers,
      COUNT(CASE WHEN ta.show_hint1 > 0 THEN 1 END) as count_hint1,
      COUNT(CASE WHEN ta.show_hint2 > 0 THEN 1 END) as count_hint2,
      COUNT(CASE WHEN ta.correct_answerextra_time > 0 THEN 1 END) as count_correctanswersextra,
      SUM(ta.correct_answer_sec) as totalsec
    FROM taskanswer ta
    INNER JOIN task t ON (t.id = ta.task_id)
    group by ta.task_id
' );

?>
<?php
$row = 1;
foreach ($alltaskanswers as $taskanswer) {
    if ($row % 2 == 0)
        echo "            <tr class=\"pure-table-odd\">\n";
    else
        echo "            <tr>\n";
    echo "          <td><a href=\"admin_taskanswers.php?task_id=" . $taskanswer['id'] . "&day=" .  $taskanswer['day'] . "\">" . $taskanswer['day'] . "</a></td>\n";
    echo "          <td>" . $taskanswer['count_opened'] . "</td>\n";
    echo "          <td>" . $taskanswer['count_correctanswers'] . "</td>\n";
    echo "          <td>" . $taskanswer['count_hint1'] . "</td>\n";
    echo "          <td>" . $taskanswer['count_hint2'] . "</td>\n";
    echo "          <td>" . $taskanswer['count_correctanswersextra'] . "</td>\n";
    echo "          <td>" . $taskanswer['totalsec'] . "</td>\n";
    echo "        </tr>\n";
    $row++;
}
?>
    </table>
      </div>
    </div>
<?php
}
?>
<?php
require 'foot.php';
?>