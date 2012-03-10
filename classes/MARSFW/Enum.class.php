<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MARSFW;

/**
 * Description of Enum
 *
 * @author vanduir
 */
abstract class Enum extends Object {

	//put your code here
	protected $value;

	function getCode($name, array $values, $parent = 'Enum') {
		$out = "class $name extends $parent{";
		$tr = 'protected static$tr=array(';

		$st = 1;
		foreach ($values as $key) {
			$out .= "const $key=$st;";
			$tr .= "$st=>'$key',";
			$st++;
		}

		return $out . $tr . ');' .
		  'protected function getIntVal($value){return constant(\'self::\'.$value);}' .
		  'protected function getStringVal($value){return self::$tr[$value];}' .
		  'protected function hasStringVal($value){return defined(\'self::\'.$value);}' .
		  'protected function hasIntVal($value){return isset(self::$tr[$value]);}' .
		  '}';
	}

	function create($name, array $values, $parent = 'Enum') {
		eval(self::getCode($name, $values, $parent));
	}

	function __construct($value) {
		if (is_int($value)) {
			$this->getStringVal($value);
			$this->value = $value;
			return;
		}
		if ($value instanceof Enum) {
			$this->value = $value->value;
			return;
		}
		$this->value = $this->getIntVal((string) $value);
	}

	function __toString() {
		return $this->getStringVal($this->value);
	}

	function is($value) {
		if (is_int($this->value)) {
			return $this->value == $value;
		}
		if ($value instanceof Enum) {
			return $value->value == $value;
		}
		return $this->value == $this->getStringVal((string) $value);
	}

	function toInt() {
		return $this->value;
	}

	function toString() {
		return $this->getStringVal($this->value);
	}

	protected function getIntVal($value) {
		return constant(get_class($this) . '::' . $value);
	}

	protected function getStringVal($value) {
		eval('return ' . get_class($this) . '::$tr[$value];');
	}

	protected function hasStringVal($value) {
		return defined(get_class($this) . '::' . $value);
	}

	protected function hasIntVal($value) {
		eval('return isset(' . get_class($this) . '::$tr[$value]);');
	}

}
