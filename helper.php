<?php

/**
 * Helper class to retrieve API data
 */
class CovidInzidenzHelper
{
    public static function getData($bezirk_id)
    {
        if ($bezirk_id == 0) {
            return 'Diese ID ist nicht gültig!';
        }

        $url = "https://services7.arcgis.com/mOBPykOjAyBO2ZKk/arcgis/rest/services/RKI_Landkreisdaten/FeatureServer/0/query?where=OBJECTID=" . $bezirk_id . "&outFields=cases_per_100k,cases7_per_100k_txt,last_update,BEZ,GEN&returnGeometry=false&outSR=4326&f=json";

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

        $out = [
            "cases" => $data->features[0]->attributes->cases7_per_100k_txt,
            "last_update" => $data->features[0]->attributes->last_update,
            "BEZ" => $data->features[0]->attributes->BEZ,
            "GEN" => $data->features[0]->attributes->GEN,
        ];

        file_put_contents(__DIR__ . '/data.txt', json_encode($out));

        return $out;
    }
}
