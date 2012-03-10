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

namespace MARSFW\API\Client;
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