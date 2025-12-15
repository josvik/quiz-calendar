<?php 
  require 'settings.php';
  require 'RedBeanPHP/rb-sqlite.php';
  R::setup( 'sqlite:' . DATABASEFILE );
  //require 'RedBeanPHP/rb-mysql.php';
  //R::setup( 'mysql:host=localhost;dbname=mysqldatabase', 'username', 'password' );
  
  function dbGetUser($authtoken) {
    $user = R::findOne('user', ' authtoken = ?', [$authtoken] );
    return $user;
  }
  
  function dbGetActiveTasks() {
    $time = time();
    $activetasks = R::getAll( '
      SELECT id, day
      FROM task
      WHERE release_time <= ?
      AND hide_time > ?
      ORDER BY release_time ASC'
      , [ $time, $time ]);
    return $activetasks;
  }
  
  function dbGetSolvedTasks($user_id) {
    $solvedtasks = R::getAssoc( '
      SELECT task_id, correct_answerextra_time
      FROM taskanswer
      WHERE user_id = ?
      AND correct_answer_time > 0'
      , [ $user_id ]);
    return $solvedtasks;
  }

  function dbGetPreviousTask($task_time) {
    $time = time();
    return R::findOne('task' , '
      release_time <= ?
      AND hide_time > ?
      AND release_time < ?
      ORDER BY release_time DESC'
      , [$time, $time, $task_time] );
  }

  function dbGetNextTask($task_time) {
    $time = time();
    return R::findOne('task' , '
      release_time <= ?
      AND hide_time > ?
      AND release_time > ?
      ORDER BY release_time ASC'
      , [$time, $time, $task_time] );
  }
?>