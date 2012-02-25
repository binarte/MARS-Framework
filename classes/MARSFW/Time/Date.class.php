<?php

namespace MARS\Time;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Date
 *
 * @author vanduir
 */
class Date extends Month {

	public function __toString() {
		return $this->format('Y-m-d');
	}

	public function max() {
		$out = new \DateTime(null, $this->getTimezone());
		$out->setTimestamp($this->getTimestamp());
		$out->setTime(23, 59, 59);
		
		return $out;
	}

	public function min() {
		$out = new \DateTime(null, $this->getTimezone());
		$out->setTimestamp($this->getTimestamp());
		$out->setTime(0, 0, 0);
		
		return $out;	
	}
	
}
