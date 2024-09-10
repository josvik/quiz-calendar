
<?php

if (isset($logged_in) && $logged_in) 
{
  $scoreboard = R::getAll( '
        SELECT SUM(score) AS totalscore, MAX(correct_answer_time) AS lastanswertime, COUNT(correct_answer_time) as tasks, COUNT(correct_answerextra_time) as extratasks, user_id
        FROM taskanswer
        WHERE correct_answer_time > 1701385200
        GROUP BY user_id
        ORDER BY totalscore DESC, lastanswertime ASC
    ' );
    $user_ids = array_column($scoreboard, 'user_id');
    $users = R::getAssoc( '
        SELECT id, name
        FROM user
        WHERE id IN (' . R::genSlots( $user_ids ) . ')',
      $user_ids );

?>
        <h2>Poengoversikt</h2>
        <table class="pure-table">
          <thead>
            <tr>
              <th style="width:10%">#</th>
              <th style="width:32%">Navn</th>
              <th style="width:10%">Poeng</th>
              <th style="width:18%">Antall (ekstra)</th>
              <th style="width:30%">Sist løste</th>
            </tr>
          </thead>
          <tbody>
<?php
  $dt = new DateTime();
  $dt->setTimezone(TIMEZONE);
  
  $row = 1;
  foreach ($scoreboard as $scoreline){
    if ($scoreline['tasks']>0){
      
      $dt->setTimestamp(intval($scoreline['lastanswertime']));
      $lastsolve = $dt->format('Y-m-d H:i:s');
      
      if ($scoreline['user_id'] == $user_id)
        echo "            <tr class=\"pure-table-me\">\n";
      else if ($row % 2 == 0)
        echo "            <tr class=\"pure-table-odd\">\n";
      else
        echo "            <tr>\n";
      echo "              <td>$row</td>\n";
      echo "              <td>" . $users[$scoreline['user_id']] . "</td>\n";
      echo "              <td>" . $scoreline['totalscore'] . "</td>\n";
      echo "              <td>" . $scoreline['tasks'];
      if ($scoreline['extratasks'] > 0)
        echo " (" . $scoreline['extratasks'] . ")";
      echo "</td>\n";
      echo "              <td>$lastsolve</td>\n";
      echo "            </tr>\n";
      $row++;
    }
  }
?>
          </tbody>
        </table>
<?php
}
?>
