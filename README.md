![Redde](https://www.reddeonline.com/assets/img/reddes-logo.png)
# Redde-php-sdk
A PHP SDK built around the Redde REST API that allows merchants to receive, send, check transaction status, and perform lots of payment transactions.

[![GitHub version](https://d25lcipzij17d.cloudfront.net/badge.svg?id=gh&type=6&v=1.0&x2=0)](https://packagist.org/packages/redde/php-api-sdk)
[![Maintenance](https://img.shields.io/badge/Maintained%3F-yes-green.svg)]()
[![made-with-php](https://img.shields.io/badge/Made%20with-PHP-1f425f.svg)](https://www.php.net/)
[![MIT license](https://img.shields.io/badge/License-MIT-blue.svg)](https://github.com/wigalsolutionsltd/redde-php-sdk/)
[![ForTheBadge built-by-developers](http://ForTheBadge.com/images/badges/built-by-developers.svg)](https://reddeonline.com)

Before you can have access to APIs you need to register and create an [Account](https://app.reddeonline.com/register). Header for all request should have {"apikey": "string"}: and this API key will be sent to merchant when their app configuration is setup for them by Wigal.

For more information on documentation go to [developers.reddeonline.com](https://developers.reddeonline.com/rest-api.html)

 * [Installation](#installation)
 * [Usage](#usage)
 * [Examples](#examples)
 
Installation
------------

To use this library you'll need to have [created a Redde account](https://app.reddeonline.com/register). 

To install this library and use in your project, we recommend using [Composer](https://getcomposer.org/).

```bash
composer require redde/php-api-sdk
```

> You don't need to clone this repository to use this library in your own projects. Use Composer to install it from Packagist.

If you're new to Composer, here are some resources that you may find useful:

* [Composer's Getting Started page](https://getcomposer.org/doc/00-intro.md) from Composer project's documentation.
* [A Beginner's Guide to Composer](https://scotch.io/tutorials/a-beginners-guide-to-composer) from the good people at ScotchBox.

Usage
-----

If you're using Composer, make sure the autoloader is included in your project's bootstrap file:

```php
require_once "vendor/autoload.php";
```

Create an api object with your API key and App ID which will be provided to you by the Redde Team:

```php
$api = new ReddeApi(API_KEY, APP_ID);    
```

Examples
--------
### Receiving money from Customer or Client
To use the API to recieve money from a customer, the receiveMoney() method will be used
using a simple array of parameters, the keys match the parameters of the API.

```php
/**
* An example of using the Redde Api to receive money
*/

require_once 'vendor/autoload.php';

//Configuration file contains apikey and appid
$config = include 'config.php';

use Redde\Exceptions\ReddeApiException;
use Redde\Exceptions\ReddeException;
use Redde\ReddeApi;

/* Replace this with your API key and App Id
 You can also insert the apikey and appid here directly 
 and ignore the config.php file
*/

$apikey = $config['apikey'];
$app_id = $config['appid'];

$api = new ReddeApi($apikey, $app_id);

/* Note that the clienttransid and clientreference is generated 
  by the developer. The nickname is your identity name eg. Wigal
*/

$params = [
    "amount" => 1, //amount to receive
    "appid" => $config['appid'], //your app id
    "clientreference" => client_reference_here, //client reference from your side
    "clienttransid" => client_transaction_id_here, //client transaction id from your side
    "description" => "Recieving payment from {$client_reference_here}", //A description for the transaction performed
    "nickname" => "nickname_here", //a name to give to who is paying 
    "paymentoption" => "MTN", //payment options are MTN|AIRTELTIGO|VODAFONE
    "vouchercode" => "", //this is optional for vodafone 
    "walletnumber" => "024XXXXXXX" //the mobile number to use
];

/**
* Call receiveMoney function and pass
* the payload as parameter. This will 
* return a response which you can save
* in any storage of your choice
*/
$api->receiveMoney($params);

```


### Sending money to Customer or Client
To use the API to send money to a customer, the sendMoney() method will be used
using a simple array of parameters, the keys match the parameters of the API.

```php
/**
* An example of using the Redde Api to send money
*/

require_once 'vendor/autoload.php';

//Configuration file contains apikey and appid
$config = include 'config.php';

use Redde\Exceptions\ReddeApiException;
use Redde\Exceptions\ReddeException;
use Redde\ReddeApi;

/* Replace this with your API key and App Id
 You can also insert the apikey and appid here directly 
 and ignore the config.php file
*/

$apikey = $config['apikey'];
$app_id = $config['appid'];

$api = new ReddeApi($apikey, $app_id);

/* Note that the clienttransid and clientreference is generated 
  by the developer. The nickname is your identity name eg. Wigal
*/

$params = [
    "amount" => 1, //amount to receive
    "appid" => $config['appid'], //your app id
    "clientreference" => client_reference_here, //client reference from your side
    "clienttransid" => client_transaction_id_here, //client transaction id from your side
    "description" => "Sending payment from {$client_reference_here}", //A description for the transaction performed
    "nickname" => "nickname_here", //a name to give to who is paying 
    "paymentoption" => "MTN", //payment options are MTN|AIRTELTIGO|VODAFONE
    "walletnumber" => "024XXXXXXX" //the mobile number to use
];

/**
* Call receiveMoney function and pass
* the payload as parameter. This will 
* return a response which you can save
* in any storage of your choice
*/
$api->sendMoney($params);

```


### Callbacks
Most APIs implement callbacks for easy tracking of api transactions so we've spun something
simple for you to use. Check it out

```php
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

```


# License
This library is released under the MIT License