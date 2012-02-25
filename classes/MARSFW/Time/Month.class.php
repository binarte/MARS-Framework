<?php

namespace MARS\Time;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Month
 *
 * @author vanduir
 */
class Month extends Object {

	public function __toString() {
		return $this->format('Y-m');
	}

	public function max() {
		$out = new \DateTime(null, $this->getTimezone());

		$out->setTimestamp($this->getTimestamp());

		$out->setTime(23, 59, 59);
		$out->setDate($out->format('Y'), $out->format('m'), $out->format('t'));
		
		return $out;
	}

	public function min() {
		$out = new \DateTime(null, $this->getTimezone());

		$out->setTimestamp($this->getTimestamp());

		$out->setTime(0, 0, 0);
		$out->setDate($out->format('Y'), $out->format('m'), 1);	
		
		return $out;	
	}
	
	function toMonth(){
		return clone $this;
	}

}
