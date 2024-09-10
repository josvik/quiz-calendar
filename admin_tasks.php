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
        <h1>Admin oppgaver</h1>
      </div>

      <div class="content">
        <h2 class="content-subhead">Legg til oppgave</h2>
<?php 
if (isset($_POST['day']) && isset($_POST['title']) && isset($_POST['release_time']) && isset($_POST['hide_time']) && isset($_POST['description']) && isset($_POST['answer'])) {
  $savetask = R::dispense('task');
  
  $savetask->day = $_POST['day'];
  $savetask->title = $_POST['title'];
  $savetask->value = $_POST['value'];
  $release_time = strtotime($_POST['release_time']);
  $savetask->release_time = $release_time;
  $hide_time = strtotime($_POST['hide_time']);
  $savetask->hide_time = $hide_time;
  
  $savetask->description = $_POST['description'];
  $savetask->answer = $_POST['answer'];
  $savetask->hint1 = $_POST['hint1'];
  $savetask->hint2 = $_POST['hint2'];
  $savetask->hasextratask = isset($_POST['hasextratask']) && $_POST['hasextratask']="1";
  $savetask->descriptionextra = $_POST['descriptionextra'];
  $savetask->answerextra = $_POST['answerextra'];
  $savetask->valueextra = $_POST['valueextra'];

  $savetask->id = $_POST['taskid'];
  
  
  R::store($savetask);
}
$task = R::dispense('task');
$task->value = 10;
$task->release_time = time();
$task->hide_time = time() + 2678400;

if (isset($_GET['taskid']))
  $task = R::load('task', $_GET['taskid']);
?>

        <form method="POST" class="pure-form">
          <div>
            <label for="day">Dag</label>
            <input autofocus type="text" id="day" name="day" value="<?php echo $task->day; ?>">
            <label for="release_time">Slipp tid</label>
            <input type="datetime-local" id="release_time" name="release_time" value="<?php echo date('Y-m-d H:i', $task->release_time); ?>">
          </div>
          <div>
            <label for="title">Tittel</label>
            <input type="text" id="title" name="title" value="<?php echo $task->title; ?>">
            <label for="value">Skjul tid</label>
            <input type="datetime-local" id="hide_time" name="hide_time" value="<?php echo date('Y-m-d H:i', $task->hide_time); ?>">
          </div>
          <div>
            <label for="description">Tekst</label>
            <textarea id="description" name="description" rows="4" cols="53"><?php echo $task->description; ?></textarea>
          </div>
          <div>
            <label for="answer">Svar</label>
            <input type="text" id="answer" name="answer" value="<?php echo $task->answer; ?>">
            <label for="value">Verdi</label>
            <input type="number" id="value" name="value" value="<?php echo $task->value; ?>">
          </div>
          <div>
            <label for="hint1">Hint 1</label>
            <textarea id="hint1" name="hint1" rows="1" cols="53"><?php echo $task->hint1; ?></textarea>
          </div>
          <div>
            <label for="hint2">Hint 2</label>
            <textarea id="hint2" name="hint2" rows="1" cols="53"><?php echo $task->hint2; ?></textarea>
          </div>
          <div>
            <label for="hasextratask">Ekstra</label>
            <input type="checkbox" id="hasextratask" name="hasextratask" value="1" <?php if ($task->hasextratask) echo "checked"; ?>>
            &nbsp;
            <textarea id="descriptionextra" name="descriptionextra" rows="4" cols="50"><?php echo $task->descriptionextra; ?></textarea>
          </div>
          <div>
            <label for="answerextra">Svar</label>
            <input type="text" id="answerextra" name="answerextra" value="<?php echo $task->answerextra; ?>">
            <label for="valueextra">Verdi</label>
            <input type="number" id="valueextra" name="valueextra" value="<?php echo $task->valueextra; ?>">
          </div>
          <input type="hidden" name="taskid" value="<?php echo $task->id; ?>">
          <div>
            <button type="submit" style="padding: 5px;">Send</button>
          </div>
        </form>
        <br><br>
        <h1 class="content-subhead">Oppgaver</h1>
        <hr>
<?php
$alltasks = R::findAll( 'task' , ' ORDER BY release_time ASC ' );
foreach ($alltasks as &$task) {
  echo "<h3>$task->day &ndash; $task->title</h3>";
  echo "<p>".htmlspecialchars(substr($task->description ?? '', 0, 100))."</p>";
  echo "<table>";
  echo "<tr><td>Har ekstraoppgave:</td><td><b>$task->hasextratask</b></td></tr>";
  echo "<tr><td>Vises i tiden:</td><td><b>". date('Y-m-d H:i', $task->release_time). "</b> - <b>". date('Y-m-d H:i', $task->hide_time). "</b></td></tr>";
  echo "</table>";
  echo "<a href=\"admin_tasks.php?taskid=$task->id\">Rediger</a>";
  echo "</p>";
  echo "<hr>";
}
unset($task);
?>        
      </div>
    </div>
<?php
}
?>
<?php
require 'foot.php';
?>