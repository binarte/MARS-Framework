<?php

namespace MARS\Time;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class DateTimeLocal extends Date {

	private $microseconds;

	function __construct($format = null, \DateTimeZone $zone = null) {
		if (!isset ($format) ){
			$t = microtime();
			$t = explode(' ',$t);
			if (isset ($zone) ){
				parent::__construct(null,$zone);
			}
			else {
				parent::__construct();
			}
			$this->setTimestamp($t[1]);
			$this->microseconds = (int) round($t[0] * 1000000);
			return;
		}
			if (isset ($zone) ){
				parent::__construct($format,$zone);
			}
			else {
				parent::__construct($format);
			}

		if (preg_match('#[0-9]{1,2}:[0-9]{1,2}:[0-9]{1,2}.([0-9]{1,6})#',$format,$match)) {
			$this->microseconds = (int) str_pad($match[1], 6, '0', STR_PAD_RIGHT);
		}
		else {
			$this->microseconds = 0;
		}
	}

	public function __toString() {
		return $this->format('Y-m-d\TH:i:s.u');
	}

	public function max() {
		$out = new \DateTime(null, $this->getTimezone());
		$out->setTimestamp($this->getTimestamp());
		return $out;
	}

	public function min() {
		$out = new \DateTime(null, $this->getTimezone());
		$out->setTimestamp($this->getTimestamp());
		return $out;
	}
	
	public function format($fmt){
		$micro = str_pad($this->microseconds,6,'0',STR_PAD_LEFT);
		var_dump ($micro);
		var_dump (preg_match('#([^\\\\])(u)#',$fmt,$m),$m);
		$fmt = preg_replace('#([^\\\\])(u)#','${1}'.$micro,$fmt);		
		if ($fmt[0] == 'u'){
			$fmt = $micro.substr($fmt,1);
		}
		return parent::format($fmt);
	}

}