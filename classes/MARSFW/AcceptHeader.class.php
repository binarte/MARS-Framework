<?php

namespace MARSFW;

declare (encoding = "UTF-8");

/**
 * Allows to easily manage the data of Accept-* HTTP headers.
 * This class implements ArrayAccess and IteratorAggregate so that the components of the 
 * accept header can be easily accessed via array keys:
 * <code>
 * 
 * </code>
 */
class AcceptHeader extends Object implements \IteratorAggregate {
	const GENERAL = 0;
	const MIME = 1;
	const LANGUAGE = 2;

	/**
	 * Components of the accept header 
	 * @var array 
	 */
	private $components = array();

	/**
	 * If the property names are mime types
	 * @var bool
	 */
	private $dataType;

	/**
	 * Parses an accept string and adds to the object.
	 * Please note that while the component name stays the same on the component object,
	 * it is converted to lowercase for the keys.
	 * <code>
	 * $ah = new AcceptHeader('FOO,Bar');
	 * 
	 * echo $ah['foo']->name; //prints: FOO
	 * echo $ah['bar']->name; //prints: Bar
	 * echo $ah['FOO']->name; //error
	 * echo $ah['Bar']->name; //error
	 * </code>
	 * @param string $string Accept string from a Accept-* HTTP header
	 * @param bool $isMime <b>TRUE</b> if the 
	 */
	function __construct($string, $dataType = self::GENERAL) {
		$string = explode(',', $string);

		foreach ($string as $id => $part) {
			$part = new AcceptHeaderComponent($part, $id);
			$idx = strtolower($part->name);
			if (!isset($this->components[$idx])) {
				$this->components[] = $part;
			}
		}
		uasort($this->components, 'self::sortElems');
		$this->dataType = (int) $dataType;
	}

	/**
	 * Used to sort the components on the accept string
	 * @param AcceptHeaderComponent $e1
	 * @param AcceptHeaderComponent $e2 
	 */
	private static function sortElems($e1, $e2) {
		if ($e1->quality < $e2->quality) {
			return 1;
		}
		if ($e1->quality > $e2->quality) {
			return -1;
		}
		if ($e1->id > $e2->id) {
			return 1;
		}
		if ($e1->id < $e2->id) {
			return -1;
		}
		return 0;
	}

	/**
	 * Finds the best entry for the given name.
	 * This will search for the most specific entry on the list and return it.
	 * 
	 * Remember that the fact an entry is found doesn't mean it should be used. You 
	 * should not serve pages using a parameter that has a quality level of 0.
	 * 
	 * For the case of language headers, this will search for the best quality dialect 
	 * if the specific language is not found.
	 * <code>
	 * $ah = new AcceptHeader('en-us,ja,es-mx',  AcceptHeader::LANGUAGE);
	 * 
	 * echo $ah->find('en');    //en-us
	 * echo $ah->find('ja-jp'); //ja
	 * </code>
	 * @param string $name Name of the entry to search
	 * @return AcceptHeaderComponent If a proper entry is found, it is returned. 
	 * Otherwise, returns <b>NULL</b>
	 * @todo Implement parameter preference
	 */
	public function find($name) {
		$name = strtolower($name);
		$best = null;

		if ($this->dataType == self::MIME) {
			$possible = array(
				$name => 1,
				substr($name, 0, strpos($name, '/')) . '/*' => 2,
				'*/*' => 3,
			);
		} else {
			$possible = array(
				$name => 1,
				'*' => 2,
			);
		}

		foreach ($this->components as $component) {
			if (isset($possible[$component->name])
				and (
				empty($best) or
				$possible[$component->name] > $possible[$best->name]
				)
			) {
				$best = $component;
			}
		}
		if (isset($best)) {
			return $best;
		}

		if ($this->dataType == self::LANGUAGE) {
			if (($p = \strpos($name, '-')) !== false) {
				$name = \substr($name, 0, $p);
			}
			elseif (($p = \strpos($name, '_')) !== false) {
				$name = \substr($name, 0, $p);
			}

			foreach ($this->components as $component) {
				$tname = $component->name;
				if (($p = \strpos($tname, '-')) !== false) {
					$tname = \substr($tname, 0, $p);
				}
				elseif (($p = \strpos($tname, '_')) !== false) {
					$tname = \substr($tname, 0, $p);
				}

				if ($tname == $name) {
					return $component;
				}
			}
		}
		return null;
	}

	/**
	 * Gets an iterator to transverse the components.
	 * @return \ArrayIterator Iterator to transverse the component array
	 */
	public function getIterator() {
		return new \ArrayIterator($this->components);
	}

	function __toString() {
		return join(',', $this->components);
	}

}

/**
 * Component of a accept header string.
 * If there are accept extensions, they can be accessed via array keys thanks to the 
 * <i>ArrayAccess</i> implementation.
 * @property-read string $name Unique identifier string for the component
 * @property-read float $quality Preference quality
 * @property-read int $id Unique number, typically the order in which the component 
 * appears on the accept string
 */
class AcceptHeaderComponent extends ReadableObject implements \ArrayAccess {

	/**
	 * Unique identifier string for the component
	 * @var string 
	 */
	protected $name;

	/**
	 * Unique number, typically the order in which the component appears on the string
	 * @var type 
	 */
	protected $id;

	/**
	 * Preference quality
	 * @var float
	 */
	protected $quality;

	/**
	 * Accept extensions of the component
	 * @var array
	 */
	private $extension = array();

	/**
	 * Instantiates que component according to the string.
	 * @param string $string Component string from the header
	 * @param int $id Id to be used on the component
	 * if none is found on the string
	 */
	function __construct($string, $id) {
		$string = explode(';', $string);
		$this->name = strtolower(trim($string[0]));
		unset($string[0]);
		foreach ($string as $parm) {
			$parm = trim($parm);
			$parm = explode('=', $parm);
			if ($parm[0] == 'q') {
				$this->quality = (real) $parm[1];
			} else {
				$this->extension[$parm[0]] = $parm[1];
			}
		}
		if (!isset($this->quality)) {
			$this->quality = 1.0;
		}
		$this->id = $id;
	}

	/**
	 * Checks of a given extension is present.
	 * @param string $offset name of the extension
	 * @return bool <b>TRUE</b> if the extension exists, <b>FALSE</b> if otherwise
	 */
	public function offsetExists($offset) {
		return isset($this->extension[$offset]);
	}

	/**
	 * Gets the value of a given extension.
	 * @param string $offset name of the extension
	 * @return string Extension value
	 */
	public function offsetGet($offset) {
		return $this->extension[$offset];
	}

	/**
	 * Do not use.
	 * This method is here just to fulfill interface requirements and should not be 
	 * called by any implementation.
	 * @param string $offset
	 * @param string $value
	 * @throws \BadMethodCallException 
	 * @internal
	 */
	public function offsetSet($offset, $value) {
		throw new \BadMethodCallException('Trying to write to read-only object');
	}

	/**
	 * Do not use.
	 * This method is here just to fulfill interface requirements and should not be 
	 * called by any implementation.
	 * @param string $offset
	 * @throws \BadMethodCallException 
	 * @internal
	 */
	public function offsetUnset($offset) {
		throw new \BadMethodCallException('Trying to write to read-only object');
	}

	public function __toString() {
		$out = $this->name;
		if ($this->quality < 1)
			$out .=';q=' . $this->quality;
		foreach ($this->extension as $key => $value) {
			$out .= ';' . $key . '=' . $value;
		}
		return $out;
	}

}