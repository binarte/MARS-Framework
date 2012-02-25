<?php

namespace MARS\Time;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Week
 *
 * @author vanduir
 */
class Week extends Object{

	public function __toString() {
		return $this->format('o-\WW');
	}

	public function max() {
		$out = new \DateTime(null, $this->getTimezone());
		
		$out->setTime(23, 59, 59);
		return $out;	
	}

	public function min() {
		$out = new \DateTime(null, $this->getTimezone());
		$out->setTime(0, 0, 0);
		return $out;			
	}
	
	function toWeek(){
		return clone $this;
	}
}
