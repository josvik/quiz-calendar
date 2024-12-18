<?php 


function sanitizeInput($input) {
  $input = trim($input);
  $input = stripslashes($input);
  $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
  return $input;
}

function validateEmail($email) {
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "E-post not valid";
    return False;
  }
  /* Check the domain. */
  $atPos = mb_strpos($email, '@');
  $domain = mb_substr($email, $atPos + 1);
  if (!checkdnsrr($domain . '.', 'MX')) {
    echo "E-post er ikke gyldig";
    return False;
  }
  return True;
}

function getBaseUrl(){
  $baseurl = "http://";
  if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $baseurl = "https://";
  }
  $baseurl = $baseurl . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
  $baseurl = substr($baseurl, 0, strrpos($baseurl, "/")) . "/";
  return($baseurl);
}

function getDaysHoursMinutesFromSeconds($seconds) {
  $seconds = intval($seconds);
  $timeused_days = floor($seconds / 86400);
  $seconds -= $timeused_days * 86400;
  $timeused_hours = floor($seconds / 3600);
  $seconds -= $timeused_hours * 3600;
  $timeused_minutes = floor($seconds / 60);
  $seconds -= $timeused_minutes * 60;

  $timeused = "";
  if ($timeused_days > 0) {
    $timeused .= $timeused_days . "d " . $timeused_hours . "t";
  } elseif ($timeused_hours > 0) {
    $timeused .= $timeused_hours . "t " . $timeused_minutes . "m";
  } elseif ($timeused_minutes > 0) {
    $timeused .= $timeused_minutes . "m " . $seconds . "s";
  }
  return $timeused;
}
?>