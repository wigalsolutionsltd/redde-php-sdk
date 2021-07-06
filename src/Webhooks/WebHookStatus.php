<?php

namespace Redde\Webhooks;

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
	*  [This response is from api server]
	* @return string API response
	*/
	public function getResponse()
	{
		return $this->response;
	}

	/**
	 * Set response details from API server
	 * @param object $response [Response from the api server]
	 * [This response is retrieved using the getResponse function]
	 */
	public function setResponse($response)
	{
		$this->response = $response;
		return $this;
	}

	/**
	 * Here we are using file_get_contents to get http response
	 * @return string 
	 */
	public function getRawResponse()
	{
		$data = @file_get_contents('php://input');
		$this->setResponse($data);
		return $this->getResponse();
	}

	/**
	 * The callback function prepares and retrieve 
	 * response as object of final api call
	 * @return object 
	 */
	public function callback()
	{	
		$this->getRawResponse();
		return json_decode($this->response);
	}
	
}
