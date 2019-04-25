<?php
/**
* An example of using the Redde Api to send money
*/

require_once '../vendor/autoload.php';
require_once "common_functions.php";

//Configuration file contains apikey and appid
$config = include '../src/config.php';

use Redde\Exceptions\ReddeApiException;
use Redde\Exceptions\ReddeException;
use Redde\ReddeApi;

// Replace this with your API key and App Id
$apikey = $config['apikey'];
$app_id = $config['appid'];

$send = new ReddeApi($apikey, $app_id);

//You need to get this from your application
$client_reference = generateNumber();
$client_id = generateRandomString();

$params = [
    "amount" => 1, //amount to send
    "appid" => $config['appid'], //your app id
    "clientreference" => $client_reference, //client reference from your side
    "clienttransid" => $client_id, //client transaction id from your side
    "description" => "Sending money to {$client_reference}", //A description for the transaction performed
    "nickname" => "name", //a name to give to who is cashing out
    "paymentoption" => "MTN", //payment options are MTN|AIRTELTIGO|VODAFONE
    "vouchercode" => "", //this is optional for vodafone 
    "walletnumber" => "024XXXXXXX" //the mobile number to use
];

/**
* Call sendMoney function and pass
* the payload as parameter. This will 
* return a response which you can save
* in any storage of your choice
*/
$send->sendMoney($params);
