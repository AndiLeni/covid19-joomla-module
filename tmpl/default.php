<?php
// No direct access
defined('_JEXEC') or die;

$num_cases = intval($api_data['inzidenz_today']);

function get_color($num_cases)
{
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

function get_color_bg($num_cases)
{
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

<style>
    .mod_covidinzidenz_light {
        height: 100px;
        width: 100px;
        border-radius: 100%;
        border: 5px solid #fff;
        margin-right: 10px;
    }

    .mod_covidinzidenz_traffic_light_box {
        padding: 10px;
        list-style: none;
        border-radius: 15px;
        display: flex;
        align-items: center;
    }

    .mod_covidinzidenz_traffic_light_box_active {
        background-color: lightblue;
    }

    .mod_covidinzidenz_text {
        font-weight: bold;
        font-size: 2rem;
    }

    #mod_covidinzidenz_red_light>.mod_covidinzidenz_light_bright {
        background-color: #ff0000;
    }

    #mod_covidinzidenz_yellow_light>.mod_covidinzidenz_light_bright {
        background-color: #ffff00;
    }

    #mod_covidinzidenz_green_light>.mod_covidinzidenz_light_bright {
        background-color: #008000;
    }

    #mod_covidinzidenz_red_light>.mod_covidinzidenz_light_fade {
        background-color: #fecccc;
    }

    #mod_covidinzidenz_yellow_light>.mod_covidinzidenz_light_fade {
        background-color: #fefecc;
    }

    #mod_covidinzidenz_green_light>.mod_covidinzidenz_light_fade {
        background-color: #b2feb2;
    }
</style>

<div class="g-grid">
    <div class="g-block size-50" style="display: flex; align-items: center; justify-content: center; flex-direction: column">
        <h3>Corona Inzidenz:</h3>
        <div style="flex-grow: 1; text-align: center">
            <div style="text-align: center;">
                <p style="font-size: 4rem; padding: 2rem; border: 6px solid <?php echo get_color($api_data['inzidenz_today']) ?>; border-radius: 10px; background-color: <?php echo get_color_bg($api_data['inzidenz_today']) ?>"> <?php echo $api_data['inzidenz_today'] ?> </p>
            </div>
            <p style="margin-top: 0.5rem; margin-bottom: 0 !important;">Vorherige Tage:</p>
            <div style="display: flex; flex-direction: row;">
                <?php
                foreach ($api_data['history'] as $day) {
                    echo '<p style="font-size: 1rem; padding: 0.5rem; margin: 0.2rem; border: 3px solid' . get_color($day) . '; border-radius: 5px; background-color:' . get_color_bg($day) . '">' . $day . '</p>';
                }
                ?>
            </div>
            <p>
                Stand: <?php echo $api_data['inzidenz_today_last_update'] ?>
                <br>
                Region: <?php echo $api_data['BEZ'] . ' ' . $api_data['GEN'] ?>
            </p>
            <br>
        </div>
        <p style="font-size: 8pt !important; color:gray">
            <strong>Quellenvermerk</strong>: <br>
            <a href="https://www.rki.de/DE/Content/InfAZ/N/Neuartiges_Coronavirus/Fallzahlen.html" target="_blank" rel="nofollow noopener ugc">Robert Koch-Institut (RKI)</a>, <a href="https://www.govdata.de/dl-de/by-2-0" target="_blank" rel="nofollow noopener ugc">dl-de/by-2-0</a> <br>
            <a target="_blank" href="https://rki.marlon-lueckert.de/">rki-covid-api</a> is licensed under <a href="https://creativecommons.org/licenses/by/4.0">CC BY 4.0</a>

        </p>
    </div>
    <div class="g-block size-50" style="display: flex; align-items: center; justify-content: center; flex-direction: column">
        <h3>Corona Ampel:</h3>

        <div style="text-align: center;">
            <?php

            if ($api_data['ampel_color'] == 'red') {
                echo '
            <ul style="margin: 0;">
                <li id="mod_covidinzidenz_red_light" class="mod_covidinzidenz_traffic_light_box">
                    <div class="mod_covidinzidenz_light mod_covidinzidenz_light_bright"></div>
                    <div class="mod_covidinzidenz_text"></div>
                </li>

                <li id="mod_covidinzidenz_yellow_light" class="mod_covidinzidenz_traffic_light_box">
                    <div class="mod_covidinzidenz_light mod_covidinzidenz_light_fade"></div>
                    <div class="mod_covidinzidenz_text"></div>
                </li>

                <li id="mod_covidinzidenz_green_light" class="mod_covidinzidenz_traffic_light_box mod_covidinzidenz_traffic_light_box_active">
                    <div class="mod_covidinzidenz_light mod_covidinzidenz_light_fade"></div>
                    <div class="mod_covidinzidenz_text">
                        GRÜN
                    </div>
                </li>
            </ul>
            ';
            }

            if ($api_data['ampel_color'] == 'yellow') {
                echo '
            <ul style="margin: 0;">
                <li id="mod_covidinzidenz_red_light" class="mod_covidinzidenz_traffic_light_box">
                    <div class="mod_covidinzidenz_light mod_covidinzidenz_light_fade"></div>
                    <div class="mod_covidinzidenz_text"></div>
                </li>

                <li id="mod_covidinzidenz_yellow_light" class="mod_covidinzidenz_traffic_light_box">
                    <div class="mod_covidinzidenz_light mod_covidinzidenz_light_bright"></div>
                    <div class="mod_covidinzidenz_text"></div>
                </li>

                <li id="mod_covidinzidenz_green_light" class="mod_covidinzidenz_traffic_light_box mod_covidinzidenz_traffic_light_box_active">
                    <div class="mod_covidinzidenz_light mod_covidinzidenz_light_fade"></div>
                    <div class="mod_covidinzidenz_text">
                        GRÜN
                    </div>
                </li>
            </ul>
            ';
            }

            if ($api_data['ampel_color'] == 'green') {
                echo '
            <ul style="margin: 0;">
                <li id="mod_covidinzidenz_red_light" class="mod_covidinzidenz_traffic_light_box">
                    <div class="mod_covidinzidenz_light mod_covidinzidenz_light_fade"></div>
                    <div class="mod_covidinzidenz_text"></div>
                </li>

                <li id="mod_covidinzidenz_yellow_light" class="mod_covidinzidenz_traffic_light_box">
                    <div class="mod_covidinzidenz_light mod_covidinzidenz_light_fade"></div>
                    <div class="mod_covidinzidenz_text"></div>
                </li>

                <li id="mod_covidinzidenz_green_light" class="mod_covidinzidenz_traffic_light_box mod_covidinzidenz_traffic_light_box_active">
                    <div class="mod_covidinzidenz_light mod_covidinzidenz_light_bright"></div>
                    <div class="mod_covidinzidenz_text">
                        GRÜN
                    </div>
                </li>
            </ul>
            ';
            }


            ?>

            <p>
                Stand: <?php
                        $data_time = DateTime::createFromFormat('Y-m-d\TH:i:s.v\Z', $api_data['ampel_last_update']);
                        echo $data_time->format('d.m.Y H:i');
                        ?>
            </p>
            <br>
        </div>
        <p style="font-size: 8pt !important; color:gray">
            <strong>Quellenvermerk</strong>: <br>
            <a href="https://corona-ampel-bayern.de/" target="_blank" rel="nofollow noopener ugc">https://corona-ampel-bayern.de/</a>
        </p>


    </div>
</div>