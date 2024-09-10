<?php

if (isset($logged_in) && $logged_in) 
{
?>
        <h2>Mine poeng</h2>
        <table class="pure-table">
          <thead>
            <tr>
              <th style="width:45%">Oppgave</th>
              <th style="width:5%">Hint 1</th>
              <th style="width:5%">Hint 2</th>
              <th style="width:5%">Ekstra</th>
              <th style="width:10%">Poeng</th>
              <th style="width:35%">Løst tid</th>
            </tr>
          </thead>
          <tbody>
<?php
  $activetasks = R::getAll( '
    SELECT id, day, title
    FROM task
    WHERE release_time <= ?
    ORDER BY release_time ASC
    ', [ time() ]);
  $myscores = R::getAssoc( '
    SELECT task_id, show_hint1, show_hint2, score, correct_answer_time, correct_answerextra_time
    FROM taskanswer
    WHERE user_id = ?',
    [$user_id] );

  $dt = new DateTime();
  $dt->setTimezone(new DateTimeZone('Europe/Oslo'));
  
  $row = 1;
  $total_score = 0;
  $count_hint1 = 0;
  $count_hint2 = 0;
  $count_extra = 0;
  foreach ($activetasks as $task){
    $score = "";
    $solvetime = "";
    $hint1 = "";
    $hint2 = "";
    $extra = "";
    
    if (array_key_exists($task['id'], $myscores)){
      $myscore = $myscores[$task['id']];
      if ($myscore != null){
        $score = $myscore['score'];
        $total_score += $score;
        $cor_anw_time = intval($myscore['correct_answer_time']);
        if ($cor_anw_time > 0){
          $dt->setTimestamp($cor_anw_time);
          $solvetime = $dt->format('Y-m-d H:i:s');
        }
        if ($myscore['show_hint1']){
          $hint1 = "&check;";
          $count_hint1++;
        }
        if ($myscore['show_hint2']){
          $hint2 = "&check;";
          $count_hint2++;
        }
        $cor_anwext_time = intval($myscore['correct_answerextra_time']);
        if ($cor_anwext_time > 0){
          $extra = "&check;";
          $count_extra++;
        }
      }
    }
    if ($row % 2 == 0)
      echo "            <tr class=\"pure-table-odd\">\n";
    else
      echo "            <tr>\n";
    echo "              <td><a href=\"calendar.php?dag=" . $task['day'] . "\">" . $task['day'] . " - " . $task['title'] . "</a></td>\n";
    echo "              <td>$hint1</td>\n";
    echo "              <td>$hint2</td>\n";
    echo "              <td>$extra</td>\n";
    echo "              <td>$score</td>\n";
    echo "              <td>$solvetime</td>\n";
    echo "            </tr>\n";
    $row++;
  }
?>
          </tbody>
          <tfoot>
            <tr>
              <td>Total</td>
              <td><?php echo $count_hint1; ?></td>
              <td><?php echo $count_hint2; ?></td>
              <td><?php echo $count_extra; ?></td>
              <td><?php echo $total_score; ?></td>
              <td></td>
            </tr>
          </tfoot>
        </table>
<?php
}
?>
