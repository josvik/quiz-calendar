<?php
require 'head.php';

if (!$logged_in) 
{
  $content = $not_logged_in_message;
  
} else {
  if (isset($_GET['dag']))
  {
    if (isset($_GET['overstyring']) && $is_admin)
      //Admins can view any task if they add a GET 'overstyring'
      $task = R::findOne('task' , ' day like ? ', [urldecode($_GET['dag'])] );
    else
      $task = R::findOne('task' , ' day like ? AND release_time <= ?', [urldecode($_GET['dag']), time()] );
    

    
    if ($task == null) {
      $content = "
            <h2 class=\"content-subhead\">404 - Her er det ingenting</h2>
            <p>Denne oppgaven finnes ikke (enda)</p>
            <br>
            <p>I mellomtiden kan du kose deg med hva ChatGPT mener om dette tema:</p>
            <blockquote>
              <p><i>En annen oppgave som ennå ikke finnes, men som kanskje kan materialisere seg i fremtiden, er utviklingen av en bærekraftig og sikker metode for romsøppelopprydding i bane rundt jorden. Med et økende antall satellitter og romsonder som forblir i bane, er det nødvendig å finne løsninger for å unngå kollisjoner og opprettholde renere baneområder.</i></p>
              <p><i>Mens denne oppgaven for øyeblikket ikke er en eksisterende oppgave, er den allerede en kilde til bekymring blant eksperter innen romfart og miljøvern. Imidlertid er det andre eksisterende oppgaver som krever umiddelbar oppmerksomhet, som klimaendringer, global helse og energiomstilling. Disse oppgavene har allerede store påvirkninger på vår verden, og det er avgjørende å jobbe for løsninger som kan håndtere dem effektivt.</i></p>
              <p><i>Mens vi ser frem mot potensielle nye oppgaver i fremtiden, er det like viktig å håndtere de nåværende utfordringene som samfunnet står overfor. Dette krever en helhetlig tilnærming, samarbeid og innovasjon for å sikre en bærekraftig fremtid for alle.</i></p>
              <p><i>[https://chat.openai.com]</i></p>
            </blockquote>
";
    }
    else 
    {
      $task_answer = R::findOne('taskanswer', ' user_id = ? AND task_id = ? ', [$user_id, $task->id]);
      if ($task_answer == null){
        $task_answer = R::dispense('taskanswer');
        $task_answer->user_id = $user_id;
        $task_answer->task_id = $task->id;
        $task_answer->show_hint1 = false;
        $task_answer->show_hint2 = false;
        $task_answer->correct_answer_time = 0;
      }
      $task_answer->ipaddr = $_SERVER['REMOTE_ADDR'];
      $task_answer->useragent = $_SERVER['HTTP_USER_AGENT'];

      // Calculate how many attempts are left
      $attemptsextra = intval($task->attemptsextra);
      $wronganswerscount = R::getRow('
              SELECT SUM(CASE WHEN extratask IS NOT 1 THEN 1 ELSE 0 END) AS wronganswerscount, SUM(extratask) AS wronganswersextracount
              FROM wronganswer
              WHERE task_id = ?
              AND user_id = ?'
          , [ $task->id, $user_id ]);
      $attemptsleft = max(intval($task->attempts) - intval($wronganswerscount['wronganswerscount']), 0);
      $attemptsextraleft = max(intval($task->attemptsextra) - intval($wronganswerscount['wronganswersextracount']), 0);

      $content = "";

      // If user submitted answer for extra task: check that the original task is answered first.
      if ($task->hasextratask && !empty($_POST['answerextra']) && $task_answer->correct_answer_time > 0)
      {
        if ($task_answer->correct_answerextra_time > 0)
        {
          $content .= "<div class=\"answerfeedback answercorrect\"><h3>Du har allerede svart korrekt på ekstraoppgaven</h3></div>";
        }
        else if ($attemptsextraleft <= 0)
        {
          $content .= "<div class=\"answerfeedback answerwrong\"><h3>Du har brukt opp alle forsøkene på ekstraoppgaven</h3></div>";
        }
        else 
        {
          $post_answerextra = trim($_POST['answerextra']);
          $same_answer  = R::getCell( '
              SELECT count(*)
              FROM wronganswer
              WHERE task_id = ?
              AND user_id = ?
              AND LOWER(wrong_answer) = LOWER(?)
              AND extratask IS TRUE'
              , [ $task->id, $user_id, $post_answerextra ]);
          if ($same_answer > 0)
          {
            $content .= "<div class=\"answerfeedback\"><h3>Du har allerede forøkt dette svaret på ekstraoppgaven</h3></div>";
          }
          else if (mb_strtolower($post_answerextra, 'UTF-8') === mb_strtolower($task->answerextra, 'UTF-8'))
          {
            $task_answer->correct_answerextra_time = time();
            
            $task_answer->score = $task_answer->score + $task->valueextra;
            R::store($task_answer);

            $content .= "
            <div class=\"answerfeedback answercorrect\">
              <h2>Korrekt!</h2>
              <h3>Du fikk $task->valueextra ekstra poeng</h3>
            </div>";
          }
          else
          {
            $wrong_answer = R::dispense('wronganswer');
            $wrong_answer->user_id = $user_id;
            $wrong_answer->task_id = $task->id;
            $wrong_answer->extratask = true;
            $wrong_answer->wrong_answer = $post_answerextra;
            $wrong_answer->wrong_time = time();
            $wrong_answer->ipaddr = $_SERVER['REMOTE_ADDR'];
            $wrong_answer->useragent = $_SERVER['HTTP_USER_AGENT'];
            R::store($wrong_answer);
            $attemptsextraleft -= 1;
            $content .= "<div class=\"answerfeedback answerwrong\"><h3>Feil svar!</h3></div>";
          }
        }
      }
      else if (isset($_POST['answer']) && !empty($_POST['answer']))
      {
        if ($task_answer->correct_answer_time > 0)
        {
          $content .= "<div class=\"answerfeedback answercorrect\"><h3>Du har allerede svart korrekt på denne oppgaven</h3></div>";
        }
        else if ($attemptsleft <= 0)
        {
          $content .= "<div class=\"answerfeedback answerwrong\"><h3>Du har brukt opp alle forsøkene på denne oppgaven</h3></div>";
        }
        else {
          $post_answer = trim($_POST['answer']);
          $same_answer  = R::getCell( '
              SELECT count(*)
              FROM wronganswer
              WHERE task_id = ?
              AND user_id = ?
              AND LOWER(wrong_answer) = LOWER(?)
              AND extratask IS NOT TRUE'
              , [ $task->id, $user_id, $post_answer ]);
          if ($same_answer > 0)
          {
            $content .= "<div class=\"answerfeedback\"><h3>Du har allerede forøkt dette svaret på oppgaven</h3></div>";
          }
          else
          {
            $correctanswer = false;
            $taskanswersplit = explode("|", $task->answer);
            foreach ($taskanswersplit as $taskanswer) {
              if (mb_strtolower(trim($_POST['answer']), 'UTF-8') === mb_strtolower($taskanswer, 'UTF-8'))
              {
                $correctanswer = true;
                break;
              }
            }
            if ($correctanswer){
              $task_answer->correct_answer_time = time();
              $task_answer->correct_answer_sec = $task_answer->correct_answer_time - $task->release_time;
                $task_answer->score = $task->value;
                if ($task_answer->show_hint2)
                  $task_answer->score = 0;
                else if ($task_answer->show_hint1)
                  $task_answer->score = max($task_answer->score - 5, 0);
                R::store($task_answer);

                $content .= "
                <div class=\"answerfeedback answercorrect\">
                  <h2>Korrekt!</h2>
                  <h3>Du fikk $task_answer->score poeng</h3>
                </div>";
            } else {
              $wrong_answer = R::dispense('wronganswer');
              $wrong_answer->user_id = $user_id;
              $wrong_answer->task_id = $task->id;
              $wrong_answer->extratask = false;
              $wrong_answer->wrong_answer = $_POST['answer'];
              $wrong_answer->wrong_time = time();
              $wrong_answer->ipaddr = $_SERVER['REMOTE_ADDR'];
              $wrong_answer->useragent = $_SERVER['HTTP_USER_AGENT'];
              R::store($wrong_answer);
              $attemptsleft -= 1;
              $content .= "<div class=\"answerfeedback answerwrong\"><h3>Feil svar!</h3></div>";
            }
          }
        }
      }
      
      if (isset($_POST['show_hint1']) && $_POST['show_hint1'] == "1")
        $task_answer->show_hint1 = true;
      
      if (isset($_POST['show_hint2']) && $_POST['show_hint2'] == "1")
        $task_answer->show_hint2 = true;
      
      if (! $task_answer->correct_answer_time > 0)
        R::store($task_answer);

      $task_value = $task->value;
      if ($task_answer->show_hint1)
        $task_value = max($task_value - 5, 0);
      if ($task_answer->show_hint2)
        $task_value = 0;
      
      $taskcorrect = "";
      $disabled_answer = "";
      $disabled_answerextra = "";
      if ($task_answer->correct_answer_time > 0 || $attemptsleft <= 0 )
      {
        $taskcorrect = "taskcorrect";
        $disabled_answer = "disabled";
      }
      if ($task_answer->correct_answerextra_time > 0 || $attemptsextraleft <= 0 )
        $disabled_answerextra = "disabled";
      
      
      $content .= "<div class=\"header\"><h2>".$_GET['dag']."</h2>
          </div>\n";

      if ($task_answer->correct_answer_time == 0 && !isset($_GET['extraoverstyring']))
      {
        $content .= "              <div style=\"float:right; text-align:right; padding: 1em;\">Verdi: $task_value poeng</div>";
      }
      else
      {
        if ($task->hasextratask)
        {
          $content .= "         <div style=\"float:right; text-align:right; padding: 1em;\">";
          if ($task_answer->correct_answerextra_time == 0){
            $content .= "Verdi: $task->valueextra poeng";
          } else {
            $content .= "Fullført ekstraoppgave!<br>";
            $solvedcount = R::getCell( '
              SELECT count(*)
              FROM taskanswer
              WHERE task_id = ? 
              AND user_id <> ?
              AND correct_answerextra_time > 0'
              , [ $task->id, $user_id ]);
            if ($solvedcount > 0)
              $content .= $solvedcount . " andre har løst den";
            else
              $content .= "<b>Ingen</b> andre har løst den!";
          }
          $content .= "         </div>
          <div class=\"content taskcontent taskextra\">
            <h2 class=\"content-subhead taskcontent-subhead\">Ekstraoppgave!!!</h2>
            <p>$task->descriptionextra</p>
          </div>
          <form method=\"POST\" action=\"#ekstrasvar\" class=\"pure-form\">
            <div> 
              <div style=\"display: grid; grid-template-columns: 5em auto 6em; column-gap: 1em;\">
                <label for=\"answerextra\" style=\"grid-column: 1; \">Ekstrasvar</label>
                <input type=\"text\" id=\"answerextra\" name=\"answerextra\" style=\"grid-column: 2;\" $disabled_answerextra>
                <button type=\"submit\" class=\"pure-button pure-button-primary\" style=\"grid-column: 3; margin: 0px;\" $disabled_answerextra>Svar</button>
                <span style=\"grid-column: 2; text-align: right; margin: 0px; \">Du har $attemptsextraleft forsøk igjen</span>
              </div>
            </div>  
          </form>
          <br>
          <hr>
          <br>
          <br>
";
        }
        
        $content .= "              <div style=\"float:right; text-align:right; padding: 1em;\">\n";
        $content .= "Fullført oppgave!<br>";
        $solvedcount = R::getCell( '
          SELECT count(*)
          FROM taskanswer
          WHERE task_id = ? 
          AND user_id <> ?
          AND correct_answer_time > 0'
          , [ $task->id, $user_id ]);
        
        if ($solvedcount > 0)
          $content .= $solvedcount . " andre har løst den";
        else
          $content .= "<b>Ingen</b> andre har løst den!";
        $content .= "</div>\n";
      }
      $content .= "          <div class=\"content taskcontent $taskcorrect\">
            <h2 class=\"content-subhead taskcontent-subhead\" style=\"margin-top: 2.8em; \">$task->title</h2>
            <p>$task->description</p>
          </div>
            <form method=\"POST\" action=\"#svar\" class=\"pure-form\">
              <div>
               <div style=\"display: grid; grid-template-columns: 3em auto 6em; column-gap: 1em;\">
                  <label for=\"answer\" style=\"grid-column: 1;\">Svar</label>
                  <input type=\"text\" id=\"answer\" name=\"answer\" style=\"grid-column: 2;\" $disabled_answer>
                  <button type=\"submit\" class=\"pure-button pure-button-primary\" style=\"grid-column: 3; margin: 0px; \" $disabled_answer>Svar</button>
                  <span style=\"grid-column: 2; text-align: right; margin: 0px; \">Du har $attemptsleft forsøk igjen</span>
                </div>
              </div>  
            </form>
            <br>
            <hr>
            <div>
              <h2 class=\"content-subhead\">Hint 1 (-5 poeng)</h2>
";
      if ($task_answer->show_hint1)
      {
        $content .= "              <a id=\"hint1\"><p>$task->hint1</p></a>
              <h2 class=\"content-subhead\">Hint 2 (0 poeng)</h2>\n";
        if ($task_answer->show_hint2){
          $content .= "              <a id=\"hint2\"><p>$task->hint2</p></a>\n";
        }
        else
        {
          $content .= "                  <form method=\"POST\" action=\"#hint2\" class=\"pure-form\">
                    <input type=\"hidden\" name=\"show_hint1\" value=\"1\">
                    <input type=\"hidden\" name=\"show_hint2\" value=\"1\">
                    <div style=\"display: grid;\">
                      <button type=\"submit\" class=\"pure-button\" style=\"grid-column: 1; grid-row: 1; width: 150px; height: 40px; margin: 0;\">Helt sikker?</button>
                      <button type=\"button\" class=\"pure-button\" style=\"grid-column: 1; grid-row: 1; width: 150px; height: 40px; margin: 0;\" onclick=\"this.hidden=true\">Vis hint 2</button>
                    </div>
                  </form>
";
        }
      } 
      else 
      {
        $content .= "              <form method=\"POST\" action=\"#hint1\" class=\"pure-form\">
                <input type=\"hidden\" name=\"show_hint1\" value=\"1\">
                <div style=\"display: grid;\">
                  <button type=\"submit\" class=\"pure-button\" style=\"grid-column: 1; grid-row: 1; width: 150px; height: 40px; margin: 0;\">Helt sikker?</button>
                  <button type=\"button\" class=\"pure-button\" style=\"grid-column: 1; grid-row: 1; width: 150px; height: 40px; margin: 0;\" onclick=\"this.hidden=true\">Vis hint 1</button>
                </div>
              </form>
";
      }
      
      $content .= "            </div>
          </div>\n";
      
      $previous_task = R::findOne('task' , ' release_time <= ? AND release_time < ? ORDER BY release_time DESC', [time(), $task->release_time] );
      $next_task = R::findOne('task' , ' release_time <= ? AND release_time > ? ORDER BY release_time ASC', [time(), $task->release_time] );
      $content .= "<div class=\"content\">";
      $content .= "            <br>\n";
      $content .= "            <hr>\n";
      $content .= "            <br>\n";
      if ($previous_task != null)
        $content .= "<form method=\"GET\"><input type=\"hidden\" name=\"dag\" value=\"" . $previous_task->day . "\"><button class=\"pure-button\" style=\"float: left; width: 49%; max-width: 150px; padding: 20px; text-align: center;\">" . $previous_task->day . "</button>";
      if ($next_task != null)
        $content .= "<form method=\"GET\"><input type=\"hidden\" name=\"dag\" value=\"" . $next_task->day . "\"><button class=\"pure-button\" style=\"float: right; width: 49%; max-width: 150px; padding: 20px; text-align: center;\">" . $next_task->day . "</button>";
    }
  }
  else
  {
    $content = null;
  }
}

require 'menu.php';
?>
    <div id="main">
        <div class="header siteheader">
            <h1><?php echo $page_title; ?></h1>
            <h2><?php echo $page_subtitle; ?></h2>
        </div>
        <div class="content">
<?php 
if ($content != null)
  echo $content; 
else
  include("tiles.php");
?>
        </div><!--class="content"-->
    </div><!--id="main"-->
<?php
require 'foot.php';
?>