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
    $base_url = getBaseUrl();
    $login_url = getloginurl($user);
    //print($login_url);
    $deleteme_url = getdeletemeurl($user);

    if (isset($_GET["joingroup"]))
        $login_url .= "&joingroup=" . $_GET["joingroup"];
    $subject = 'Velkommen til Quiz-kalender - Logg inn her';
    $content = "<h3>Hei " . $user->newname . "</h3>
        <p>Velkommen til quiz-kalender 🎅</p>
        <p>For å logge inn, bruk lenken nedenfor:</p>
        <p><a href=\"" . $login_url . "\">" . $login_url . "</a></p>
        <p>Du kan også bruke denne lenken fra andre enheter.<br>
            Når du har logget inn én gang, forblir du innlogget i 30 dager
            og kan enkelt gå til <a href=\"" . $base_url . "\">" . $base_url . "</a> for å sjekke dagens oppgave. <br></p>
        <p><b>🏅 Konkurrer i lag!</b><br>
        Gjør quizen enda morsommere ved å konkurrere sammen med venner, kollegaer eller familien.<br>
        Opprett eller bli med i et lag på Profil-siden, og se hvem som blir den beste!</p>
        <p>Lykke til – og husk å sjekke dagens oppgave hver dag.</p>
        <hr>
        <p>Hvis du ikke har bedt om denne e-posten, kan du trygt ignorere den.</p>
        <p>Ønsker du å slette dine data? Klikk her: <a href=\"" . $deleteme_url . "\">[Slett meg]</a></p>
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