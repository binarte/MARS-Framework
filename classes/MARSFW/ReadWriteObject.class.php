<?php

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
