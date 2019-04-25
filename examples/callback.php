<?php
/**
* A simple implementation of callback 
* on Redde Api
*/
require_once '../vendor/autoload.php';
use Redde\Exceptions\ReddeApiException;
use Redde\Exceptions\ReddeException;
use Redde\Webhooks\WebHookStatus;

$status = new WebHookStatus(); //instantiate an object

$data = $status->callback(); //get callback and set it to a variable

echo $data->reason; //output any data e.g. status|reason| etc
