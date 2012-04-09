<?php

namespace MARSFW\Connectivity;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Facebook
 *
 * @author vanduir
 * @todo Finish this class
 */
class Facebook extends \MARSFW\ReadableObject {

	protected $appId;
	protected $appSecret;

	function __construct($appId, $appSecret) {
		$this->appId = (string) $appId;
		$this->appSecret = (string) $appSecret;
	}

	function get_signedRequestCookieName() {
		return 'fbsr_' . $this->appId;
	}

	function parseSignedRequest($signed_request) {
		list($encoded_sig, $payload) = explode('.', $signed_request, 2);

		// decode the data
		$sig = \MARSFW\base64_decode($encoded_sig, false, \MARSFW\BASE64_URLSAFE);
		$data = \json_decode(\MARSFW\base64_decode($payload, false, \MARSFW\BASE64_URLSAFE), true);

		switch ($data['algorithm']) {
			case 'HMAC-SHA256':
				$expected_sig = hash_hmac('sha256', $payload, $this->appSecret, $raw = true);
				break;
			default:
				throw new \RuntimeException('Unknown algorithm: ' . $data['algorithm']);
		}


		// check sig
		if ($sig !== $expected_sig) {
			echo('Bad Signed JSON signature!');
			return null;
		}

		return $data;
	}
	
	function makeSessionVariableName($key){
		return 'fb_'.$this->appId.'_'.$key;
	}

}

