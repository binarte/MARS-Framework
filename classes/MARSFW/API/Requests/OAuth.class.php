<?php

namespace MARSFW\API\Requests;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OAuth
 *
 * @author vanduirvm
 */
class OAuth extends Request {
	protected $url;
	protected $clientId;
	
	function __construct($url,$clientId){
		$this->url = (string) $url;
		$this->clientId = (string) $clientId;
	}

	public function getResponse() {
		
	}

	
}
