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
