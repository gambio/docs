<?php

/* --------------------------------------------------------------
   RestSampleResponse.php 2016-02-16
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2016 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

/**
 * Class RestSampleResponse
 */
class RestSampleResponse
{
	/**
	 * Response Body
	 *
	 * @var string
	 */
	protected $body = null;

	/**
	 * Array of response headers.
	 *
	 * @var array
	 */
	protected $headers = null;


	/**
	 * cURL handle that made the request, used for obtaining response info
	 *
	 * @var resource
	 */
	protected $curl;


	/**
	 * Class Constructor
	 *
	 * Important: It doesn't have the same arguments as the parent class.
	 *
	 * @param string   $response API response body.
	 * @param resource $curl     cURL handle that made the request.
	 */
	public function __construct($response, $curl)
	{
		if(!empty($response))
		{
			$headersSize   = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
			$this->body    = substr($response, $headersSize);
			$this->headers = array_filter(explode("\r\n", substr($response, 0, $headersSize)));
		}
		$this->curl = $curl;
	}
	
	
	/**
	 * Get response body as array or object.
	 * 
	 * @param bool $assoc (optional) Whether the result is an associative array or an object.
	 *
	 * @return array|mixed
	 */
	public function getBodyAsArray($assoc = true)
	{
		return json_decode($this->getBody(), $assoc);
	}

	/**
	 * Get Body
	 * 
	 * @return string
	 */
	public function getBody()
	{
		return $this->body;
	}


	/**
	 * Get Headers
	 * 
	 * @return array
	 */
	public function getHeaders()
	{
		return $this->headers;
	}


	/**
	 * Assert response HTTP status code.
	 *
	 * @param int $expectedStatusCode
	 *
	 * @return $this
	 */
	public function assertStatusCode($expectedStatusCode)
	{
		$actualStatusCode = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
		$this->assertEquals($expectedStatusCode, $actualStatusCode);

		return $this;
	}


	/**
	 * Assert response body directly from JSON file.
	 *
	 * @param string $jsonFilePath JSON fixture file containing the expected response body.
	 * @param array  $exclude      (optional) Contains items that must not be included in the comparison (e.g.
	 *                             timestamp items).
	 *
	 * @return $this
	 */
	public function assertBodyWithJsonFile($jsonFilePath, array $exclude = array())
	{
		$expectedBody = json_decode(file_get_contents($jsonFilePath), true);
		$actualBody   = json_decode($this->body, true);

		foreach($exclude as $item)
		{
			unset($expectedBody[$item], $actualBody[$item]);
		}

		$this->assertEquals($expectedBody, $actualBody);

		return $this;
	}


	/**
	 * Assert response body with json string.
	 *
	 * @param array $expectedBody
	 *
	 * @return $this
	 */
	public function assertBodyWithAssocArray(array $expectedBody)
	{
		$this->assertEquals($expectedBody, json_decode($this->body, true));

		return $this;
	}


	/**
	 * Assert if headers are present in response.
	 *
	 * @param array $expectedHeaders
	 *
	 * @return $this
	 */
	public function assertHeadersExist(array $expectedHeaders)
	{
		$actualHeaders = array();

		foreach($this->headers as $header)
		{
			$actualHeaders[] = ($pos = strpos($header, ':')) ? substr($header, 0, $pos) : $header;
		}

		foreach($expectedHeaders as $header)
		{
			$this->assertContains($header, $actualHeaders);
		}

		return $this;
	}
}