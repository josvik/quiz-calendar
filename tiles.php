
<?php

if (isset($logged_in) && $logged_in) 
{  
    $activetasks = R::getAll( '
          SELECT id, day
          FROM task
          WHERE release_time <= ?
          AND hide_time > ?
          ORDER BY release_time ASC'
      , [ time(), time() ]);
  
  $solvedtasks = R::getCol( '
        SELECT task_id
        FROM taskanswer
        WHERE user_id = ?
        AND correct_answer_time > 0'
    , [ $user_id ]);
  
  echo "<div class=\"pure-g\">";
  
  for ($row = 1; $row <= CALENDAR_ROWS; $row++) {
    for ($col = 1; $col <= CALENDAR_COLS; $col++) {
      $task = array_shift($activetasks);
      echo  "<div class=\"pure-u-1-".CALENDAR_COLS." overviewday\">";
      $a_end = "";
      if ($task != null){
        $day = $task['day'];
        echo "<a href=\"calendar.php?dag=$day\">";
        $daysolved = "";
        if (in_array($task['id'], $solvedtasks))
          $daysolved = "overviewday-solved";
            echo "<img class=\"pure-img-responsive overviewday-img $daysolved\" src=\"" . CALENDAR_BG . "-$col-$row.png\" alt=\"$day\">";
        echo "<div class=\"overviewday-text\">$day</div>";
        echo "</a>";
      }
      else
        echo "<img class=\"pure-img-responsive overviewday-notask\" src=\"" . CALENDAR_BG . "-$col-$row.png\">";
      echo "</div>";
    }
  }
  echo "</div>\n";
}
?>
