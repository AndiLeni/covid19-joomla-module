<?php
// No direct access
defined('_JEXEC') or die;

?>

<div class="g-grid">
    <div class="g-block size-50">
        <h3>Corona Inzidenz:</h3>
        <p>
            Stand: <?php echo $api_data["last_update"] ?>
            <br>
            Region: <?php echo $api_data["BEZ"] . ' ' . $api_data["GEN"] ?>
        </p>
        <br>
        <p style="font-size: 8pt !important;">
            Die Daten sind die Fallzahlen in Deutschland des
            <a href="https://www.rki.de/DE/Content/InfAZ/N/Neuartiges_Coronavirus/Fallzahlen.html" target="_blank" rel="nofollow noopener ugc">Robert Koch-Institut (RKI)</a>
            und stehen unter der
            <a href="https://www.govdata.de/dl-de/by-2-0" target="_blank" rel="nofollow noopener ugc">
                Open Data Datenlizenz Deutschland - Namensnennung - Version 2.0
            </a>zur Verfügung.</br>
            <strong>Quellenvermerk</strong>: Robert Koch-Institut (RKI), dl-de/by-2-0

        </p>
    </div>
    <div class="g-block size-50" style="display: flex; align-items: center; justify-content: center;">
        <p style="font-size: 4rem; padding: 2rem; border: 2px solid lightgray; border-radius: 10px"> <?php echo $api_data["cases"] ?> </p>
    </div>
</div>