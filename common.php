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
  echo $_SERVER['SERVER_PROTOCOL'] . "<br>";
  $baseurl = "http://";
  if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
    $baseurl = "https://";
  }
  $baseurl = $baseurl . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
  $baseurl = substr($baseurl, 0, strrpos($baseurl, "/")) . "/";
  return($baseurl);
}
?>