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
    <h2>Info</h2>
<?php
echo $texts["info_time"];

echo $texts["info_prices"];

echo $texts["info_points"];

echo $texts["info_groups"];

echo $texts["info_rules"];

echo "<br><hr>";

echo $texts["info_questions"];
?>
        </div><!--class="content"-->
    </div><!--id="main"-->
<?php
require 'foot.php';
?>