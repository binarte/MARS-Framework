<?php

namespace MARSFW;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Color
 *
 * @author vanduir
 */
class Color extends ReadWriteObject {

	static $cssColors = array(
		'aliceblue' => array(0xF0, 0xF8, 0xFF),
		'antiquewhite' => array(0xFA, 0xEB, 0xD7),
		'aqua' => array(0x0, 0xFF, 0xFF),
		'aquamarine' => array(0x7F, 0xFF, 0xD4),
		'azure' => array(0xF0, 0xFF, 0xFF),
		'beige' => array(0xF5, 0xF5, 0xDC),
		'bisque' => array(0xFF, 0xE4, 0xC4),
		'black' => array(0x0, 0x0, 0x0),
		'blanchedalmond' => array(0xFF, 0xEB, 0xCD),
		'blue' => array(0x0, 0x0, 0xFF),
		'blueviolet' => array(0x8A, 0x2B, 0xE2),
		'brown' => array(0xA5, 0x2A, 0x2A),
		'burlywood' => array(0xDE, 0xB8, 0x87),
		'cadetblue' => array(0x5F, 0x9E, 0xA0),
		'chartreuse' => array(0x7F, 0xFF, 0x0),
		'chocolate' => array(0xD2, 0x69, 0x1E),
		'coral' => array(0xFF, 0x7F, 0x50),
		'cornflowerblue' => array(0x64, 0x95, 0xED),
		'cornsilk' => array(0xFF, 0xF8, 0xDC),
		'crimson' => array(0xDC, 0x14, 0x3C),
		'cyan' => array(0x0, 0xFF, 0xFF),
		'darkblue' => array(0x0, 0x0, 0x8B),
		'darkcyan' => array(0x0, 0x8B, 0x8B),
		'darkgoldenrod' => array(0xB8, 0x86, 0xB),
		'darkgray' => array(0xA9, 0xA9, 0xA9),
		'darkgrey' => array(0xA9, 0xA9, 0xA9),
		'darkgreen' => array(0x0, 0x64, 0x0),
		'darkkhaki' => array(0xBD, 0xB7, 0x6B),
		'darkmagenta' => array(0x8B, 0x0, 0x8B),
		'darkolivegreen' => array(0x55, 0x6B, 0x2F),
		'darkorange' => array(0xFF, 0x8C, 0x0),
		'darkorchid' => array(0x99, 0x32, 0xCC),
		'darkred' => array(0x8B, 0x0, 0x0),
		'darksalmon' => array(0xE9, 0x96, 0x7A),
		'darkseagreen' => array(0x8F, 0xBC, 0x8F),
		'darkslateblue' => array(0x48, 0x3D, 0x8B),
		'darkslategray' => array(0x2F, 0x4F, 0x4F),
		'darkslategrey' => array(0x2F, 0x4F, 0x4F),
		'darkturquoise' => array(0x0, 0xCE, 0xD1),
		'darkviolet' => array(0x94, 0x0, 0xD3),
		'deeppink' => array(0xFF, 0x14, 0x93),
		'deepskyblue' => array(0x0, 0xBF, 0xFF),
		'dimgray' => array(0x69, 0x69, 0x69),
		'dimgrey' => array(0x69, 0x69, 0x69),
		'dodgerblue' => array(0x1E, 0x90, 0xFF),
		'firebrick' => array(0xB2, 0x22, 0x22),
		'floralwhite' => array(0xFF, 0xFA, 0xF0),
		'forestgreen' => array(0x22, 0x8B, 0x22),
		'fuchsia' => array(0xFF, 0x0, 0xFF),
		'gainsboro' => array(0xDC, 0xDC, 0xDC),
		'ghostwhite' => array(0xF8, 0xF8, 0xFF),
		'gold' => array(0xFF, 0xD7, 0x0),
		'goldenrod' => array(0xDA, 0xA5, 0x20),
		'gray' => array(0x80, 0x80, 0x80),
		'grey' => array(0x80, 0x80, 0x80),
		'green' => array(0x0, 0x80, 0x0),
		'greenyellow' => array(0xAD, 0xFF, 0x2F),
		'honeydew' => array(0xF0, 0xFF, 0xF0),
		'hotpink' => array(0xFF, 0x69, 0xB4),
		'indianred' => array(0xCD, 0x5C, 0x5C),
		'indigo' => array(0x4B, 0x0, 0x82),
		'ivory' => array(0xFF, 0xFF, 0xF0),
		'khaki' => array(0xF0, 0xE6, 0x8C),
		'lavender' => array(0xE6, 0xE6, 0xFA),
		'lavenderblush' => array(0xFF, 0xF0, 0xF5),
		'lawngreen' => array(0x7C, 0xFC, 0x0),
		'lemonchiffon' => array(0xFF, 0xFA, 0xCD),
		'lightblue' => array(0xAD, 0xD8, 0xE6),
		'lightcoral' => array(0xF0, 0x80, 0x80),
		'lightcyan' => array(0xE0, 0xFF, 0xFF),
		'lightgoldenrodyellow' => array(0xFA, 0xFA, 0xD2),
		'lightgray' => array(0xD3, 0xD3, 0xD3),
		'lightgrey' => array(0xD3, 0xD3, 0xD3),
		'lightgreen' => array(0x90, 0xEE, 0x90),
		'lightpink' => array(0xFF, 0xB6, 0xC1),
		'lightsalmon' => array(0xFF, 0xA0, 0x7A),
		'lightseagreen' => array(0x20, 0xB2, 0xAA),
		'lightskyblue' => array(0x87, 0xCE, 0xFA),
		'lightslategray' => array(0x77, 0x88, 0x99),
		'lightslategrey' => array(0x77, 0x88, 0x99),
		'lightsteelblue' => array(0xB0, 0xC4, 0xDE),
		'lightyellow' => array(0xFF, 0xFF, 0xE0),
		'lime' => array(0x0, 0xFF, 0x0),
		'limegreen' => array(0x32, 0xCD, 0x32),
		'linen' => array(0xFA, 0xF0, 0xE6),
		'magenta' => array(0xFF, 0x0, 0xFF),
		'maroon' => array(0x80, 0x0, 0x0),
		'mediumaquamarine' => array(0x66, 0xCD, 0xAA),
		'mediumblue' => array(0x0, 0x0, 0xCD),
		'mediumorchid' => array(0xBA, 0x55, 0xD3),
		'mediumpurple' => array(0x93, 0x70, 0xD8),
		'mediumseagreen' => array(0x3C, 0xB3, 0x71),
		'mediumslateblue' => array(0x7B, 0x68, 0xEE),
		'mediumspringgreen' => array(0x0, 0xFA, 0x9A),
		'mediumturquoise' => array(0x48, 0xD1, 0xCC),
		'mediumvioletred' => array(0xC7, 0x15, 0x85),
		'midnightblue' => array(0x19, 0x19, 0x70),
		'mintcream' => array(0xF5, 0xFF, 0xFA),
		'mistyrose' => array(0xFF, 0xE4, 0xE1),
		'moccasin' => array(0xFF, 0xE4, 0xB5),
		'navajowhite' => array(0xFF, 0xDE, 0xAD),
		'navy' => array(0x0, 0x0, 0x80),
		'oldlace' => array(0xFD, 0xF5, 0xE6),
		'olive' => array(0x80, 0x80, 0x0),
		'olivedrab' => array(0x6B, 0x8E, 0x23),
		'orange' => array(0xFF, 0xA5, 0x0),
		'orangered' => array(0xFF, 0x45, 0x0),
		'orchid' => array(0xDA, 0x70, 0xD6),
		'palegoldenrod' => array(0xEE, 0xE8, 0xAA),
		'palegreen' => array(0x98, 0xFB, 0x98),
		'paleturquoise' => array(0xAF, 0xEE, 0xEE),
		'palevioletred' => array(0xD8, 0x70, 0x93),
		'papayawhip' => array(0xFF, 0xEF, 0xD5),
		'peachpuff' => array(0xFF, 0xDA, 0xB9),
		'peru' => array(0xCD, 0x85, 0x3F),
		'pink' => array(0xFF, 0xC0, 0xCB),
		'plum' => array(0xDD, 0xA0, 0xDD),
		'powderblue' => array(0xB0, 0xE0, 0xE6),
		'purple' => array(0x80, 0x0, 0x80),
		'red' => array(0xFF, 0x0, 0x0),
		'rosybrown' => array(0xBC, 0x8F, 0x8F),
		'royalblue' => array(0x41, 0x69, 0xE1),
		'saddlebrown' => array(0x8B, 0x45, 0x13),
		'salmon' => array(0xFA, 0x80, 0x72),
		'sandybrown' => array(0xF4, 0xA4, 0x60),
		'seagreen' => array(0x2E, 0x8B, 0x57),
		'seashell' => array(0xFF, 0xF5, 0xEE),
		'sienna' => array(0xA0, 0x52, 0x2D),
		'silver' => array(0xC0, 0xC0, 0xC0),
		'skyblue' => array(0x87, 0xCE, 0xEB),
		'slateblue' => array(0x6A, 0x5A, 0xCD),
		'slategray' => array(0x70, 0x80, 0x90),
		'slategrey' => array(0x70, 0x80, 0x90),
		'snow' => array(0xFF, 0xFA, 0xFA),
		'springgreen' => array(0x0, 0xFF, 0x7F),
		'steelblue' => array(0x46, 0x82, 0xB4),
		'tan' => array(0xD2, 0xB4, 0x8C),
		'teal' => array(0x0, 0x80, 0x80),
		'thistle' => array(0xD8, 0xBF, 0xD8),
		'tomato' => array(0xFF, 0x63, 0x47),
		'turquoise' => array(0x40, 0xE0, 0xD0),
		'violet' => array(0xEE, 0x82, 0xEE),
		'wheat' => array(0xF5, 0xDE, 0xB3),
		'white' => array(0xFF, 0xFF, 0xFF),
		'whitesmoke' => array(0xF5, 0xF5, 0xF5),
		'yellow' => array(0xFF, 0xFF, 0x0),
		'yellowgreen' => array(0x9A, 0xCD, 0x32),
	);

	static function createFromCss($str) {
		$str = trim($str);
		$str = strtolower($str);
		if (preg_match('@^#[0-9a-f]{3}([0-9a-f]{3})?$@', $str)) {
			$str = substr($str, 1);
			if (strlen($str) == 3) {
				$str = str_split($str, 1);
				return new Color(
								hexdec($str[0] . $str[0]),
								hexdec($str[1] . $str[1]),
								hexdec($str[2] . $str[2])
				);
			}
			$str = str_split($str, 2);
			return new Color(
							hexdec($str[0]),
							hexdec($str[1]),
							hexdec($str[2])
			);
		}
		$n = '\s*[0-9]+\s*';
		$a = '\s*[01](\\.[0-9]+)?\s*';
		if (preg_match("@(rgba?)\(($n),($n),($n)(,$a)?\)@", $str, $match)) {
			if ($match[1] == 'rgba') {
				if (!empty($match[5])) {
					$a = substr($match[5], 1);
					return new Color($match[2], $match[3], $match[4], $a);
				}
			} else {
				return new Color($match[2], $match[3], $match[4]);
			}
		}
		if (isset(self::$cssColors[$str])) {
			$c = self::$cssColors[$str];
			return new Color($c[0], $c[1], $c[2]);
		}
	}

	protected $red;
	protected $green;
	protected $blue;
	protected $alpha;

	function __construct($red, $green, $blue, $alpha = 1.0) {
		$this->red = (int) $red;
		$this->green = (int) $green;
		$this->blue = (int) $blue;
		$this->alpha = (float) $alpha;

		if ($this->red > 255)
			$this->red = 255;
		elseif ($this->red < 0)
			$this->red = 0;
		if ($this->green > 255)
			$this->green = 255;
		elseif ($this->green < 0)
			$this->green = 0;
		if ($this->blue > 255)
			$this->blue = 255;
		elseif ($this->blue < 0)
			$this->blue = 0;
		if ($this->alpha > 1)
			$this->alpha = 1.0;
		elseif ($this->alpha < 0)
			$this->alpha = 0.0;
	}

	function toGDInt() {
		return
				(round((1.0 - $this->alpha) * 127) << 24) |
				($this->red << 16) |
				($this->green << 8) |
				($this->blue );
	}

	function toCssShort() {
		return '#' .
				dechex(round($this->red / 17)) .
				dechex(round($this->green / 17)) .
				dechex(round($this->blue / 17));
	}

	function toCss() {
		return '#' .
				$this->getHex($this->red) .
				$this->getHex($this->green) .
				$this->getHex($this->blue);
	}

	function toCssRgb() {
		return 'rgb(' .
				$this->red . ',' .
				$this->green . ',' .
				$this->blue .
				')';
	}

	function toCssRgba() {
		return 'rgba(' .
				$this->red . ',' .
				$this->green . ',' .
				$this->blue . ',' .
				$this->alpha .
				')';
	}

	protected function getHex($parm) {
		$parm = dechex($parm);
		if (strlen($parm) == 1)
			return '0' . $parm;
		return $parm;
	}

}
