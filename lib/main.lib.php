<?php

namespace MARSFW;

const BASE64_DEFAULT = 1;
const BASE64_URLSAFE = 2;
const BASE64_DEFAULT_ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789+/=';
const BASE64_URLSAFE_ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789-_';

/**
 * Encodes a string using the BASE64 encoding.
 * @param string $str String to be encoded
 * @param mixed $alphabet Alphabet used to encode the string. It can be BASE64_DEFAULT, 
 * BASE64_URLSAFE or a custom asphabet passed as a string. If the alphabet contains 64 
 * characters, it will output the encoded strings without padding, if it contains 65, the 
 * 65th character will be used as padding.
 * @param bool $pad If <b>TRUE</b>, will pad the output, <b>FALSE</b> if otherwise. Will 
 * use the alphabet's default if not specified.
 * @return string 
 */
function base64_encode($str, $alphabet = BASE64_DEFAULT, $pad = null) {
	$str = \base64_encode($str);
	if (\is_string($alphabet)) {
		if (empty($alphabet[64])) {
			$str = \rtrim($str, '=');
		}
		$str = \strtr($str, BASE64_DEFAULT_ALPHABET, $alphabet);
	} else {
		switch ($alphabet) {
			case BASE64_URLSAFE:
				$str = \strtr($str, '+/', '-_');
				if (is_null($pad)) {
					$pad = false;
				}
				break;
			default:
				if (is_null($pad)) {
					$pad = true;
				}
		}

		if (!$pad) {
			$str = \rtrim($str, '=');
		}
	}
	return $str;
}

/**
 *
 * @param type $str
 * @param type $alphabet
 * @return type 
 */
function base64_decode($str, $strict, $alphabet = BASE64_DEFAULT) {
	if (\is_string($alphabet)) {
		if (empty($alphabet[64])) {
			$str = \rtrim($str, '=');
		}
		$str = \strtr($str, $alphabet, BASE64_DEFAULT_ALPHABET);
	} else {
		switch ($alphabet) {
			case BASE64_URLSAFE:
				$str = \strtr($str, '-_', '+/');
				break;
		}
	}

	return \base64_decode($str, $strict);
}

function base128_encode($str) {
	$str = (string) $str;
	$out = '';
	$length = strlen($str);
	$pad = 0;
	for ($i = 0; $i < $length; $i+=7) {
		$intv = 0;
		for ($c = 0; $c < 7; $c++) {
			$intv <<= 8;
			if (isset($str[$i + $c])) {
				$intv |= ord($str[$i + $c]);
			}
			else $pad++;
		}
		$part = '';
		for ($c = 0; $c < 8; $c++) {
			$ord = $intv & 0x7f;
			$intv >>= 7;
			if ($ord >= 0x40) {
				$ord += 0x7f;
			} else {
				$ord += 0x3f;
			}

			$part = chr($ord) . $part;
		}
		$out .= $part;
	}
	$length = strlen($out);
	for ($i = 1; $i <= $pad; $i++){
		$out[$length - $i] = '=';
	}
	return $out;
}

function base128_decode($str) {
	$str = (string) $str;
	$out = '';
	$length = strlen($str);
	$pad = 0;
	for ($i = 0; $i < $length; $i+=7) {
		$intv = 0;
		for ($c = 0; $c < 8; $c++) {
			$intv <<= 7;
			if (isset($str[$i + $c]) and $str[$i + $c] != '~') {
				$chr = ord($str[$i + $c]);
				if ($chr > 0x80){
					$chr -= 0x7f;
				}
				else {
					$chr -= 0x3f;
				}
				
				$intv |= $chr;
			}
			else $pad++;
		}
		$part = '';
		for ($c = 0; $c < 7; $c++) {
			$ord = $intv & 0xff;
			$intv >>= 8;

			$part = chr($ord) . $part;
		}
		$out .= $part;
	}
	$length = strlen($out);
	return substr($out,$length - $pad);
}
