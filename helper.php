<?php

/**
 * Helper class to retrieve API data
 */
class CovidInzidenzHelper
{

    private static function get_current_inzidenz($bezirk_id)
    {

        $url = "https://services7.arcgis.com/mOBPykOjAyBO2ZKk/arcgis/rest/services/RKI_Landkreisdaten/FeatureServer/0/query?where=AGS=" . $bezirk_id . "&outFields=cases_per_100k,cases7_per_100k_txt,last_update,BEZ,GEN&returnGeometry=false&outSR=4326&f=json";

        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, $url);

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);

        // close curl resource to free up system resources
        curl_close($ch);

        if ($output == NULL or $output == "") {
            return "API nicht erreichbar!";
        }

        $data = json_decode($output);

        return $data;
    }

    private static function get_historical_inzidenz($bezirk_id)
    {
        // get history last five days
        $url_hist = "https://api.corona-zahlen.org/districts/" . $bezirk_id . "/history/frozen-incidence/5";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url_hist);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output_hist = curl_exec($ch);
        curl_close($ch);

        $data_hist = json_decode($output_hist);

        $history = [
            0 => floor($data_hist->data->$bezirk_id->history[0]->weekIncidence * 10) / 10,
            1 => floor($data_hist->data->$bezirk_id->history[1]->weekIncidence * 10) / 10,
            2 => floor($data_hist->data->$bezirk_id->history[2]->weekIncidence * 10) / 10,
            3 => floor($data_hist->data->$bezirk_id->history[3]->weekIncidence * 10) / 10,
        ];

        return $history;
    }

    private static function get_ampel_data()
    {
        $url_data = "https://corona-ampel-bayern.de/data/data.json";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output_ampel = curl_exec($ch);
        curl_close($ch);

        return json_decode($output_ampel);
    }

    private static function get_ampel_color($krankenhaus, $intensiv)
    {
        if ($intensiv >= 600) {
            return 'red';
        } elseif ($krankenhaus >= 1200) {
            return 'yellow';
        } else {
            return 'green';
        }
    }

    public static function getData($bezirk_id)
    {
        if ($bezirk_id == 0) {
            return 'Diese ID ist nicht gültig!';
        }

        $current_inzidenz = self::get_current_inzidenz($bezirk_id);

        $historical_inzidenz = self::get_historical_inzidenz($bezirk_id);


        $ampel_data = self::get_ampel_data();


        $out = [
            "last_update" => date('d.m.Y'),
            "inzidenz_today" => $current_inzidenz->features[0]->attributes->cases7_per_100k_txt,
            "inzidenz_today_last_update" => $current_inzidenz->features[0]->attributes->last_update,
            "BEZ" => $current_inzidenz->features[0]->attributes->BEZ,
            "GEN" => $current_inzidenz->features[0]->attributes->GEN,
            "history" => $historical_inzidenz,
            "ampel_color" => self::get_ampel_color($ampel_data->hospitalizationLast7Days, $ampel_data->currentIntensiveCarePatients),
            "ampel_last_update" => $ampel_data->lastUpdate,
        ];

        file_put_contents(__DIR__ . '/data.json', json_encode($out));

        return $out;
    }
}
