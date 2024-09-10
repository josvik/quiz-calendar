<?PHP

if (isset($_POST["loggut"])) {
  require 'common.php';
  setcookie('token', '', time()-3600);
  $baseurl = getBaseUrl();
  header('Location: ' . $baseurl);
}

  require 'head.php';
  require 'menu.php';
?>
    <div id="main">
        <div class="header siteheader">
            <h1><?php echo $page_title; ?></h1>
            <h2><?php echo $page_subtitle; ?></h2>
        </div>
        <div class="content">
          <h2 class="content-subhead">Logg ut?</h2>
          <form method="POST" class="pure-form">
            <br>
            <div>
              <button type="submit" name="loggut" style="left: 10%;position: relative;padding: 5px">&nbsp;Logg ut&nbsp;</button>
            </div>
            <br>
          </form>
        </div>
    </div>
</body>
</html>
