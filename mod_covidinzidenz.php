<?php

/**
 * Module Entry Point
 */


// No direct access
defined('_JEXEC') or die;

// die if cURL is not available on server
if (!function_exists('curl_init')) {
    echo "cURL ist nicht aktiviert!";
    die;
}


// Include the helper files only once
require_once dirname(__FILE__) . '/helper.php';

// get bezirk id from module settings
$bezirk_id = $params->get('id', '0');


// read data from file, is faster than making api request each time
$data = file_get_contents(__DIR__ . '/data.json');

if ($data !== false) {
    $data = json_decode($data, true);

    // $data_time = date_create_from_format('d.m.Y\, H:i \U\h\r', $data->last_update);
    $data_time = date_create_from_format('d.m.Y', $data['last_update']);
    $now = new DateTime();

    if ($data_time->format('d') != $now->format('d')) {
        // make api request
        $api_data = CovidInzidenzHelper::getData($bezirk_id);
    } else {
        $api_data = $data;
    }

} else {
    // make api request
    $api_data = CovidInzidenzHelper::getData($bezirk_id);
}



require JModuleHelper::getLayoutPath('mod_covidinzidenz');
