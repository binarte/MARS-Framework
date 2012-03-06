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

namespace MARSFW;

declare (encoding = "UTF-8");

/**
 * Abstract class for wrapping handlers that are structure-based rather than object-based
 * in the PHP core.
 *
 * @author vanduir
 */
abstract class WrapperObject extends Object{
	/**
	 * Handler to be managed by the children class.
	 * @var resource
	 */
	protected $handler;
	
	/**
	 * Returns the resource inside the object.
	 * @return resource resource being handled
	 */
	final function getHandler(){
		return $this->handler;
	}
}

