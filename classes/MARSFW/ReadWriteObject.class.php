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
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReadWriteObject
 *
 * @author vanduir
 */
abstract class ReadWriteObject extends ReadableObject {
	//put your code here
	final function __set($attr,$value){
		$attr = 'set_'.$attr;
		$this->$attr($value);
	}
	
	final function __unset($attr){
		$attr = 'unset_'.$attr;
		$this->$attr();		
	}
}
