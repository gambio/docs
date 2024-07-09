<?php

/* --------------------------------------------------------------
   RestSampleConsumer.php 2016-02-16
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

/**
 * Class RestSampleConsumer
 */
class RestSampleConsumer
{
	/**
	 * Authorization Header
	 *
	 * Example: 'Authorization: Basic dXNlcm5hbWU6cGFzc3dvcmQ='
	 *
	 * @var null|string
	 */
	protected $authHeader = null;

	/**
	 * cURL Session Handle
	 *
	 * @var resource;
	 */
	protected $curl;


	/**
	 * Class Constructor
	 *
	 * If no credentials are provided then the class will not send the "Authorization"
	 * header with each request.
	 *
	 * @param string $username (optional)Test shop installation admin username.
	 * @param string $password (optional)Test shop installation admin password.
	 */
	public function __construct($username = null, $password = null)
	{
		if($username !== null && $password !== null)
		{
			$this->authHeader = 'Authorization: Basic ' . base64_encode($username . ':' . $password);
		}

		$this->curl = curl_init();
		curl_setopt($this->curl, CURLOPT_USERAGENT, 'ApiV2TestsConsumer');
		curl_setopt($this->curl, CURLOPT_HEADER, 1);
		curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($this->curl, CURLOPT_MAXREDIRS, 10);
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
	}


	/**
	 * Class Destructor
	 */
	public function __destruct()
	{
		curl_close($this->curl);
	}


	/**
	 * Make POST request the provided URL.
	 *
	 * @param string       $url
	 * @param array        $headers (optional)
	 * @param string|array $data    (optional)
	 *
	 * @return RestSampleResponse
	 */
	public function post($url, array $headers = array(), $data = null)
	{
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);

		return $this->_execute('POST', $url, $headers);
	}


	/**
	 * Make PUT request the provided URL.
	 *
	 * @param string       $url
	 * @param array        $headers (optional)
	 * @param string|array $data    (optional)
	 *
	 * @return RestSampleResponse
	 */
	public function put($url, array $headers = array(), $data = null)
	{
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);

		return $this->_execute('PUT', $url, $headers);
	}


	/**
	 * Make PATCH request the provided URL.
	 *
	 * @param string       $url
	 * @param array        $headers (optional)
	 * @param string|array $data    (optional)
	 *
	 * @return RestSampleResponse
	 */
	public function patch($url, array $headers = array(), $data = null)
	{
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);

		return $this->_execute('PATCH', $url, $headers);
	}


	/**
	 * Make DELETE request the provided URL.
	 *
	 * @param string       $url
	 * @param array        $headers (optional)
	 * @param string|array $data    (optional)
	 *
	 * @return RestSampleResponse
	 */
	public function delete($url, array $headers = array(), $data = null)
	{
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);

		return $this->_execute('DELETE', $url, $headers);
	}


	/**
	 * Make PUT request the provided URL.
	 *
	 * @param string $url
	 * @param array  $headers (optional)
	 *
	 * @return RestSampleResponse
	 */
	public function get($url, array $headers = array())
	{
		return $this->_execute('GET', $url, $headers);
	}


	/**
	 * Execute cURL request.
	 *
	 * @param string $method  Provide a valid cURL request method.
	 * @param string $url     API resource to be requested.
	 * @param array  $headers Contains additional headers to be included in the request.
	 *
	 * @return RestSampleResponse
	 */
	protected function _execute($method, $url, array $headers)
	{
		curl_setopt($this->curl, CURLOPT_URL, $url);

		if(strtoupper($method) !== 'POST' && strtoupper($method) !== 'PUT' && strtoupper($method) !== 'PATCH')
		{
			curl_setopt($this->curl, CURLOPT_POST, false);
		}

		curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $method);

		if(!empty($this->authHeader))
		{
			$headers[] = $this->authHeader;
		}

		if(!empty($headers))
		{
			curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);
		}

		return new RestSampleResponse(curl_exec($this->curl), $this->curl);
	}
}