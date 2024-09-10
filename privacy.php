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
          <h2 class="content-subhead">Personvern</h2>
          <p>Ved å registrere deg lagres e-postadresse og kallenavn, i tillegg lagres tidspunkt og poengverdi for dine svar. 
          Lagret informasjon blir brukt til å logge inn og vise en poengoversikt over deltakere.<br>
          All informasjon blir slettet innen 30 dager etter avsluttet kalender. <br>
          Hvis du ønsker å slette dine data før dette, kan du gjøre det under din profil.</p>
          <p>E-postadresse brukes til å sende innloggingsinformasjon og for å ta kontakt ved eventuell utdeling av premie.<br>
          Informasjonskapsler(cookies) brukes kun til å huske innlogging. Ønsker du å fjerne denne informasjonen kan du logge ut, da slettes Informasjonskapselen.</p>
        </div><!--class="content"-->
    </div><!--id="main"-->
<?php
require 'foot.php';
?>