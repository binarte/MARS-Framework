<?php

namespace MARSFW;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of String
 *
 * @author vanduir
 * @property-read int $length Ammount of characters on the string
 * @property-read int $realLength Size of the string in bytes
 * @property-read string $encoding Character encoding of the string
 */
class String extends ReadableObject implements \ArrayAccess {

	/**
	 * Content of the string
	 * @var string 
	 */
	private $content;

	/**
	 * Character encoding of the string
	 * @var string 
	 */
	protected $encoding;

	/**
	 * Ammount of characters on the string
	 * @var int 
	 */
	protected $length;

	/**
	 * Size of the string in bytes
	 * @var int
	 */
	protected $realLength;

	/**
	 * Sets the case-sensitivity of the string operations
	 * @var bool 
	 */
	public $caseSensitive;

	/**
	 * Recalculates the string length 
	 * @uses $length
	 * @uses $realLength
	 * @uses $encoding
	 * @uses $content
	 * @uses \mb_strlen()
	 */
	private function calculateLength() {
		$this->length = \mb_strlen($this->content, $this->encoding);
		$this->realLength = \strlen($this->content);
	}

	/**
	 * Parses the offset and transforms it into an usable type
	 * @param mixed $offset Offset being used
	 * @return int Type fo offset:
	 * - 1 is a number
	 * - 2 is a string
	 * - 3 is a regular expression
	 * - 4 is a range (offset becomes an array with 0 being the range start and 1 being 
	 *  the range length
	 */
	private function getOffset(&$offset) {
		if (is_int($offset) or is_numeric($offset)) {
			$offset = (int) $offset;
			if ($offset < 0)
				$offset += $this->length;
			return 1;
		}
		if (is_array($offset) or $offset instanceof \ArrayObject) {
			$offset = array((int) reset($offset), (int) next($offset));
			return 4;
		}
		if ($offset instanceof String) {
			$offset = $offset->toEncoding($this->encoding);
			return 2;
		}

		$offset = (string) $offset;
		switch ($offset[0]) {
			case ':':
				$offset = \substr($offset, 1);
				return 2;
			case '#':
				return 3;
		}
		if ($offset[0] == ':') {
			$offset = \substr($offset, 1);
			return 2;
		}
		if ($offset[0] == '#') {
			$offset = \substr($offset, 1);
			return 3;
		}
		return 2;
	}

	/**
	 * Instantiates a string object.
	 * @param string $content Content of the string
	 * @param string $encoding Encoding used by the string
	 * @param bool $caseSensitive Case sensitivity to be used on string operations
	 */
	function __construct($content, $encoding = 'UTF-8', $caseSensitive = false) {
		if (empty($encoding))
			$encoding = \mb_detect_encoding($content);
		$this->content = $content;
		$this->encoding = $encoding;
		$this->caseSensitive = $caseSensitive;

		$this->calculateLength();
	}

	/**
	 * Returns the string content
	 * @return string Content of the string
	 */
	function __toString() {
		return $this->content;
	}

	/**
	 * Returns the string content in the specified encoding
	 * @param string $encoding Output encoding. Will use the string's own encoding if not 
	 *  specified
	 * @return string Content of the string
	 */
	function toString($encoding = null) {
		if ($encoding === null || $encoding == $this->encoding) {
			return $this->content;
		}

		return \mb_convert_encoding($this->content, $encoding, $this->encoding);
	}

	/**
	 * Creates new string object with the content converted to the given encoding.
	 * @param type $encoding
	 * @return String 
	 */
	function toEncoding($encoding) {
		return new String($this->toString($encoding), $encoding, $this->caseSensitive);
	}

	/**
	 * Checks is a given the string contains the given value.
	 * @param string $offset Looks 
	 * @return bool
	 */
	public function offsetExists($value, $caseSensitive = null) {
		$caseSensitive = is_null($caseSensitive) ?
				$this->caseSensitive : (bool) $caseSensitive;

		$type = $this->getOffset($offset);
		switch ($type) {
			case 1:
				return $offset > 0 and $offset < $this->length;
			case 2:
				$offset = $caseSensitive ?
						\mb_strpos($this->content, $offset) :
						\mb_stripos($this->content, $offset);

				return $offset !== false;
			case 3:
				return (bool) \preg_match($offset, $this->content);
		}

		return $offset[0] > 0 and $offset[0] + $offset[1] < $this->length;
	}

	/**
	 * 
	 * @param mixed $offset
	 * @param bool $caseSensitive
	 * @return array|MARSFW\String 
	 */
	public function offsetGet($offset, $caseSensitive = null) {
		$caseSensitive = is_null($caseSensitive) ?
				$this->caseSensitive : (bool) $caseSensitive;

		$type = $this->getOffset($offset);
		switch ($type) {
			case 1:
				$out = \mb_substr($this->content, $offset, 1, $this->encoding);
				break;
			case 2:
				$out = $caseSensitive ?
						\mb_strpos($this->content, $offset, 0, $this->encoding) :
						\mb_stripos($this->content, $offset, 0, $this->encoding);
				break;
			case 3:
				$match = null;
				\preg_match($offset, $this->content, $match);
				if ($match) {
					foreach ($match as &$part) {
						$part = new String($part, $this->encoding, $this->caseSensitive);
					}
				}
				return $match;
			default:
				$out = \mb_substr($this->content, $offset[0], $offset[1], $this->encoding);
		}

		return new String($out, $this->encoding, $this->caseSensitive);
	}

	/**
	 * Sets a string offset to a given value.
	 * @param int|string|array $offset
	 * @param string $value
	 * @param bool $caseSensitive
	 * @return type 
	 */
	public function offsetSet($offset, $value, $caseSensitive = null) {
		$caseSensitive = is_null($caseSensitive) ?
				$this->caseSensitive : (bool) $caseSensitive;

		$type = $this->getOffset($offset);
		switch ($type) {
			case 1:
				$this->content =
						\mb_substr($this->content, 0, $offset) .
						$value .
						\mb_substr($this->content, $offset + 1);

				$this->calculateLength();
				return $this;
			case 2:
				if ($caseSensitive) {
					$this->content = \str_replace($offset, $value, $this->content);
				} else {
					$olen = strlen($offset);
					$vlen = strlen($value);
					$pp = 0;
					while (($p = mb_stripos(
					$this->content, $offset, $pp, $this->encoding
					) ) !== false) {
						$this->content =
								mb_substr($this->content, $pp, $p, $this->encoding) .
								$value .
								mb_substr(
										$this->content, $p + $olen, $this->length, $this->encoding
						);
						$pp = $p + $vlen;
					}
				}

				$this->calculateLength();
				return $this;
			case 3:
				$this->content = preg_replace($offset, $value, $this->content);
				$this->calculateLength();
				return $this;
		}


		$this->content =
				\mb_substr($this->content, 0, $offset[0], $this->encoding) .
				$value .
				\mb_substr($this->content, $offset[0] + $offset[1], null, $this->encoding);

		$this->calculateLength();
		return $this;
	}

	/**
	 * Removes the given offset from the string. 
	 * It's the equivalent to calling offsetSet() with the $value parameter set to an 
	 * empty string.
	 * @param mixed $offset The offset to be removed
	 * @uses offsetSet()
	 */
	public function offsetUnset($offset, $caseSensitive = null) {
		$this->offsetSet($offset, '', $caseSensitive);
		return $this;
	}

	/**
	 * Validates the string against it's encoding
	 * @return bool <b>TRUE</b> if the encoding check succeeds 
	 */
	function check() {
		return \mb_check_encoding($this->content, $this->encoding);
	}

	/**
	 * Appends the given content to the string
	 * @param string $str String to be added to the end
	 */
	function a($str) {
		if ($str instanceof String) {
			$str = $str->toString($this->encoding);
		}
		$this->content .= $str;
		$this->calculateLength();
	}

	/**
	 * Prepends the given content to the string
	 * @param string $str String to be added to the beginning
	 */
	function p($str) {
		if ($str instanceof String) {
			$str = $str->toString($this->encoding);
		}
		$this->content = $str . $this->content;
		$this->calculateLength();
	}

	function substring($start, $length = null) {
		return mb_substr($this->content, $start, $length, $this->encoding);
	}

	function convertCase($mode) {
		return new String(
						\mb_convert_case(
								$this->content, $mode, $this->encoding
						), $this->encoding, $this->caseSensitive
		);
	}

	function convertKana($option) {
		return new String(
						\mb_convert_kana($this->encoding, $option, $this->encoding),
						$this->encoding, $this->caseSensitive
		);
	}

	function cut($start, $length = null) {
		return new String(
						\mb_strcut($this->content, $start, $length, $this->encoding)
						, $this->encoding, $this->caseSensitive
		);
	}

	function trimWidth($start, $width, $trimmarker = null) {
		return new String(
						\mb_strimwidth(
								$this->content, $start, $width, $trimmarker, $this->encoding
						)
						, $this->encoding, $this->caseSensitive
		);
	}

	function indexOf($needle, $offset = null, $caseSensitive = null) {
		$caseSensitive = \is_null($caseSensitive) ?
				$this->caseSensitive : (bool) $caseSensitive;
		return $caseSensitive ?
				\mb_strpos($this->content, $needle, $offset, $this->encoding) :
				\mb_stripos($this->content, $needle, $offset, $this->encoding);
	}

	function indexOfRev($needle, $offset = 0, $caseSensitive = null) {
		$caseSensitive = \is_null($caseSensitive) ?
				$this->caseSensitive : (bool) $caseSensitive;
		$cont = $caseSensitive ?
				\mb_strripos($haystack, $needle, $offset, $encoding) :
				\mb_strrpos($haystack, $needle, $offset, $encoding);
		return new String($cont, $this->encoding, $this->caseSensitive);
	}

	function str($needle, $part = false, $caseSensitive = null) {
		$caseSensitive = \is_null($caseSensitive) ?
				$this->caseSensitive : (bool) $caseSensitive;
		$cont = $caseSensitive ?
				\mb_strstr($this->content, $needle, $part, $this->encoding) :
				\mb_stristr($this->content, $needle, $part, $this->encoding);
		return new String($cont, $this->encoding, $this->caseSensitive);
	}

	function width() {
		return \mb_strwidth($this->content, $this->encoding);
	}

}
