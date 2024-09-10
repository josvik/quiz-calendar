<?php
require 'head.php';
require 'menu.php';
?>
    <div id="main">
        <div class="header siteheader">
            <h1><?php echo $page_title; ?></h1>
            <h2><?php echo $page_subtitle; ?></h2>
        </div>
        <div class="content">
<?php
if (!$logged_in) 
{
  
  echo $not_logged_in_message;
  
} else {
  include("scoreboard.php");
  echo "<br><br><br>";
  include("mypoints.php");
}
?>
        </div><!--class="content"-->
    </div><!--id="main"-->
<?php
require 'foot.php';
?>