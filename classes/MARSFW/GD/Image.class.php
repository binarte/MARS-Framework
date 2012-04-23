<?php

namespace MARSFW\GD;

class Image extends \MARSFW\WrapperObject {
	
	private function __construct($handler){
		$this->handler = $handler;
	}

	static function gdInfo() {
		return \gd_info();
	}

	static function getImageSize($filename, array &$imageinfo) {
		return \getimagesize($filename, $imageinfo);
	}

	static function getImageSizeFromstring($imagedata, array &$imageinfo) {
		return \getimagesizefromstring($imagedata, $imageinfo);
	}

	static function typeToExtension($imagetype, $include_dot = TRUE) {
		return \image_type_to_extension($imagetype, $include_dot);
	}

	static function typeToMimeType($imagetype) {
		return \image_type_to_mime_type($imagetype);
	}

	static function create($width, $height) {
		return new Image(\imagecreate($width, $height));
	}

	static function createFromGd2($filename) {
		return new Image(\imagecreatefromgd2($filename));
	}

	static function createFromGd2Part($filename, $srcX, $srcY, $width, $height) {
		return new Image(\imagecreatefromgd2part($filename, $srcX, $srcY, $width, $height));
	}

	static function createFromGd($filename) {
		return new Image(\imagecreatefromgd($filename));
	}

	static function createFromgif($filename) {
		return new Image(\imagecreatefromgif($filename));
	}

	static function createFromjpeg($filename) {
		return new Image(\imagecreatefromjpeg($filename));
	}

	/**
	 *
	 * @param type $filename
	 * @return \MARSFW\GD\Image 
	 */
	static function createFrompng($filename) {
		return new Image(\imagecreatefrompng($filename));
	}

	static function createFromstring($image) {
		return new Image(\imagecreatefromstring($image));
	}

	static function createFromwbmp($filename) {
		return new Image(\imagecreatefromwbmp($filename));
	}

	static function createFromxbm($filename) {
		return new Image(\imagecreatefromxbm($filename));
	}

	static function createFromxpm($filename) {
		return new Image(\imagecreatefromxpm($filename));
	}

	static function createTrueColor($width, $height) {
		return new Image(\imagecreatetruecolor($width, $height));
	}

	static function fontHeight($font) {
		return \imagefontheight($font);
	}

	static function fontWidth($font) {
		return \imagefontwidth($font);
	}

	static function ftBbox($size, $angle, $fontfile, $text, array $extrainfo) {
		return \imageftbbox($size, $angle, $fontfile, $text, $extrainfo);
	}

	static function grabScreen() {
		return new Image(\imagegrabscreen());
	}

	static function grabWindow($window_handle, $client_area = 0) {
		return new Image(\imagegrabwindow($window_handle, $client_area));
	}

	static function loadFont($file) {
		return \imageloadfont($file);
	}

	static function paletteCopy($destination, $source) {
		return \imagepalettecopy($destination, $source);
	}

	static function psBbox($text, $font, $size) {
		return \imagepsbbox($text, $font, $size);
	}

	static function psEncodeFont($font_index, $encodingfile) {
		return \imagepsencodefont($font_index, $encodingfile);
	}

	static function psExtendFont($font_index, $extend) {
		return \imagepsextendfont($font_index, $extend);
	}

	static function psFreeFont($font_index) {
		return \imagepsfreefont($font_index);
	}

	static function psLoadFont($filename) {
		return new Image(\imagepsloadfont($filename));
	}

	static function psSlantFont($font_index, $slant) {
		return \imagepsslantfont($font_index, $slant);
	}

	static function ttfBbox($size, $angle, $fontfile, $text) {
		return \imagettfbbox($size, $angle, $fontfile, $text);
	}

	static function types() {
		return \imagetypes();
	}

	static function iptcEmbed($iptcdata, $jpeg_file_name, $spool) {
		return \iptcembed($iptcdata, $jpeg_file_name, $spool);
	}

	static function iptcParse($iptcblock) {
		return \iptcparse($iptcblock);
	}

	static function jpegToWbmp($jpegname, $wbmpname, $dest_height, $dest_width, $threshold) {
		return \jpeg2wbmp($jpegname, $wbmpname, $dest_height, $dest_width, $threshold);
	}

	static function pngToWbmp($pngname, $wbmpname, $dest_height, $dest_width, $threshold) {
		return \png2wbmp($pngname, $wbmpname, $dest_height, $dest_width, $threshold);
	}

	function toWbmp($filename, $threshold) {
		return \image2wbmp($this->handler, $filename, $threshold);
	}

	function alphaBlending($blendmode) {
		return \imagealphablending($this->handler, $blendmode);
	}

	function antialias($enabled) {
		return \imageantialias($this->handler, $enabled);
	}

	function arc($cx, $cy, $width, $height, $start, $end, Color $c) {
		return \imagearc($this->handler, $cx, $cy, $width, $height, $start, $end, $c->toInt());
	}

	function char($font, $x, $y, $c, Color $c) {
		return \imagechar($this->handler, $font, $x, $y, $c, $c->toInt());
	}

	function charUp($font, $x, $y, $c, Color $c) {
		return \imagecharup($this->handler, $font, $x, $y, $c, $c->toInt());
	}

	function colorAllocate($red, $green, $blue) {
		return \imagecolorallocate($this->handler, $red, $green, $blue);
	}

	function colorAllocateAlpha($red, $green, $blue, $alpha) {
		return \imagecolorallocatealpha($this->handler, $red, $green, $blue, $alpha);
	}

	function colorAt($x, $y) {
		return \imagecolorat($this->handler, $x, $y);
	}

	function colorClosest($red, $green, $blue) {
		return \imagecolorclosest($this->handler, $red, $green, $blue);
	}

	function colorClosestAlpha($red, $green, $blue, $alpha) {
		return \imagecolorclosestalpha($this->handler, $red, $green, $blue, $alpha);
	}

	function colorClosestHwb($red, $green, $blue) {
		return \imagecolorclosesthwb($this->handler, $red, $green, $blue);
	}

	function colorDeallocate(Color $c) {
		return \imagecolordeallocate($this->handler, $c->toInt());
	}

	function colorExact($red, $green, $blue) {
		return \imagecolorexact($this->handler, $red, $green, $blue);
	}

	function colorExactAlpha($red, $green, $blue, $alpha) {
		return \imagecolorexactalpha($this->handler, $red, $green, $blue, $alpha);
	}

	function colorMatch(Image $image) {
		return \imagecolormatch($this->handler, $image->handler);
	}

	function colorResolve($red, $green, $blue) {
		return \imagecolorresolve($this->handler, $red, $green, $blue);
	}

	function colorResolveAlpha($red, $green, $blue, $alpha) {
		return \imagecolorresolvealpha($this->handler, $red, $green, $blue, $alpha);
	}

	function colorSet($index, $red, $green, $blue, $alpha = 0) {
		return \imagecolorset($this->handler, $index, $red, $green, $blue, $alpha);
	}

	function colorsForIndex($index) {
		return \imagecolorsforindex($this->handler, $index);
	}

	function colorsTotal() {
		return \imagecolorstotal($this->handler);
	}

	function colorTransparent(Color $c) {
		return \imagecolortransparent($this->handler, $c->toInt());
	}

	function convolution(array $matrix, $div, $offset) {
		return \imageconvolution($this->handler, $matrix, $div, $offset);
	}

	function copy(Image $source, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h) {
		return \imagecopy($this->handler, $source->handler, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h);
	}

	function copyMerge(Image $source, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct) {
		return \imagecopymerge($this->handler, $source->handler, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct);
	}

	function copyMergeGray(Image $source, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct) {
		return \imagecopymergegray($this->handler, $source->handler, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct);
	}

	function copyResampled(Image $source, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h) {
		return \imagecopyresampled($this->handler, $source->handler, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
	}

	function copyResized(Image $source, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h) {
		return \imagecopyresized($this->handler, $source->handler, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
	}

	function dashedLine($x1, $y1, $x2, $y2, Color $c) {
		return \imagedashedline($this->handler, $x1, $y1, $x2, $y2, $c->toInt());
	}

	function destroy() {
		return \imagedestroy($this->handler);
	}

	function ellipse($cx, $cy, $width, $height, Color $c) {
		return \imageellipse($this->handler, $cx, $cy, $width, $height, $c->toInt());
	}

	function fill($x, $y, Color $c) {
		return \imagefill($this->handler, $x, $y, $c->toInt());
	}

	function filledArc($cx, $cy, $width, $height, $start, $end, Color $c, $style) {
		return \imagefilledarc($this->handler, $cx, $cy, $width, $height, $start, $end, $c->toInt(), $style);
	}

	function filledEllipse($cx, $cy, $width, $height, Color $c) {
		return \imagefilledellipse($this->handler, $cx, $cy, $width, $height, $c->toInt());
	}

	function filledPolygon(array $points, $num_points, Color $c) {
		return \imagefilledpolygon($this->handler, $points, $num_points, $c->toInt());
	}

	function filledRectangle($x1, $y1, $x2, $y2, Color $c) {
		return \imagefilledrectangle($this->handler, $x1, $y1, $x2, $y2, $c->toInt());
	}

	function fillToBorder($x, $y, $border, Color $c) {
		return \imagefilltoborder($this->handler, $x, $y, $border, $c->toInt());
	}

	function filter($filtertype, $arg1 = null, $arg2 = null, $arg3 = null, $arg4 = null) {
		switch (func_num_args()){
			case 1:
				return \imagefilter($this->handler, $filtertype);
			case 2:
				return \imagefilter($this->handler, $filtertype, $arg1);
			case 3:
				return \imagefilter($this->handler, $filtertype, $arg1, $arg2);
			case 4:
				return \imagefilter($this->handler, $filtertype, $arg1, $arg2, $arg3);
		}
		return \imagefilter($this->handler, $filtertype, $arg1, $arg2, $arg3, $arg4);
	}

	function ftText($size, $angle, $x, $y, Color $c, $fontfile, $text, array $extrainfo) {
		return \imagefttext($this->handler, $size, $angle, $x, $y, $c->toInt(), $fontfile, $text, $extrainfo);
	}

	function gammaCorrect($inputgamma, $outputgamma) {
		return \imagegammacorrect($this->handler, $inputgamma, $outputgamma);
	}

	function gd2($filename, $chunk_size, $type = IMG_GD2_RAW) {
		return \imagegd2($this->handler, $filename, $chunk_size, $type);
	}

	function gd($filename) {
		return \imagegd($this->handler, $filename);
	}

	function gif($filename) {
		return \imagegif($this->handler, $filename);
	}

	function interlace($interlace = 0) {
		return \imageinterlace($this->handler, $interlace);
	}

	function isTrueColor() {
		return \imageistruecolor($this->handler);
	}

	function jpeg($filename, $quality) {
		return \imagejpeg($this->handler, $filename, $quality);
	}

	function layerEffect($effect) {
		return \imagelayereffect($this->handler, $effect);
	}

	function line($x1, $y1, $x2, $y2, Color $c) {
		return \imageline($this->handler, $x1, $y1, $x2, $y2, $c->toInt());
	}

	function png($filename, $quality, $filters) {
		return \imagepng($this->handler, $filename, $quality, $filters);
	}

	function polygon(array $points, $num_points, Color $c) {
		return \imagepolygon($this->handler, $points, $num_points, $c->toInt());
	}

	function psText($text, $font_index, $size, $foreground, $background, $x, $y, $space = 0, $tightness = 0, $angle = 0.0, $antialias_steps = 4) {
		return \imagepstext($this->handler, $text, $font_index, $size, $foreground, $background, $x, $y, $space, $tightness, $angle, $antialias_steps);
	}

	function rectangle($x1, $y1, $x2, $y2, Color $c) {
		return \imagerectangle($this->handler, $x1, $y1, $x2, $y2, $c->toInt());
	}

	function rotate($angle, $bgd_color, $ignore_transparent = 0) {
		return new Image(\imagerotate($this->handler, $angle, $bgd_color, $ignore_transparent));
	}

	function saveAlpha($saveflag) {
		return \imagesavealpha($this->handler, $saveflag);
	}

	function setBrush(Image $brush) {
		return \imagesetbrush($this->handler, $source->handler);
	}

	function setpixel($x, $y, Color $c) {
		return \imagesetpixel($this->handler, $x, $y, $c->toInt());
	}

	function setStyle(array $style) {
		return \imagesetstyle($this->handler, $style);
	}

	function setThickness($thickness) {
		return \imagesetthickness($this->handler, $thickness);
	}

	function setTile($tile) {
		return \imagesettile($this->handler, $tile);
	}

	function string($font, $x, $y, $string, Color $c) {
		return \imagestring($this->handler, $font, $x, $y, $string, $c->toInt());
	}

	function stringUp($font, $x, $y, $string, Color $c) {
		return \imagestringup($this->handler, $font, $x, $y, $string, $c->toInt());
	}

	function sx() {
		return \imagesx($this->handler);
	}

	function sy() {
		return \imagesy($this->handler);
	}

	function trueColorTopalette($dither, $ncolors) {
		return \imagetruecolortopalette($this->handler, $dither, $ncolors);
	}

	function ttfText($size, $angle, $x, $y, Color $c, $fontfile, $text) {
		return \imagettftext($this->handler, $size, $angle, $x, $y, $c->toInt(), $fontfile, $text);
	}

	function wbmp($filename, $foreground) {
		return \imagewbmp($this->handler, $filename, $foreground);
	}

	function xbm($filename, $foreground) {
		return \imagexbm($this->handler, $filename, $foreground);
	}

}