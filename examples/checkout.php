<?php

/**
* An example of using the Redde Api to receive money
*/
use Redde\ReddeApi;

require_once '../vendor/autoload.php';
require_once "common_functions.php";

//Configuration file contains apikey and appid
$config = include '../src/config.php';

// Replace this with your API key and App Id
$apikey = $config['apikey'];
$appid = $config['appid'];

$api = new ReddeApi($apikey, $appid);

/* Note that the clienttransid and clientreference is generated 
  by the developer. The nickname is your identity name eg. Wigal
*/
$clientreference = generateNumber();
$clienttransid = generateRandomString();

$params = [
    "amount" => 1, // amount to receive
    "apikey" => $apikey, // your api key
    "appid" => $appid, // your app id
    "description" => "A description for your transaction", // A description for the transaction
    "merchantname" => "Some Company Limited", // Merchantname (Your Company or A name of your application)
    "logolink" => "https://example.com/some-path-to-image-logo.jpg", // Url to fetch for your logo
    "clienttransid" => $clientreference, // client reference from your end
    "successcallback" => "https://example.com/", // A success callback url from your end
    "failurecallback" => "https://example.com/failure", // A failure callback url from your end
];

/**
* Call checkOut function and pass
* the payload as parameter. This will 
* take you to the Redde Checkout page 
* when successful or throw an error
* when something goes wrong
* 
* On success the success callbackurl will be called
* On failure the failure callbackurl will be called
*/
$api->checkOut($params);
