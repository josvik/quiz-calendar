
<?php

if (isset($logged_in) && $logged_in) 
{
  $scoreboard = R::getAll( '
        SELECT SUM(score) AS totalscore, MAX(correct_answer_time) AS lastanswertime, COUNT(CASE WHEN correct_answer_time > 0 THEN 1 END) as tasks, COUNT(CASE WHEN correct_answerextra_time > 0 THEN 1 END) as extratasks, user_id
        FROM taskanswer
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
  $place = $row;
  $prev_score = -1;
  foreach ($scoreboard as $scoreline){
    if ($scoreline['tasks']>0){
      if ($scoreline['totalscore'] != $prev_score)
        $place = $row;
      
      $dt->setTimestamp(intval($scoreline['lastanswertime']));
      $lastsolve = $dt->format('Y-m-d H:i:s');
      
      if ($scoreline['user_id'] == $user_id)
        echo "            <tr class=\"pure-table-me\">\n";
      else if ($row % 2 == 0)
        echo "            <tr class=\"pure-table-odd\">\n";
      else
        echo "            <tr>\n";
      echo "              <td>$place</td>\n";
      echo "              <td>" . $users[$scoreline['user_id']] . "</td>\n";
      echo "              <td>" . $scoreline['totalscore'] . "</td>\n";
      echo "              <td>" . $scoreline['tasks'];
      if ($scoreline['extratasks'] > 0)
        echo " (" . $scoreline['extratasks'] . ")";
      echo "</td>\n";
      echo "              <td>$lastsolve</td>\n";
      echo "            </tr>\n";
      $row++;
      $prev_score = $scoreline['totalscore'];
    }
  }
?>
          </tbody>
        </table>
<?php

  $groupscoreboard = R::getAll( '
        SELECT g.id as group_id, g.name as group_name,
        SUM(ta.score) as totalscore, count(DISTINCT u.id) as membercount,
        SUM(ta.score)/count(DISTINCT u.id) as avgscore
        FROM \'group\' g
        INNER JOIN \'group_user\' gu ON g.id == gu.group_id
        INNER JOIN \'user\' u ON gu.user_id == u.id
        INNER JOIN \'taskanswer\' ta ON u.id == ta.user_id
        GROUP BY g.id
        ORDER BY avgscore DESC
    ' );
?>
    <h2>Bandeoversikt</h2>
        <table class="pure-table">
          <thead>
            <tr>
              <th style="width:10%">#</th>
              <th style="width:60%">Bandenavn</th>
              <th style="width:10%">Poeng</th>
              <th style="width:10%">Antall i banden</th>
              <th style="width:10%">Vektet sum</th>
            </tr>
          </thead>
          <tbody>
<?php
  $row = 1;
  $place = $row;
  $prev_score = -1;
  foreach ($groupscoreboard as $groupscoreline){
      if ($groupscoreline['avgscore'] != $prev_score)
        $place = $row;

      if ($row % 2 == 0)
        echo "            <tr class=\"pure-table-odd\">\n";
      else
        echo "            <tr>\n";
      echo "              <td>$place</td>\n";
      echo "              <td><a href=\"scoreview.php?group=" . $groupscoreline['group_id'] . "\">" . $groupscoreline['group_name'] . "</a></td>\n";
      echo "              <td>" . $groupscoreline['totalscore'] . "</td>\n";
      echo "              <td>" . $groupscoreline['membercount'] . "</td>\n";
      echo "              <td>" . $groupscoreline['avgscore'] . "</td>\n";
      echo "            </tr>\n";
      $row++;
      $prev_score = $groupscoreline['avgscore'];
    }
?>
          </tbody>
        </table>
<?php
}
?>
