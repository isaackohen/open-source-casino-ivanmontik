<?php
$jsondata = file_get_contents(storage_path()."/settings.json");

$array = json_decode($jsondata,true);


return [
    'main_api_key' => $array['main_api_key'],
    'main_api_secret' => $array['main_api_secret'],
    'api_server' => $array['api_server'],
    'cdn' => $array['cdn'],
];
