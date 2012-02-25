<?php
/*
 * Copyright (C) year Vanduir Volpato Maia
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
declare(encoding="UTF-8");

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Object that allows easy reading of it's properties without giving the user direct 
 * access to them.
 * @example /samples/ReadableObject.php
 * @author vanduir
 */
abstract class ReadableObject extends Object {

	/**
	 * Returns a given property.
	 * If there's a protected property with the name, it will return that property's 
	 * value. Otherwise it will return the value of a method called 
	 * "get_<property name>"
	 * @param string $p Name of the property
	 * @return mixed Value of the property 
	 * @todo This method uses a very hack-y way of detecting if the preperty is present 
	 * or not. If PHP implements a way of finding out if a property is private in the 
	 * future, replacing it would be ideal.
	 * @uses Manager::simpleError_start
	 * @uses Manager::simpleError_end
	 * @internal
	 */
	final function __get($p) {
		Manager::simpleError_start();
		$out = $this->$p;
		if (!Manager::simpleError_end()){
			return $out;
		}
		
		$p = 'get_' . $p;
		return $this->$p();
	}

	/**
	 * Check if a given property is set.
	 * If there's a protected property with the name, it will check if that property is 
	 * non-null. Otherwise it will return the value of a method called 
	 * "isset_<property name>"
	 * @param string $p Name of the attribute
	 * @return bool <b>TRUE</b> if the property is non-null, <b>FALSE</b> if otherwise
	 * @todo This method uses a very hack-y way of detecting if the preperty is present 
	 * or not. If PHP implements a way of finding out if a property is private in the 
	 * future, replacing it would be ideal.
	 * @uses Manager::simpleError_start
	 * @uses Manager::simpleError_end
	 * @internal
	 */
	final function __isset($p) {
		Manager::simpleError_start();
		$out = $this->$p;
		if (!Manager::simpleError_end()){
			return isset($out);
		}

		$attr = 'isset_' . $p;
		return (bool) $this->$p();
	}

}
