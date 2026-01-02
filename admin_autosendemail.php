<?php
require 'init_page.php';
?>
<?php
if ($logged_in && $is_admin)
{
$mails = [
    "welcome_easter" => ["mailsubject" => "Ny runde med Quiz-kalender",
                "userWhere" => " WHERE sendemailnextevent = 1",
                "mailContent" => "<h3>Gjør påsken ekstra spennende med Quiz-kalender 🐣</h3>
                                  <p>Etter stor entusiasme i quiz-kalenderen til jul, inviterer vi til nye utfordringer med logikk, kunnskap og kreativitet hver dag i påsken. Enten du løser oppgavene alene eller konkurrerer sammen med venner, familie eller kollegaer, er dette en morsom måte å gjøre påsken enda mer underholdende.  Inviter gjerne med flere!</p>
                                  <p>Klarer du å holde poengsummen oppe gjennom hele perioden?</p>
                                  <p>📅Når: fre 11. april - søn 20.april<br>⏰Tidspunkt: Nye oppgaver hver dag kl. 10:00<br>⏳Frist for å svare: 21. april kl. 23:59</p>
                                  <p>Registrer deg i dag på <a href=\"https://quiz.josvik.no/\">https://quiz.josvik.no/</a></p>
                                  <p>Lykke til – og ha en morsom og utfordrende påske! 🐣✨</p>
                                  <hr>
                                  <p><i>Du mottar denne e-posten fordi du har deltatt på en tidligere quiz-kalender.</i></p>
                                  "],

    "welcome-28.nov" => ["mailsubject" => "Snart starter Quiz-kalender!",
                "userWhere" => " WHERE sendemailnextevent = 1",
                "mailContent" => "<h3>Julens Quiz-kalender er like rundt hjørnet! 🎅</h3>
                                  <p>På mandag er det 1. desember. Og tradisjon tro blir det også i år Quiz-kalender med underfundige oppgaver hver dag.</p>
                                  <p>Gå inn på <a href=\"https://quiz.josvik.no/\" target=\"_blank\">quiz.josvik.no</a> for å registrere deg så du er klar til mandag.
                                  Som tidligere er det særdeles vidspendte oppgaver hver dag frem til julaften.</p>
                                  <p><b>Inviterer alle rundt deg og bli med på en spennende julekalender.</b></p>
                                  <p><i>Hilsen Jostein<br>Quiz-bas</i></p>
                                  "],

    "1.des" => ["mailsubject" => "Quiz-kalender - ny oppgave: 1.desember",
                "userWhere" => " WHERE sendemail = 1",
                "mailContent" => "<h3>Velkommen til årets Quiz-kalender! ☃️</h3>
                                  <p>I første luke skal vi rote litt rundt med substitutter.</p>
                                  <p>Løs dagens oppgave på <a href=\"https://quiz.josvik.no/\">https://quiz.josvik.no/</a><br>
                                  Lykke til, og husk å sjekke dagens oppgave hver dag i adventstiden.</p>
                                  <p>PS: Spre ordet om quiz-kalenderen og få med flere.</p>
                                  <hr>
                                  <p><i>Om du ikke ønsker disse varslene kan du endre det under Profil-siden.</i></p>
                                  "],

    "2.des" => ["mailsubject" => "Quiz-kalender - ny oppgave: 2.desember",
                "userWhere" => " WHERE sendemail = 1",
                "mailContent" => "<h3>Quiz-kalender 2.desember - System 🏷️</h3>
                                  <p>I dagens luke skal systemeringsegenskapene utfordres.</p>
                                  <p>Løs dagens oppgave på <a href=\"https://quiz.josvik.no/\">https://quiz.josvik.no/</a><br>
                                  Lykke til, og husk å sjekke dagens oppgave hver dag i adventstiden.</p>
                                  <p>PS: Spre ordet om quiz-kalenderen og få med flere.</p>
                                  <hr>
                                  <p><i>Om du ikke ønsker disse varslene kan du endre det under Profil-siden.</i></p>
                                  "],

    "3.des" => ["mailsubject" => "Quiz-kalender - ny oppgave: 3.desember",
                "userWhere" => " WHERE sendemail = 1",
                "mailContent" => "<h3>Quiz-kalender 3.desember - Tegnsetting 🔠️</h3>
                                  <p>En sentral del i boktrykkerkunsten mangler.</p>
                                  <p>Løs dagens oppgave på <a href=\"https://quiz.josvik.no/\">https://quiz.josvik.no/</a><br>
                                  Lykke til, og husk å sjekke dagens oppgave hver dag i adventstiden.</p>
                                  <p>PS: Spre ordet om quiz-kalenderen og få med flere.</p>
                                  <hr>
                                  <p><i>Om du ikke ønsker disse varslene kan du endre det under Profil-siden.</i></p>
                                  "],

    "4.des" => ["mailsubject" => "Quiz-kalender - ny oppgave: 4.desember",
                "userWhere" => " WHERE sendemail = 1",
                "mailContent" => "<h3>Quiz-kalender 4.desember - bare pauddo</h3>
                                  <p>Svaret i dag er ett ord, og ordet beskriver noe vi gjør hver dag.</p>
                                  <p>Løs dagens oppgave på <a href=\"https://quiz.josvik.no/\">https://quiz.josvik.no/</a><br>
                                  Lykke til, og husk å sjekke dagens oppgave hver dag i adventstiden.</p>
                                  <p>PS: Spre ordet om quiz-kalenderen og få med flere.</p>
                                  <hr>
                                  <p><i>Om du ikke ønsker disse varslene kan du endre det under Profil-siden.</i></p>
                                  "],

    "5.des" => ["mailsubject" => "Quiz-kalender - ny oppgave: 5.desember",
                "userWhere" => " WHERE sendemail = 1",
                "mailContent" => "<h3>Quiz-kalender 5.desember - Omriss 〽️</h3>
                                  <p>Svaret i dag er også ett ord.</p>
                                  <p>Løs dagens oppgave på <a href=\"https://quiz.josvik.no/\">https://quiz.josvik.no/</a><br>
                                  Lykke til, og husk å sjekke dagens oppgave hver dag i adventstiden.</p>
                                  <p>PS: Spre ordet om quiz-kalenderen og få med flere.</p>
                                  <hr>
                                  <p><i>Om du ikke ønsker disse varslene kan du endre det under Profil-siden.</i></p>
                                  "],

    "6.des" => ["mailsubject" => "Quiz-kalender - ny oppgave: 6.desember",
                "userWhere" => " WHERE sendemail = 1",
                "mailContent" => "<h3>Quiz-kalender 6.desember - Løpetur 🏃️</h3>
                                  <p>På en løpetur i sommer kom jeg over noen fantastiske trær med en helt nydelig utsikt.</p>
                                  <p>Løs dagens oppgave på <a href=\"https://quiz.josvik.no/\">https://quiz.josvik.no/</a><br>
                                  Lykke til, og husk å sjekke dagens oppgave hver dag i adventstiden.</p>
                                  <p>PS: Spre ordet om quiz-kalenderen og få med flere.</p>
                                  <hr>
                                  <p><i>Om du ikke ønsker disse varslene kan du endre det under Profil-siden.</i></p>
                                  "],

    "7.des" => ["mailsubject" => "Quiz-kalender - ny oppgave: 7.desember",
                "userWhere" => " WHERE sendemail = 1",
                "mailContent" => "<h3>Quiz-kalender 7.desember - Klokka ramla ned 🕒</h3>
                                  <p>Ånei, klokka ramla ned fra veggen.</p>
                                  <p>Løs dagens oppgave på <a href=\"https://quiz.josvik.no/\">https://quiz.josvik.no/</a><br>
                                  Lykke til, og husk å sjekke dagens oppgave hver dag i adventstiden.</p>
                                  <p>PS: Spre ordet om quiz-kalenderen og få med flere.</p>
                                  <hr>
                                  <p><i>Om du ikke ønsker disse varslene kan du endre det under Profil-siden.</i></p>
                                  "],

    "8.des" => ["mailsubject" => "Quiz-kalender - ny oppgave: 8.desember",
                "userWhere" => " WHERE sendemail = 1",
                "mailContent" => "<h3>Quiz-kalender 8.desember - Kodedikt 📜</h3>
                                  <p>Dette er nok en helt ny diktform, for diktet har ingen annen funksjon enn å gjemme en kode.</p>
                                  <p>Løs dagens oppgave på <a href=\"https://quiz.josvik.no/\">https://quiz.josvik.no/</a><br>
                                  Lykke til, og husk å sjekke dagens oppgave hver dag i adventstiden.</p>
                                  <p>PS: Spre ordet om quiz-kalenderen og få med flere.</p>
                                  <hr>
                                  <p><i>Om du ikke ønsker disse varslene kan du endre det under Profil-siden.</i></p>
                                  "],

    "9.des" => ["mailsubject" => "Quiz-kalender - ny oppgave: 9.desember",
                "userWhere" => " WHERE sendemail = 1",
                "mailContent" => "<h3>Quiz-kalender 9.desember - Kjekkas 🐸</h3>
                                  <p>Nå skal vi hilse på en kjekkas som var å se på barneTV for flere tiår siden.</p>
                                  <p>Løs dagens oppgave på <a href=\"https://quiz.josvik.no/\">https://quiz.josvik.no/</a><br>
                                  Lykke til, og husk å sjekke dagens oppgave hver dag i adventstiden.</p>
                                  <p>PS: Spre ordet om quiz-kalenderen og få med flere.</p>
                                  <hr>
                                  <p><i>Om du ikke ønsker disse varslene kan du endre det under Profil-siden.</i></p>
                                  "],

    "10.des" => ["mailsubject" => "Quiz-kalender - ny oppgave: 10.desember",
                "userWhere" => " WHERE sendemail = 1",
                "mailContent" => "<h3>Quiz-kalender 10.desember - Sortering i julestria 🔀</h3>
                                  <p>Så har det skjedd igjen. Rydding og sortering i julestria har gått for langt og sortert en kjent julesang i alfabetisk rekkefølge.</p>
                                  <p>Løs dagens oppgave på <a href=\"https://quiz.josvik.no/\">https://quiz.josvik.no/</a><br>
                                  Lykke til, og husk å sjekke dagens oppgave hver dag i adventstiden.</p>
                                  <p>PS: Spre ordet om quiz-kalenderen og få med flere.</p>
                                  <hr>
                                  <p><i>Om du ikke ønsker disse varslene kan du endre det under Profil-siden.</i></p>
                                  "],

    "11.des" => ["mailsubject" => "Quiz-kalender - ny oppgave: 11.desember",
                "userWhere" => " WHERE sendemail = 1",
                "mailContent" => "<h3>Quiz-kalender 11.desember - Olaf Sand 👨‍🌾</h3>
                                  <p>«Navnet e Olaf Sand. Nei, Olaf med A»</p>
                                  <p>Løs dagens oppgave på <a href=\"https://quiz.josvik.no/\">https://quiz.josvik.no/</a><br>
                                  Lykke til, og husk å sjekke dagens oppgave hver dag i adventstiden.</p>
                                  <p>PS: Spre ordet om quiz-kalenderen og få med flere.</p>
                                  <hr>
                                  <p><i>Om du ikke ønsker disse varslene kan du endre det under Profil-siden.</i></p>
                                  "],

    "12.des" => ["mailsubject" => "Quiz-kalender - ny oppgave: 12.desember",
                "userWhere" => " WHERE sendemail = 1",
                "mailContent" => "<h3>Quiz-kalender 12.desember - Omriss 2 〽️</h3>
                                  <p>Svaret i dag er også ett ord.</p>
                                  <p>Løs dagens oppgave på <a href=\"https://quiz.josvik.no/\">https://quiz.josvik.no/</a><br>
                                  Lykke til, og husk å sjekke dagens oppgave hver dag i adventstiden.</p>
                                  <p>PS: Spre ordet om quiz-kalenderen og få med flere.</p>
                                  <hr>
                                  <p><i>Om du ikke ønsker disse varslene kan du endre det under Profil-siden.</i></p>
                                  "],

    "13.des" => ["mailsubject" => "Quiz-kalender - ny oppgave: 13.desember",
                "userWhere" => " WHERE sendemail = 1",
                "mailContent" => "<h3>Quiz-kalender 13.desember - Bensinpris ⛽️</h3>
                                  <p>Dagens oppgave handler om å fylle tanken på min Audi 80.</p>
                                  <p>Løs dagens oppgave på <a href=\"https://quiz.josvik.no/\">https://quiz.josvik.no/</a><br>
                                  Lykke til, og husk å sjekke dagens oppgave hver dag i adventstiden.</p>
                                  <p>PS: Spre ordet om quiz-kalenderen og få med flere.</p>
                                  <hr>
                                  <p><i>Om du ikke ønsker disse varslene kan du endre det under Profil-siden.</i></p>
                                  "],

    "14.des" => ["mailsubject" => "Quiz-kalender - ny oppgave: 14.desember",
                "userWhere" => " WHERE sendemail = 1",
                "mailContent" => "<h3>Quiz-kalender 14.desember - Verdien av julestemning ✨🎄</h3>
                                  <p>Dagens oppgave handler om å beregne hvor stor julestemning et ord har.</p>
                                  <p>Løs dagens oppgave på <a href=\"https://quiz.josvik.no/\">https://quiz.josvik.no/</a><br>
                                  Lykke til, og husk å sjekke dagens oppgave hver dag i adventstiden.</p>
                                  <p>PS: Spre ordet om quiz-kalenderen og få med flere.</p>
                                  <hr>
                                  <p><i>Om du ikke ønsker disse varslene kan du endre det under Profil-siden.</i></p>
                                  "],

    "15.des" => ["mailsubject" => "Quiz-kalender - ny oppgave: 15.desember",
                "userWhere" => " WHERE sendemail = 1",
                "mailContent" => "<h3>Quiz-kalender 15.desember - Mange dyr i arken 🦦</h3>
                                  <p>Noen dyr finnes, andre dyr er rent oppspinn. I dagens oppgave må du finne ut hvem som er hva.</p>
                                  <p>Løs dagens oppgave på <a href=\"https://quiz.josvik.no/\">https://quiz.josvik.no/</a><br>
                                  Lykke til, og husk å sjekke dagens oppgave hver dag i adventstiden.</p>
                                  <p>PS: Spre ordet om quiz-kalenderen og få med flere.</p>
                                  <hr>
                                  <p><i>Om du ikke ønsker disse varslene kan du endre det under Profil-siden.</i></p>
                                  "],

    "16.des" => ["mailsubject" => "Quiz-kalender - ny oppgave: 16.desember",
                "userWhere" => " WHERE sendemail = 1",
                "mailContent" => "<h3>Quiz-kalender 16.desember - Kodet langlinje ☲</h3>
                                  <p>En langlinjet kodet melding som utgir seg for å være noe annet, men vi skal frem til et ord på ni bokstaver.</p>
                                  <p>Løs dagens oppgave på <a href=\"https://quiz.josvik.no/\">https://quiz.josvik.no/</a><br>
                                  Lykke til, og husk å sjekke dagens oppgave hver dag i adventstiden.</p>
                                  <p>PS: Spre ordet om quiz-kalenderen og få med flere.</p>
                                  <hr>
                                  <p><i>Om du ikke ønsker disse varslene kan du endre det under Profil-siden.</i></p>
                                  "],

    "17.des" => ["mailsubject" => "Quiz-kalender - ny oppgave: 17.desember",
                "userWhere" => " WHERE sendemail = 1",
                "mailContent" => "<h3>Quiz-kalender 17.desember - Mattematikk, schmattemattikk ➕➖</h3>
                                  <p>Kan du få dette til å gå opp i ett eneste ord?</p>
                                  <p>Løs dagens oppgave på <a href=\"https://quiz.josvik.no/\">https://quiz.josvik.no/</a><br>
                                  Lykke til, og husk å sjekke dagens oppgave hver dag i adventstiden.</p>
                                  <p>PS: Spre ordet om quiz-kalenderen og få med flere.</p>
                                  <hr>
                                  <p><i>Om du ikke ønsker disse varslene kan du endre det under Profil-siden.</i></p>
                                  "],

    "18.des" => ["mailsubject" => "Quiz-kalender - ny oppgave: 18.desember",
                "userWhere" => " WHERE sendemail = 1",
                "mailContent" => "<h3>Quiz-kalender 18.desember - Bedre og bedre dag for dag! 💪</h3>
                                  <p>En av bautaene i rikskringkastingens programtilbud var et program som søkte å trimme den eldre garde.</p>
                                  <p>Løs dagens oppgave på <a href=\"https://quiz.josvik.no/\">https://quiz.josvik.no/</a><br>
                                  Lykke til, og husk å sjekke dagens oppgave hver dag i adventstiden.</p>
                                  <p>PS: Spre ordet om quiz-kalenderen og få med flere.</p>
                                  <hr>
                                  <p><i>Om du ikke ønsker disse varslene kan du endre det under Profil-siden.</i></p>
                                  "],

    "19.des" => ["mailsubject" => "Quiz-kalender - ny oppgave: 19.desember",
                "userWhere" => " WHERE sendemail = 1",
                "mailContent" => "<h3>Quiz-kalender 19.desember - Omriss 3 〽️</h3>
                                  <p>Svaret i dag er også ett ord.</p>
                                  <p>Løs dagens oppgave på <a href=\"https://quiz.josvik.no/\">https://quiz.josvik.no/</a><br>
                                  Lykke til, og husk å sjekke dagens oppgave hver dag i adventstiden.</p>
                                  <p>PS: Spre ordet om quiz-kalenderen og få med flere.</p>
                                  <hr>
                                  <p><i>Om du ikke ønsker disse varslene kan du endre det under Profil-siden.</i></p>
                                  "],

    "20.des" => ["mailsubject" => "Quiz-kalender - ny oppgave: 20.desember",
                "userWhere" => " WHERE sendemail = 1",
                "mailContent" => "<h3>Quiz-kalender 20.desember - Doc Browns Nattquiz 🌙</h3>
                                  <p>Laster oppgave...</p>
                                  <p>Løs dagens oppgave på <a href=\"https://quiz.josvik.no/\">https://quiz.josvik.no/</a><br>
                                  Lykke til, og husk å sjekke dagens oppgave hver dag i adventstiden.</p>
                                  <p>PS: Spre ordet om quiz-kalenderen og få med flere.</p>
                                  <hr>
                                  <p><i>Om du ikke ønsker disse varslene kan du endre det under Profil-siden.</i></p>
                                  "],

    "21.des" => ["mailsubject" => "Quiz-kalender - ny oppgave: 21.desember",
                "userWhere" => " WHERE sendemail = 1",
                "mailContent" => "<h3>Quiz-kalender 21.desember - Viktig melding følger! 🌎</h3>
                                  <p>Gjør deg klar for mottak av skyhøyt viktig melding.</p>
                                  <p>Løs dagens oppgave på <a href=\"https://quiz.josvik.no/\">https://quiz.josvik.no/</a><br>
                                  Lykke til, og husk å sjekke dagens oppgave hver dag i adventstiden.</p>
                                  <p>PS: Spre ordet om quiz-kalenderen og få med flere.</p>
                                  <hr>
                                  <p><i>Om du ikke ønsker disse varslene kan du endre det under Profil-siden.</i></p>
                                  "],

    "22.des" => ["mailsubject" => "Quiz-kalender - ny oppgave: 22.desember",
                "userWhere" => " WHERE sendemail = 1",
                "mailContent" => "<h3>Quiz-kalender 22.desember - System 2 🏷️🏷️</h3>
                                  <p>Kompeksiteten i systemet har økt betraktelig siden forrige systemoppgave.</p>
                                  <p>Løs dagens oppgave på <a href=\"https://quiz.josvik.no/\">https://quiz.josvik.no/</a><br>
                                  Lykke til, og husk å sjekke dagens oppgave hver dag i adventstiden.</p>
                                  <p>PS: Spre ordet om quiz-kalenderen og få med flere.</p>
                                  <hr>
                                  <p><i>Om du ikke ønsker disse varslene kan du endre det under Profil-siden.</i></p>
                                  "],

    "23.des" => ["mailsubject" => "Quiz-kalender - ny oppgave: 23.desember",
                "userWhere" => " WHERE sendemail = 1",
                "mailContent" => "<h3>Quiz-kalender 23.desember - Spoonerisme 🔀</h3>
                                  <p>Kørdransen glinset i skinnet fra lulejysene mens støsnormen gebravde haugen med gulejavene som var glengjemt ute på pårdsglassen</p>
                                  <p>Løs dagens oppgave på <a href=\"https://quiz.josvik.no/\">https://quiz.josvik.no/</a><br>
                                  Lykke til, og husk å sjekke dagens oppgave hver dag i adventstiden.</p>
                                  <p>PS: Spre ordet om quiz-kalenderen og få med flere.</p>
                                  <hr>
                                  <p><i>Om du ikke ønsker disse varslene kan du endre det under Profil-siden.</i></p>
                                  "],

    "24.des" => ["mailsubject" => "Quiz-kalender - ny oppgave: 24.desember",
                "userWhere" => " WHERE sendemail = 1",
                "mailContent" => "<h3>Quiz-kalender 24.desember - Vårres Jul 🎄</h3>
                                  <p>Dagens oppgave handler om den tradisjonsrike plata Vårres Jul.</p>
                                  <p>Løs dagens oppgave på <a href=\"https://quiz.josvik.no/\">https://quiz.josvik.no/</a><br>
                                  Lykke til, og husk å sjekke dagens oppgave hver dag i adventstiden.</p>
                                  <p>PS: Spre ordet om quiz-kalenderen og få med flere.</p>
                                  <hr>
                                  <p><i>Om du ikke ønsker disse varslene kan du endre det under Profil-siden.</i></p>
                                  "],

    "27.des" => ["mailsubject" => "Quiz-Kalender 2025 - Takk og gratulerer til vinneren",
                "userWhere" => " WHERE sendemail = 1",
                "mailContent" => "<h3> 🎄🎅✨ Quiz-kalender 2025 er over 🎄🎅✨ </h3>
<p>Tusen takk til alle som deltok, med rekortstor deltakelse i år håper jeg dere alle hadde en morsom og grublefull adventstid.
    Over 100 deltakere og hele 8 som klarte full poengsum!</p>
<p>🏆 Vinner er kåret, og poengsummene viser at konkurransen har vært tett hele veien.</p>
<p>Vinner av Quiz-Kalender 2025!!
<h2>Tobbz</h2>
Fantastisk snittid på 42 minutter!</p>
<p>Imponerende innsats fra de som klarte alle oppgavene: <b>TV</b>, <b>Stenzolini</b>, <b>Ivar F</b>, <b>SSD</b>, <b>Magnuff</b>, <b>S</b>, <b>hmm</b> og <b>Terminatore</b></p>
<p>Takk til alle som har deltatt, engasjert seg og delt kalenderen med venner, familie og kollegaer.
Det er nettopp deres innsats som gjør Quiz-kalenderen så gøy!<br>
Oppgavene er tilgjengelig ut januar om noen ønsker å piffe opp et juleselskap.</p>
<p>Gledelig jul!<br>Hilsen Jostein<br><i>Quiz-bas</i></p>"]
        ];

    if (isset($_GET['mail']) && isset($mails[$_GET['mail']])) {
        $mail = $mails[$_GET['mail']];
        $mailsubject = $mail["mailsubject"];
        $mailContent = $mail["mailContent"];

        require 'sendemail.php';

        $users = R::findAll( 'user' , $mail["userWhere"] );
        foreach( $users as $user ) {
            $login_url = getloginurl($user);
            $content = sprintf($mailContent, $login_url, $login_url);
            $emailsent = sendEmail($user, $mailsubject, $content);
            echo $user->email . ": ";
            if ($emailsent)
                echo "ok\n";
            else
                echo "En feil oppsto under utsending av e-post.\n";
        }
        unset($user);
    }
}
else
echo "not logged in";
?>