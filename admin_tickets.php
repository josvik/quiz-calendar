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
        <h1>Admin lodd</h1>
      </div>

      <div class="content">
        <h2 class="content-subhead">Loddgenerator</h2>
        <form method="post">
          <div>
            <label for="from_time">Fra</label>
            <input type="datetime-local" id="from_time" name="from_time" value="2024-12-01 00:00">
            <label for="to_time">Fra</label>
            <input type="datetime-local" id="to_time" name="to_time" value="<?php echo date('Y-m-d H:i'); ?>">
          </div>
          <div>
            <button type="submit" name="generate_tickets" style="padding: 5px;">Lag lodd</button>
          </div>
        </form>
<?php

function createTicket($answer, $text) {
    $ticket = R::dispense( 'ticket' );
    $ticket->number = "";
    $ticket->time = $answer['time'];
    $ticket->user_id = $answer['user_id'];
    $ticket->username = $answer['username'];
    $ticket->task_id = $answer['task_id'];
    $ticket->taskday = $answer['taskday'] . $text;
    R::store($ticket);
}

if (isset($_POST['generate_tickets'])) {
    $from_time = strtotime($_POST['from_time']);
    $to_time = strtotime($_POST['to_time']);

    $correct_answers = R::getall('
        SELECT ta.correct_answer_time AS time, ta.user_id, user.name AS username, ta.task_id, task.day AS taskday
        FROM taskanswer ta
        JOIN user ON ta.user_id = user.id
        JOIN task ON ta.task_id = task.id
        WHERE correct_answer_time > ?
        AND correct_answer_time < ?
        ORDER BY ta.correct_answer_time ASC
    ', [ $from_time, $to_time ]);
    $correct_extra_answers = R::getall('
        SELECT ta.correct_answerextra_time AS time, ta.user_id, user.name AS username, ta.task_id, task.day AS taskday
        FROM taskanswer ta
        JOIN user ON ta.user_id = user.id
        JOIN task ON ta.task_id = task.id
        WHERE correct_answerextra_time > ?
        AND correct_answer_time < ?
        ORDER BY ta.correct_answer_time ASC
    ', [ $from_time, $to_time ]);
    $count_all_answers = count($correct_answers) + count($correct_extra_answers);
    $numberformat = "%0" . strlen(strval($count_all_answers)) . 'd';
    echo "<tt>";
    R::wipe( 'ticket' );
    echo "Slettet alle tidligere lodd.<br>";


    foreach ($correct_answers as $answer) {
        createTicket($answer, "");
    }
    foreach ($correct_extra_answers as $answer) {
        createTicket($answer, " (ekstra)");
    }
    $tickets = R::findAll( 'ticket' , ' ORDER BY time ASC ' );

    $number = 0;
    foreach ($tickets as $ticket) {
        $number++;
        $ticket->number = sprintf($numberformat, $number);
        R::store($ticket);
    }
    echo "Opprettet $number lodd.<br><br>";
    echo "</tt>";
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