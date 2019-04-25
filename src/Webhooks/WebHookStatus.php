<?php
namespace Redde\Webhooks;

use Redde\Exceptions\ReddeApiException;
use Redde\Exceptions\ReddeException;

/**
* A simple class to handle callbacks
*/
class WebHookStatus
{
	/**
     * @var string
     */
	private $response;

	/**
	* Get Response from API server
	* @return mixed API response
	* @return string [This response is from api server]
	*/
	public function getResponse()
	{
		return $this->response;
	}

	/**
	 * Set response details from API server
	 * @param  json $response [Response from the api server]
	 * @return json [This response is retrieve using the getResponse function]
	 */
	public function setResponse($response)
	{
		$this->response = $response;
		return $this;
	}

	/**
	 * Here we are using file_get_contents to get http response
	 * @return json 
	 */
	public function getRawResponse()
	{
		$data = @file_get_contents('php://input');
		$params = $this->setResponse($data);
		return $this->getResponse();
	}

	/**
	 * The callback function prepares and retrieve 
	 * final status of api call
	 * @return json 
	 */
	public function callback()
	{	
		return json_decode($this->getRawResponse());
	}

}
