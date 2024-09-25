
<?php

if (isset($logged_in) && $logged_in) 
{
    if (isset($_GET['group']))
    {
      $group = R::load( 'group', $_GET['group']);
      $scoreboard = R::getAll( '
            SELECT SUM(ta.score) AS totalscore, MAX(ta.correct_answer_time) AS lastanswertime, COUNT(ta.correct_answer_time) as tasks, COUNT(ta.correct_answerextra_time) as extratasks, ta.user_id as user_id, u.name as username
            FROM taskanswer ta
            INNER JOIN user u ON ta.user_id = u.id
            LEFT OUTER JOIN group_user gu on ta.user_id = gu.user_id
            WHERE gu.group_id = ?
            GROUP BY ta.user_id
            ORDER BY totalscore DESC, lastanswertime ASC'
        , [ $group->id ]);
    } else {
      $group = R::dispense('group');
      $scoreboard = Array();
    }
?>
        <h2>Poengoversikt bande: <?php print($group->name); ?></h2>
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
    if ($scoreline['tasks'] > 0) {
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
      echo "              <td>" . $scoreline['username'] . "</td>\n";
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
}
?>
