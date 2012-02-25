<?php

namespace MARSFW;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Object
 *
 * @author vanduir
 */
abstract class Object {

	final function fullClassName() {
		return get_class($this);
	}

	final function className() {
		$cl = get_class($this);
		$pos = strrpos($cl, '\\');
		if ($pos) {
			return substr($cl, $pos + 1);
		}
		return $cl;
	}

	final function namespaceName() {
		$cl = get_class($this);
		$pos = strrpos($cl, '\\');
		if ($pos) {
			return substr($cl, 0, $pos);
		}
		return $cl;
	}

	final function ancestors() {
		$class = get_class($this);
		$out = array();
		do {
			$out[] = $class;
		} while ($class = get_parent_class($class));
		return $out;
	}

}
