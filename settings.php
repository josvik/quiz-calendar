<?php 
  define('DATABASEFILE', 'example1.db');
  
  define('MAIL_HOST', 'mail.quiz-calendar.none');
  define('MAIL_USERNAME', 'post@quiz-calendar.none');
  define('MAIL_PASSWORD', 'password');
  define('MAIL_FROMEMAIL', 'post@quiz-calendar.none');
  define('MAIL_FROMNAME', 'Quiz-calendar');
  define('MAIL_REPLYTOEMAIL', 'post@quiz-calendar.none');
  define('MAIL_REPLYTOENAME', 'post@quiz-calendar.none');
  
  define('TIMEZONE', new DateTimeZone('Europe/Oslo'));
  
  define('CALENDAR_ROWS', 6);
  define('CALENDAR_COLS', 4);
  //Images tiles in format: CALENDAR_BG . "-$col-$row.png"
  define('CALENDAR_BG', "bg/bg");
?>