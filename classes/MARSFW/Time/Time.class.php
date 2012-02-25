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

namespace MARS\Time;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Time
 *
 * @author vanduir
 */
class Time extends \MARS\Object {

	protected $hour;
	protected $minute;
	protected $second;
	protected $microsecond;

	function __construct($str = null) {
		if (!func_num_args()) {
			$t = explode(' ', microtime());
			$ts = (int) $t[1];
			var_dump($t);
			$t = $t[0];
			$this->hour = idate('H', $ts);
			$this->minute = idate('i', $ts);
			$this->second = idate('s', $ts);
			$this->microsecond = (int) round($t * 1000000);
			return;
		}

		$str = (string) $str;
		if (preg_match('#^([0-2]?[0-9]):([0-5]?[0-9])(' .
			':([0-5]?[0-9])(\.([0-9]+))?' .
			')?$#', $str, $match)) {

			var_dump($match);
			$this->hour = (int) $match[1];
			$this->minute = (int) $match[2];
			$this->second = (int) $match[4];
			$this->microsecond = (int) $match[6];
			$this->check_values($str);
			return;
		}
		if (preg_match('#^([0-1]?[0-9])(:([0-5]?[0-9])(' .
			':([0-5]?[0-9])(\.([0-9]+))?' .
			')?)?(A|P)M$#i', $str, $match)) {

			var_dump($match);
			$this->hour = (int) $match[1];

			if ($this->hour == 12) {
				$this->hour = 0;
			}

			if ($match[8] == 'p' || $match[8] == 'P') {
				$this->hour += 12;
				if ($this->hour == 24) {
					$this->hour = 0;
				}
			} elseif ($this->hour < 12) {
				$this->minute = (int) $match[3];
				$this->second = (int) $match[5];
				$this->microsecond = (int) $match[7];
				$this->check_values($str);
				return;
			}
		}
		throw new \UnexpectedValueException('Invalid time format "' . $str . '"');
	}

	public function getTotalSeconds() {
		return
		  ($this->hour * 3600) +
		  ($this->minute * 60) +
		  ($this->second) +
		  ($this->microsecond / 1000000);
	}

	private function check_values($str) {
		if (
		  $this->hour > 23 or
		  $this->minute > 59 or
		  $this->second > 59 or
		  $this->microsecond > 999999
		) {
			throw new \UnexpectedValueException('Invalid time format "' . $str . '"');
		}
	}

	//put your code here
	public function __toString() {
		return $this->format('H:i:s.u');
	}

	function toString() {
		return $this->__toString();
	}

	function format($fmt) {
		$fmt = (string) $fmt;
		$l = strlen($fmt);

		$out = '';
		for ($i = 0; $i < $l; $i++) {
			switch ($fwt[$i]) {
				case '\\':
					$i++;
					break;
				case 'a':
					$out .= ($this->hour >= 12) ? 'am' : 'pm';
					break;
				case 'A':
					$out .= ($this->hour >= 12) ? 'AM' : 'PM';
					break;
				case 'B':
					$out .= str_pad(
					  floor($this->getTotalSeconds() / 86.4), 3, '0', STR_PAD_LEFT
					);
					break;
				case 'g':
					if ($this->hour == 0) {
						$out .= '12';
					} else {
						$out .= $this->hour % 12;
					}
					break;
				case 'G':
					$out .= $this->hour;
					break;
				case 'h':
					if ($this->hour == 0) {
						$out .= '12';
					} else {
						$v = $this->hour % 12;
						if ($v < 10) {
							$out .= '0' . $v;
						} else {
							$out .= $v;
						}
					}
					break;
				case 'H':
					if ($this->hour < 10) {
						$out .= '0' . $this->hour;
					} else {
						$out .= $this->hour;
					}
					break;
				case 'i':
					if ($this->minute < 10) {
						$out .= '0' . $this->minute;
					} else {
						$out .= $this->minute;
					}
					break;
				case 's':
					if ($this->second < 10) {
						$out .= '0' . $this->second;
					} else {
						$out .= $this->second;
					}
					break;
				case 'u':
					$out .= str_pad($this->microseconds, 6, '0', STR_PAD_LEFT);
					break;
				default:
					$out .= $fmt[$i];
			}

			return $out;
		}/*
		  a 	Lowercase Ante meridiem and Post meridiem 	am or pm
		  A 	Uppercase Ante meridiem and Post meridiem 	AM or PM
		  B 	Swatch Internet time 	000 through 999
		  g 	12-hour format of an hour without leading zeros 	1 through 12
		  G 	24-hour format of an hour without leading zeros 	0 through 23
		  h 	12-hour format of an hour with leading zeros 	01 through 12
		  H 	24-hour format of an hour with leading zeros 	00 through 23
		  i 	Minutes with leading zeros 	00 to 59
		  s 	Seconds, with leading zeros 	00 through 59
		  u 	Microseconds (added in PHP 5.2.2) 	Example: 654321
		 * 
		 */
	}

}
