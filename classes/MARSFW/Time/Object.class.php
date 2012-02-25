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

declare(encoding = "UTF-8");
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Object
 *
 * @author vanduir
 */
abstract class Object extends \DateTime {


	function __get($prop) {
		return $this->format($prop);
	}

	abstract function __toString();

	final function toString() {
		return $this->__toString();
	}

	final function formatLocale($format,LocaleData $locale) {
		$l = strlen($format);
		$out = '';
		for ($i = 0; $i < $l; $i++) {
			/**
			 *D 	A textual representation of a day, three letters 	Mon through Sun
j 	Day of the month without leading zeros 	1 to 31
l (lowercase 'L') 	A full textual representation of the day of the week 	Sunday through Saturday
N 	ISO-8601 numeric representation of the day of the week (added in PHP 5.1.0) 	1 (for Monday) through 7 (for Sunday)
S 	English ordinal suffix for the day of the month, 2 characters 	st, nd, rd or th. Works well with j
w 	Numeric representation of the day of the week 	0 (for Sunday) through 6 (for Saturday)
z 	The day of the year (starting from 0) 	0 through 365
Week 	--- 	---
W 	ISO-8601 week number of year, weeks starting on Monday (added in PHP 4.1.0) 	Example: 42 (the 42nd week in the year)
Month 	--- 	---
F 	A full textual representation of a month, such as January or March 	January through December
m 	Numeric representation of a month, with leading zeros 	01 through 12
M 	A short textual representation of a month, three letters 	Jan through Dec
n 	Numeric representation of a month, without leading zeros 	1 through 12
t 	Number of days in the given month 	28 through 31
Year 	--- 	---
L 	Whether it's a leap year 	1 if it is a leap year, 0 otherwise.
o 	ISO-8601 year number. This has the same value as Y, except that if the ISO week number (W) belongs to the previous or next year, that year is used instead. (added in PHP 5.1.0) 	Examples: 1999 or 2003
Y 	A full numeric representation of a year, 4 digits 	Examples: 1999 or 2003
y 	A two digit representation of a year 	Examples: 99 or 03
Time 	--- 	---
a 	Lowercase Ante meridiem and Post meridiem 	am or pm
A 	Uppercase Ante meridiem and Post meridiem 	AM or PM 
			 */
			$out .= $this->formatPrepareChr($format[$i]);
		}
		return parent::format($format);
	}

	protected function formatPrepareChr($chr) {
		switch ($fmt[$i]) {
			//replace the legacy 'w' with the stanard one
			case 'w':
				return 'N';
			//numeric values don't need translation
			case 'd':
			case 'j':
			case 'N':
			case 'z':
			case 'W':
			case 'm':
			case 'n':
			case 't':
			case 'L':
			case 'o':
			case 'Y':
			case 'y':
			case 'B':
			case 'g':
			case 'G':
			case 'h':
			case 'H':
			case 'i':
			case 's':
			case 'u':
			case 'e':
			case 'I':
			case 'O':
			case 'P':
			case 'T':
			case 'Z':
				return $fmt[$i];
		}
		return '\\' . $fmt[$i];
	}

	abstract function min();

	abstract function max();
}
