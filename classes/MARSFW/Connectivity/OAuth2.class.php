<?php

/*
 * Copyright (C) 2012 Vanduir Volpato Maia
 * 
 * This library is free software; you can redistribute it and/or modify it under the 
 * terms of the GNU Lesser General Public License as published by the Free Software 
 * Foundation; either version 2.1 of the License, or (at your option) any later version.
 * 
 * This library is distributed in the hope that it will be useful, but WITHOUT ANY 
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A 
 * PARTICULAR PURPOSE.  See the GNU Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public License along with 
 * this library; if not, write to the Free Software Foundation, Inc., 51 Franklin Street, 
 * Fifth Floor, Boston, MA  02110-1301  USA
 */

namespace MARSFW\Connectivity;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OAuth
 *
 * @author vanduirvm
 */
class OAuth2 extends \MARSFW\ReadWriteObject{

	const METHOD_GET = 1;
	const METHOD_POST = 2;
	const METHOD_PUT = 3;
	const METHOD_DELETE = 4;
	const METHOD_HEAD = 5;

	protected $prefix;
	protected $authEndpoint = 'authorize';
	protected $tokenEndpoint = 'token';
	protected $clientId;
	protected $clientSecret;
	protected $code;
	protected $redirect;
	protected $grantType;
	protected $method = self::METHOD_GET;
	
	private $curl;
	private $curlHandler;

	function __construct($prefix, $clientId, $clientSecret) {
		$this->prefix = (string) $prefix;
		$this->clientId = (string) $clientId;
		$this->clientSecret = (string) $clientSecret;
		$this->curl = new \MARSFW\CUrl;
		$this->curlHandler = $this->curl->getHandler();
		
		curl_setopt($this->curlHandler, CURLOPT_RETURNTRANSFER, true);
	}

	function set_code($value) {
		$this->code = (string) $value;
	}

	function set_redirect($value) {
		$this->redirect = (string) $value;
	}

	function set_grantType($value) {
		$this->grantType = (string) $value;
	}

	function get_authUrl() {
		$params = array(
			'response_type' => 'code',
			'client_id' => $this->clientId,
			'redirect_uri' => $this->redirect,
		);
		return $this->prefix . $this->authEndpoint . '?' . http_build_query($params);
	}

	function get_accessToken() {
		$parameters = array('code' => $this->code);
		$parameters['grant_type'] = $this->grantType;
		$http_headers = array();
		/* switch ($this->client_auth) {
		  case self::AUTH_TYPE_URI:
		  case self::AUTH_TYPE_FORM: */
		$parameters['client_id'] = $this->clientId;
		$parameters['client_secret'] = $this->clientSecret;
		/*    break;
		  case self::AUTH_TYPE_AUTHORIZATION_BASIC:
		  $parameters['client_id'] = $this->client_id;
		  $http_headers['Authorization'] = 'Basic ' . base64_encode($this->client_id .  ':' . $this->client_secret);
		  break;
		  default:
		  throw new Exception('Unknown client auth type.');
		  break;
		  } */
		var_dump($this->prefix . $this->tokenEndpoint);

		return $this->executeRequest($this->prefix . $this->tokenEndpoint, $parameters, 'POST', $http_headers, 0);
	}

	public function getResponse() {
		
	}

	private function executeRequest($url, $parameters = array(), $http_method = self::HTTP_METHOD_GET, array $http_headers = null, $form_content_type = self::HTTP_FORM_CONTENT_TYPE_MULTIPART) {
		//$parameters['format'] = 'xml';
		
		$curlopt = array();
		

		switch ($this->method) {
			case self::METHOD_POST:
				$curlopt[CURLOPT_POST] = true;
			case self::METHOD_PUT:
				if (is_array($parameters) && 0 === $form_content_type) {
					$parameters = http_build_query($parameters);
				}
				$curlopt[CURLOPT_POSTFIELDS] = $parameters;
				break;
			case self::METHOD_HEAD:
				$curlopt[CURLOPT_NOBODY] = true;
			case self::METHOD_DELETE:
			case self::METHOD_GET:
				if (is_array($parameters)) {
					$url .= '?' . http_build_query($parameters, null, '&');
				} elseif ($parameters) {
					$url .= '?' . $parameters;
				}
				break;
			default:
				break;
		}
		
		$curlopt[CURLOPT_URL]=$url;

		if (is_array($http_headers)) {
			$header = array();
			foreach ($http_headers as $key => $parsed_urlvalue) {
				$header[] = "$key: $parsed_urlvalue";
			}
			$curlopt[CURLOPT_HTTPHEADER] = $header;
		}

		var_dump ($parameters);
		var_dump ($curlopt);
		
		curl_setopt_array($this->curlHandler, $curlopt);

		$result = $this->curl->execThrow();

		return Array(
			curl_getinfo($this->curlHandler, CURLINFO_CONTENT_TYPE),
			$result
		);
	}

}
/*
class OAuth2Response extends Response {

	protected $contentType;
	protected $result;

	function __construct( $contentType, $result) {
		$this->contentType = $contentType;
		$this->result = $result;
	}

}*/
