<?php

namespace MARSFW\API\Requests;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Request
 *
 * @author vanduirvm
 */
abstract class Request extends \MARSFW\ReadWriteObject{
	protected $url;	
	
	/**
	 * Executes the request and returns the response.
	 * @return Response 
	 */
	abstract function getResponse();
}

abstract class Response extends \MARSFW\ReadableObject{
	
}