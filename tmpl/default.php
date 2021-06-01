<?php
// No direct access
defined('_JEXEC') or die;

$num_cases = intval($api_data->cases);

function get_color($num_cases) {
    if ($num_cases < 50) {
        $color = '#198754';
    } elseif (50 <= $num_cases && $num_cases < 100) {
        $color = '#ffc107';
    } elseif (100 <= $num_cases) {
        $color = '#dc3545';
    } else {
        $color = '#6c757d';
    }
    return $color;
}

function get_color_bg($num_cases) {
    if ($num_cases < 50) {
        $color_bg = '#d1e7dd';
    } elseif (50 <= $num_cases && $num_cases < 100) {
        $color_bg = '#fff3cd';
    } elseif (100 <= $num_cases) {
        $color_bg = '#f8d7da';
    } else {
        $color_bg = '#fff';
    }
    return $color_bg;
}

?>

<div class="g-grid">
    <div class="g-block size-50">
        <h3>Corona Inzidenz:</h3>
        <p>
            Stand: <?php echo $api_data->last_update ?>
            <br>
            Region: <?php echo $api_data->BEZ . ' ' . $api_data->GEN ?>
        </p>
        <br>
        <p style="font-size: 8pt !important; color:gray">
            <strong>Quellenvermerk</strong>: <br>
            <a href="https://www.rki.de/DE/Content/InfAZ/N/Neuartiges_Coronavirus/Fallzahlen.html" target="_blank" rel="nofollow noopener ugc">Robert Koch-Institut (RKI)</a>, <a href="https://www.govdata.de/dl-de/by-2-0" target="_blank" rel="nofollow noopener ugc">dl-de/by-2-0</a> <br>
            <a target="_blank" href="https://rki.marlon-lueckert.de/">rki-covid-api</a> is licensed under <a href="https://creativecommons.org/licenses/by/4.0">CC BY 4.0</a>

        </p>
    </div>
    <div class="g-block size-50" style="display: flex; align-items: center; justify-content: center; flex-direction: column">
        <div>
            <p style="font-size: 4rem; padding: 2rem; border: 6px solid <?php echo get_color($api_data->cases) ?>; border-radius: 10px; background-color: <?php echo get_color_bg($api_data->cases) ?>"> <?php echo $api_data->cases ?> </p>
        </div>
        <p style="margin-top: 0.5rem; margin-bottom: 0 !important;">Vorherige Tage:</p>
        <div style="display: flex; flex-direction: row;">
            <?php
                foreach ($api_data->history as $day) {
                    echo '<p style="font-size: 1rem; padding: 0.5rem; margin: 0.2rem; border: 3px solid' . get_color($day) . '; border-radius: 5px; background-color:' . get_color_bg($day) . '">' . $day . '</p>';
                }
            ?>
        </div>
    </div>
</div>