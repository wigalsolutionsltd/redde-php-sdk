<?php

/**
* An example of using the Redde Api to receive money
*/

use Redde\ReddeApi;
use Redde\Exceptions\ReddeApiException;
use Redde\Exceptions\ReddeException;

require_once '../vendor/autoload.php';
require_once "common_functions.php";

// Configuration file contains apikey and appid
$config = include '../src/config.php';


// Replace this with your API key and App Id
$apikey = $config['apikey'];
$appid = $config['appid'];

$api = new ReddeApi($apikey, $appid);

$transaction_id = ''; // 19XXXX a transaction id from the api

$status_params = [
    "apikey" => $apikey,
    "appid" => $appid,
];

// To check status of checkout call this function
$api->checkoutStatus($transaction_id, $status_params);