<?php

namespace MARSFW\GD;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Filter
 *
 * @author vanduir
 * @property-write int $brightness Brightness level. 
 * @property-write int $contrast 
 * @property-write int $smoothness 
 * @property-write int $blockSize 
 * @property-write int $advanced 
 * @property-write int $red 
 * @property-write int $green 
 * @property-write int $blue 
 * @property-write int $alpha
 */
class Filter extends \MARSFW\ReadWriteObject {
	/**
	 * Reverses all colors of the image.
	 * @var int
	 */

	const NEGATE = \IMG_FILTER_NEGATE;
	/**
	 * Converts the image into grayscale.
	 * @var int
	 */
	const GRAYSCALE = \IMG_FILTER_GRAYSCALE;

	/**
	 * Changes the brightness of the image.
	 * @see $brightness
	 * @see set_brightness() 
	 * @var int
	 */
	const BRIGHTNESS = \IMG_FILTER_BRIGHTNESS;

	/**
	 * Changes the contrast of the image.
	 * @see $brightness
	 * @see set_brightness() 
	 * @var int
	 */
	const CONTRAST = \IMG_FILTER_CONTRAST;

	/**
	 * Tints the image.
	 * Like GRAYSCALE, except you can specify the color. The range for each color is 0 to 
	 * 255.
	 * @var int
	 * @see $red 
	 * @see $green
	 * @see $blue
	 * @see $alpha
	 * @see set_red() 
	 * @see set_green() 
	 * @see set_blue() 
	 * @see set_alpha() 
	 * @var int
	 */
	const COLORIZE = \IMG_FILTER_COLORIZE;

	/**
	 * Uses edge detection to highlight the edges in the image.
	 * @var int
	 */
	const EDGEDETECT = \IMG_FILTER_EDGEDETECT;

	/**
	 * Embosses the image.
	 * @var int 
	 */
	const EMBOSS = \IMG_FILTER_EMBOSS;

	/**
	 * Uses mean removal to achieve a "sketchy" effect.
	 * @var int
	 */
	const MEAN_REMOVAL = \IMG_FILTER_MEAN_REMOVAL;

	/**
	 * Makes the image smoother.
	 * @see $smoothness
	 * @see set_smoothness()
	 * @var int
	 */
	const SMOOTH = \IMG_FILTER_SMOOTH;

	/**
	 * Blurs the image using the Gaussian method.
	 * @var int
	 */
	const GAUSSIAN_BLUR = \IMG_FILTER_GAUSSIAN_BLUR;

	/**
	 * Blurs the image.
	 * @var int
	 */
	const SELECTIVE_BLUR = \IMG_FILTER_SELECTIVE_BLUR;

	/**
	 * Applies pixelation effect to the image;
	 * @see $blockSize
	 * @see $advanced
	 * @see $set_blockSize
	 * @see $set_advanced
	 * @var int
	 */
	const PIXELATE = \IMG_FILTER_PIXELATE;

	/**
	 * Filtertype
	 * @var int
	 */
	protected $filterId;

	/**
	 * First argument passed to the filter function.
	 * @var int 
	 */
	protected $arg1;

	/**
	 * Second argument passed to the filter function.
	 * @var int 
	 */
	protected $arg2;

	/**
	 * Third argument passed to the filter function.
	 * @var int 
	 */
	protected $arg3;

	/**
	 * Fourth argument passed to the filter function.
	 * @var int 
	 */
	protected $arg4;

	/**
	 * The ammount of parameters to be used in the filter function
	 * @var type 
	 */
	protected $parmcount = 0;

	/**
	 * Instantiates a GD image filter.
	 * @param int $filterId Type of filter. Use IMG_FILTER_* or Filter::* constants for 
	 *  this.
	 * @see NEGATE Reverses all colors of the image.
	 * @see GRAYSCALE Converts the image into grayscale.
	 * @see BRIGHTNESS Changes the brightness of the image. 
	 * @see CONTRAST Changes the contrast of the image. 
	 * @see COLORIZE Like GRAYSCALE, except you can specify the color.
	 * @see EDGEDETECT Uses edge detection to highlight the edges in the image.
	 * @see EMBOSS Embosses the image.
	 * @see GAUSSIAN_BLUR Blurs the image using the Gaussian method.
	 * @see SELECTIVE_BLUR Blurs the image.
	 * @see MEAN_REMOVAL Uses mean removal to achieve a "sketchy" effect.
	 * @see SMOOTH Makes the image smoother. 
	 * @see IMG_FILTER_PIXELATE Applies pixelation effect to the image.
	 */
	function __construct($filterId) {
		$this->filterId = (int) $filterId;
		switch ($this->filterId) {
			case IMG_FILTER_COLORIZE:
				$this->parmcount = 4;
				break;
			case IMG_FILTER_PIXELATE:
				$this->parmcount = 2;
				break;
			case IMG_FILTER_BRIGHTNESS:
			case IMG_FILTER_CONTRAST:
			case IMG_FILTER_COLORIZE:
			case IMG_FILTER_SMOOTH:
			case IMG_FILTER_PIXELATE:
				$this->parmcount = 1;
			default:
				$this->parmcount = 0;
		}
	}

	//<editor-fold defaultstate="collapsed" desc="IMG_FILTER_BRIGHTNESS">

	function set_brightness($value) {
		$this->arg1 = (int) $value;
	}

	//</editor-fold>
	//<editor-fold defaultstate="collapsed" desc="IMG_FILTER_CONTRAST">

	function set_contrast($value) {
		$this->arg1 = (int) $value;
	}

	//</editor-fold>
	//<editor-fold defaultstate="collapsed" desc="IMG_FILTER_SMOOTH">

	function set_smoothness($value) {
		$this->arg1 = (int) $value;
	}

	//</editor-fold>
	//<editor-fold defaultstate="collapsed" desc="IMG_FILTER_PIXELATE">

	function set_blockSize($value) {
		$this->arg1 = (int) $value;
	}

	function set_advanced($value) {
		$this->arg2 = (bool) $value;
	}

	//</editor-fold>
	//<editor-fold defaultstate="collapsed" desc="IMG_FILTER_COLORIZE">
	function set_red($value) {
		$this->arg1 = (int) $value;
	}

	function set_green($value) {
		$this->arg2 = (int) $value;
	}

	function set_blue($value) {
		$this->arg3 = (int) $value;
	}

	function set_alpha($value) {
		$this->arg4 = (int) $value;
	}

	//</editor-fold>


	function applyTo(Image $image) {
		$image = $image->getHandler();
		switch ($this->parmcount) {
			case 0:
				return \imagefilter($image, $this->filterId);
			case 1:
				return \imagefilter($image, $this->filterId, $this->arg1);
			case 2:
				return \imagefilter($image, $this->filterId, $this->arg1, $this->arg2);
			case 3:
				return \imagefilter($image, $this->filterId, $this->arg1, $this->arg2, $this->arg3);
		}
		return \imagefilter($image, $this->filterId, $this->arg1, $this->arg2, $this->arg3, $this->arg4);
	}

}
