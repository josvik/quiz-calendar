<?PHP
  require 'PHPMailer/src/Exception.php';
  require 'PHPMailer/src/PHPMailer.php';
  require 'PHPMailer/src/SMTP.php';
  
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

function getauthtokenandemail($user) {
    $authtokenandemail = "?authtoken=" . $user->newauthtoken . "&email=" . urlencode($user->email);
    return $authtokenandemail;
}

function getloginurl($user) {
    $baseurl = getBaseUrl();
    $loginurl = $baseurl . "login.php" . getauthtokenandemail($user);
    return $loginurl;
}

function getdeletemeurl($user) {
    $baseurl = getBaseUrl();
    $deletemeurl = $baseurl . "deleteme.php" . getauthtokenandemail($user);
    return $deletemeurl;
}

function sendLogin($user) {
    $login_url = getloginurl($user);
    $deleteme_url = getdeletemeurl($user);

    if (isset($_GET["joingroup"]))
        $login_url .= "&joingroup=" . $_GET["joingroup"];
    $subject = 'Takk. Her er din innloggingslenke!';
    $content = "<h3>Hei " . $user->name . "</h3>
        <p>Velkommen til quiz-kalender.</p>
        <p>Bruk lenken under for å logge inn. <br>Du kan også bruke denne lenken til å logge inn fra andre enheter</p>
        <p><a href=\"" . $login_url . "\">" . $login_url . "</a></p>
        <h3>Nyhet!</h3>
        <p>Nå kan du konkurrere i bander!<br>
        Du kan konkurrere både innad i banden og utad mot andre bander. <br>
        Gå inn på Profil-siden for å opprette og melde deg inn i bander. <br>
        Lag bander for kollegaene, idrettslaget, bygda eller søskenflokken. <br>
        Du kan til og med bli medlem i flere bander.<br></p>
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
    //print("<pre>");
    //print($mailContent);
    //print("</pre>");
    return $mail->send();
  }
}
?>