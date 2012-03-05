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
class OAuth2 extends Request {
	protected $authEndpoint;
	protected $tokenEndpoint;
	protected $clientId;
	protected $clientSecret;
	protected $redirect;
	
	function __construct($authEndpoint,$tokenEndpoint,$clientId,$clientSecret){
		$this->authEndpoint = (string) $authEndpoint;
		$this->tokenEndpoint = (string) $tokenEndpoint;
		$this->clientId = (string) $clientId;
		$this->clientSecret = (string) $clientSecret;
	}
	
	function set_redirect($value){
		$this->redirect = (string) $value;
	}
	
	function get_authUrl(){
		$params = array(
			'response_type'=>'code',
			'client_id' => $this->clientId,
			'redirect_uri' => $this->redirect,
		);
		return $this->authEndpoint . '?' . http_build_query($params);
	}

	public function getResponse() {
		
	}

	
}
