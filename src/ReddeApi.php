<?php

namespace Redde;

use Redde\Exceptions\ReddeApiException;
use Redde\Exceptions\ReddeException;

/**
 * Class ReddeApi
 */
class ReddeApi
{
    /**
     * Redde API key
     * @var string
     */
    private $apikey = '';
    
    private $appid = '';

    private $lastResponseRaw;

    private $lastResponse;

    public $url = 'https://api.reddeonline.com/v1/';

    const USER_AGENT = 'Redde PHP API SDK 1.2';

    /**
     * Maximum amount of time in seconds that is allowed to make the connection to the API server
     * @var int
     */
    public $curlConnectTimeout = 20;

    /**
     * Maximum amount of time in seconds to which the execution of cURL call will be limited
     * @var int
     */
    public $curlTimeout = 20;

    /**
     * ReddeApi construct
     *
     * @param string $apikey Redde API key
     * @param string $appid Redd App ID
     */
    public function __construct($apikey, $appid)
    {
        $this->apikey = $apikey;
        $this->appid = $appid;
    }
 	
	/**
	* Get the Redde payment Base Url from the Api Instance
	*
	* @return string [This is the base URL that is on the class instance]
	*/
    protected function getBaseUrl()
    {
    	return $this->setBaseUrl($this->url);    
    }
	
    /**
     * Set to change the default baseUrl defined by Redde
     *
     * @param  string $url the redde base url
     * @return self
     */
	protected function setBaseUrl($url)
    {
    	$this->url = $url;
		return $this;
    }

    /**
     * Perform a GET request to the API
     * @param string $path Request path (e.g. 'details/transaction_id' or 'status/transaction_id')
     * @param array $params Additional GET parameters as an associative array
     * @return mixed API response
     * @throws \Redde\Exceptions\ReddeApiException if the API call status code is not in the 2xx range
     * @throws ReddeException if the API call has failed or the response is invalid
     */
    public function get($path, $params = [])
    {
        return $this->request('GET', $path, $params);
    } 
    
    /**
     * Perform a POST request to the API
     * @param string $path Request path (e.g. 'receive' or 'receive')
     * @param array $data Request body data as an associative array
     * @param array $params Additional GET parameters as an associative array
     * @return mixed API response
     * @throws \Redde\Exceptions\ReddeApiException if the API call status code is not in the 2xx range
     * @throws ReddeException if the API call has failed or the response is invalid
     */
    public function post($path, $data = [], $params = [])
    {
        return $this->request('POST', $path, $params, $data);
    }

    /**
     * Return raw response data from the last request
     * @return string|null Response data
     */
    public function getLastResponseRaw()
    {
        return $this->lastResponseRaw;
    }

    /**
     * Return decoded response data from the last request
     * @return array|null Response data
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    /**
     * Internal request implementation
     * @param string $method POST, GET, etc.
     * @param string $path
     * @param array $params
     * @param mixed $data
     * @return
     * @throws \Redde\Exceptions\ReddeApiException
     * @throws \Redde\Exceptions\ReddeException
     */
    private function request($method, $path, array $params = [], $data = null)
    {
        $this->lastResponseRaw = null;
        $this->lastResponse = null;

        $url = trim($path, '/');

        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        $curl = curl_init($this->url . $url);
        
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'apikey: ' . $this->apikey,
                'appid: ' . $this->appid,
        ]);
        
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 3);

        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->curlConnectTimeout);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->curlTimeout);

        curl_setopt($curl, CURLOPT_USERAGENT, self::USER_AGENT);

        if ($data !== null) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $this->lastResponseRaw = curl_exec($curl);

        $errorNumber = curl_errno($curl);
        $error = curl_error($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($errorNumber) {
            throw new ReddeException('CURL: ' . $error, $errorNumber);
        }

        $this->lastResponse = $response = json_decode($this->lastResponseRaw, true);
        header('Content-Type: application/json');
        $status = (int)$http_code;
        
        return $this->lastResponseRaw;
    }
    
    /**
     * This function let's you receive money
     * from customers
     * @param array $params [[Description]]
     * @return                      
     */
    
    /**
     * Perform a post request to the API
     * To take money out from customer wallet
     * @param array $params
     * @return mixed API response
     * @throws \Redde\Exceptions\ReddeApiException if the API call status code is not in the 2xx range
     * @throws ReddeException if the API call has failed or the response is invalid
     */
    public function receiveMoney($params)
    {
		try {
            // Receive payment from Customer
            $transaction = $this->post('receive', $params);
            var_export($transaction);

        } catch (ReddeApiException $e) { //API response status code was not successful
            echo 'Redde API Exception: ' . $e->getCode() . ' ' . $e->getMessage();
        } catch (ReddeException $e) { //API call failed
            echo 'Redde Exception: ' . $e->getMessage();
            var_export($this->getLastResponseRaw());
        }
    }
    
    /**
     * Perform a post request to the API
     * To send money to customer wallet
     * @param array $params
     * @return mixed API response
     * @throws \Redde\Exceptions\ReddeApiException if the API call status code is not in the 2xx range
     * @throws ReddeException if the API call has failed or the response is invalid
     */
    public function sendMoney($params)
    {
        try {
            // Send money to Customer
            $transaction = $this->post('cashout', $params);
            echo $transaction;

        } catch (ReddeApiException $e) { 
            //API response status code was not successful
            echo 'Redde API Exception: ' . $e->getCode() . ' ' . $e->getMessage();
        } catch (ReddeException $e) { 
            //API call failed
            echo 'Redde Exception: ' . $e->getMessage();
            echo $this->getLastResponseRaw();
        }
    }

    /**
     * Perform a status request to the API
     * To check the status of a transaction api initiated through sendMoney or receiveMoney
     * @param $transaction_id int|string
     * @return mixed API response
     * @throws \Redde\Exceptions\ReddeApiException If the API call status code is not in the 2xx range
     * @throws ReddeException If the API call has failed or the response is invalid
     */
    public function transactionStatus($transaction_id)
    {

        $status_id = $transaction_id; //use the exact transaction_id here

        try {
            // Checkout Status from Customer
            $status = $this->get('status/' . $status_id);
            echo $status;
        } catch (ReddeApiException $e) { 
            // API response status code was not successful
            echo 'Redde API Exception: ' . $e->getCode() . ' ' . $e->getMessage();
        } catch (ReddeException $e) { 
            // API call failed
            echo 'Redde Exception: ' . $e->getMessage();
            echo $this->getLastResponseRaw();
        }
    }

    /**
     * Perform a checkout request to the API
     * To receive money from customer through Checkout
     * @param array $checkout_params
     * @return mixed API response
     * 
     * If the API call status code is not in the 2xx range 
     * and API call fails it will return to failure callback url
     */
    public function checkOut($checkout_params) {

        $checkouturl = '';

        try {

            // Checkout from Customer
            $transaction = $this->post('checkout', $checkout_params);
            $transaction = json_decode($transaction);
            $checkouturl = $transaction->checkouturl;

            if (
                defined('LARAVEL_START') 
                && function_exists('redirect')
            ) {

                return @redirect()->to($checkouturl);
            } 

            header("Location: " . $checkouturl);

        } catch (ReddeApiException $e) { 
            
            // API response status code was not successful
            if (
                defined('LARAVEL_START') 
                && function_exists('redirect')
            ) {
                return @redirect()->to($checkout_params['failurecallback']);
            } else {
                // die(var_dump($e));
                // echo 'Redde API Exception: ' . $e->getCode() . ' ' . $e->getMessage();
                header("Location: " . $checkout_params['failurecallback']);
            }
        } catch (ReddeException $e) { 

            // API call failed
            if (
                defined('LARAVEL_START') 
                && function_exists('redirect')
            ) {
                // die(var_dump($e));
                return @redirect()->to($checkout_params['failurecallback']);
            } else {
                header("Location: " . $checkout_params['failurecallback']);
            }
        }
    }

    /**
     * Perform a checkout status request to the API
     * To check the status of a checkout api initiated through Checkout
     * @param $transaction_id int|string
     * @return mixed API response
     * @throws \Redde\Exceptions\ReddeApiException If the API call status code is not in the 2xx range
     * @throws ReddeException If the API call has failed or the response is invalid
     */
    public function checkoutStatus($transaction_id)
    {

        $checkout_status_id = $transaction_id; //use the exact transaction_id here

        try {
            // Checkout Status from Customer
            $status = $this->get('checkoutstatus/' . $checkout_status_id);
            echo $status;
        } catch (ReddeApiException $e) { 
            //API response status code was not successful
            echo 'Redde API Exception: ' . $e->getCode() . ' ' . $e->getMessage();
        } catch (ReddeException $e) { 
            //API call failed
            echo 'Redde Exception: ' . $e->getMessage();
            echo $this->getLastResponseRaw();
        }
    }
    
}