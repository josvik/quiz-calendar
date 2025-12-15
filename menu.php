    <!-- Menu toggle -->
    <a href="#menu" id="menuLink" class="menu-link">
        <!-- Hamburger icon -->
        <span></span>
    </a>

    <div id="menu">
        <div class="pure-menu">
            <a class="pure-menu-heading" href="<?php echo getBaseUrl(); ?>">quiz.josvik.no </a>

            <ul class="pure-menu-list">
                <li class="pure-menu-item"><a class="pure-menu-link" href="info.php">Info</a></li>
              
<?php

if (!$logged_in){
  ?>
                <li class="pure-menu-item"><a class="pure-menu-link" href="register.php">Opprett bruker</a></li>
                <li class="pure-menu-item"><a class="pure-menu-link" href="login.php">Logg inn</a></li>
<?php
} else {
?>
                <li class="pure-menu-item"><a class="pure-menu-link" href="profile.php">Profil</a></li>

                <li class="pure-menu-item"><a href="scoreview.php" class="pure-menu-link">Poengtavle</a></li>
                <!--<li class="pure-menu-item"><a href="winners.php" class="pure-menu-link">Vinnere</a></li>-->
                <li class="pure-menu-item menu-item-divided"><a href="calendar.php" class="pure-menu-link">Kalender</a></li>
<?php
  $activetasks = dbGetActiveTasks();
  $solvedtasks = dbGetSolvedTasks($user_id);

  foreach ($activetasks as &$task) {
    $day = $task['day'];
    echo "                <li class=\"pure-menu-item\"><a href=\"calendar.php?dag=$day\" class=\"pure-menu-link\">$day";
    
    if (array_key_exists($task['id'], $solvedtasks))
    {
      echo " &check;";
      if ($solvedtasks[$task['id']] > 0)
        echo "&check;";
    }
    echo "</a></li>\n";
  }
}
?>
<?php
if ($is_admin){
  print('                <li class="pure-menu-item menu-item-divided"><a href="admin_tasks.php" class="pure-menu-link">Admin kalender</a></li>');
  print('                <li class="pure-menu-item "><a href="admin_taskanswers.php" class="pure-menu-link">Admin svar</a></li>');
  print('                <li class="pure-menu-item "><a href="admin_users.php" class="pure-menu-link">Admin brukere</a></li>');
  print('                <li class="pure-menu-item "><a href="admin_sendemail.php" class="pure-menu-link">Admin epost</a></li>');
  print('                <li class="pure-menu-item "><a href="admin_tickets.php" class="pure-menu-link">Admin lodd</a></li>');
} 
?>
            </ul>
        </div>
    </div>