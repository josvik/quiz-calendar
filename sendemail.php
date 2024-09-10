<?PHP
  require 'PHPMailer/src/Exception.php';
  require 'PHPMailer/src/PHPMailer.php';
  require 'PHPMailer/src/SMTP.php';
  
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

function sendLogin($user) {
    $baseurl = getBaseUrl();
    $authtokenandemail = "?authtoken=" . $user->newauthtoken . "&email=" . urlencode($user->email);
    $login_url = $baseurl . "login.php" . $authtokenandemail;
    $deleteme_url = $baseurl . "deleteme.php" . $authtokenandemail;
      
    $subject = 'Takk. Her er din innloggingslenke!';
    $content = "<h3>Hei " . $user->name . "</h3>
        <p>Velkommen til quiz-kalender.</p>
        <p>Bruk lenken under for å logge inn. <br>Du kan også bruke denne lenken til å logge inn fra andre enheter</p>
        <p><a href=\"" . $login_url . "\">" . $login_url . "</a></p>
        <p>Lykke til, og husk å sjekke dagens oppgave hver dag.</p>
        <hr>
        <p>Hvis du ikke har bedt om denne e-posten kan du trygt slette den.</p>
        <hr>
        <p>Hvis du ønsker å slette dine data kan du bruke følgende lenke<br><a href=\"" . $deleteme_url . "\">Slett meg</a></p>
        ";

    return sendEmail($user, $subject, $content);
}

function sendEmail($user, $mailSubject, $mailContent) {
  if ($user != null) {
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = MAIL_HOST;
    $mail->SMTPAuth = true;
    $mail->Username = MAIL_USERNAME;
    $mail->Password = MAIL_PASSWORD;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;
    
    $mail->setFrom(MAIL_FROMEMAIL, MAIL_FROMNAME);
    $mail->addReplyTo(MAIL_REPLYTOEMAIL, MAIL_REPLYTOENAME);
    $mail->addAddress($user->email, $user->name);
    $mail->Subject = $mailSubject;
    $mail->isHTML(true);
    $mail->Body = $mailContent;
    
    echo "<p>";
    if($mail->send()){
      echo 'En e-post er sendt til ' . $user->email;
      return True;
    } else {
      echo 'E-post kan ikke sendes.<br><br>';
      echo 'Feilmelding: <br>' . $mail->ErrorInfo;
      return False;
    }
    echo "</p>";
  }
}
?>