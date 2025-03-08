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
?>

            <br>
            <h2>Vinner av Quiz-Kalender 2024 er:</h2>
            <h1>Deltaker 42</h1>
            <br>
            <h2>Vinnere trukket fra alle oppgavene:</h2>
            <h1>Deltaker 18/h1>
            <h1>Deltaker 65</h1>
            <a href="winners.php">Se trekking av vinnere</a>
            <br>
            <br>

            <h3>Nye oppgaver, hver dag i hele adventstiden</h3>
            <p>
                Quiz-kalenderen starter 1. desember, og det publiseres nye oppgaver hver dag helt til julaften.<br>
                Oppgavene slippes kl 07:00, og du kan løse oppgaver helt frem til 2.juledag kl 23:59.
            </p>
            <p>
                <b>Premier</b><br>
                Vinneren er deltakeren med flest poeng. Ved lik sum: raskeste svar på alle oppgavene tilsammen.
                To tilfeldige deltakere trekkes fra alle løste oppgaver, uansett poengsum. Hver løste oppgave gir ett lodd i trekningen.</p>
            </p>

            <p>
                For hver oppgave er det angitt en poengverdi. Ved å avsløre Hint 1 vil poengverdien minke med 5 poeng.<br>
                Men hvis du avslører Hint 2, vil oppgaven miste hele poengverdien. Dette er fordi Hint 2 er tilnærmet et løsningsforslag.
            </p>
            <p>
                Husk å invitere alle du kjenner til Quiz-kalenderen. <br>
                Har du spørsmål, kommentarer eller er noe feil kan du ta kontakt på post@josvik.no .<br>
            </p>
            <p>
              Lykke til!
            </p>
            <p>
              <b>PS: Ikke glem å opprette grupper (bande) og inviter venner, kollegaer og familie.</b><br>
              Gå inn på <a href="<?php echo getBaseUrl(); ?>profile.php">profilen din</a> og meld deg inn i bander.
            </p>

            <hr>
            <br>
            <?php include("tiles.php");

}
?>
        </div><!--class="content"-->
    </div><!--id="main"-->
<?php
require 'foot.php';
?>