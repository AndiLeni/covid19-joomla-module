<?php
// No direct access
defined('_JEXEC') or die;

$num_cases = intval($api_data["cases"]);

if ($num_cases < 50) {
    $color = '#198754';
    $color_bg = '#d1e7dd';
} elseif (50 <= $num_cases && $num_cases < 100) {
    $color = '#ffc107';
    $color_bg = '#fff3cd';
} elseif (100 <= $num_cases) {
    $color = '#dc3545';
    $color_bg = '#f8d7da';
} else {
    $color = '#6c757d';
    $color_bg = '#fff';
}

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
        <p style="font-size: 4rem; padding: 2rem; border: 6px solid <?php echo $color ?>; border-radius: 10px; background-color: <?php echo $color_bg ?>"> <?php echo $api_data["cases"] ?> </p>
    </div>
</div>