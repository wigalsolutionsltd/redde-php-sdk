<?php
/**
* A simple implementation of callback 
* on Redde Api
*/
use Redde\Exceptions\ReddeApiException;
use Redde\Exceptions\ReddeException;
use Redde\Webhooks\WebHookStatus;

require_once '../vendor/autoload.php';

$status = new WebHookStatus(); // instantiate an object

$data = $status->callback(); // get callback and set it to a variable

echo $data->reason; // output any data e.g. status|reason| etc

/**
 * Another implementation can be seen below
 * This is to show how to log in a text file
 */

// $data = $status->getRawResponse(); // get raw response and use it how you want

// if($data != null) {
//     file_put_contents('callback.txt', "Log: ".date('d-m-Y')." => " . $params, FILE_APPEND | LOCK_EX);
// } 

