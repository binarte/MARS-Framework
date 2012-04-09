<?php


/**
 * Encodes a string with a 128-base encoding.
 * This is a non-standard encoding made for storing data that may contain characters
 * incompatible with the storage method being used (eg.: binary data in SQLite
 * databases or ini files).
 * @param string $str Data to be encoded
 * @return string Data encoded with base128
 */
function base128_encode($str){
    $length = strlen($str);
    $out = '';
    $pad = '';
    for ($i = 0; $i < $length; $i += 7){
        $bits = '';
   
        for ($j = 0; $j < 7; $j++){
            if (!isset ($str[$i+$j]) ) {
                $pad .= '=';
                continue;
            }
            $chr = $str[$i+$j];
            $chr = ord ($chr);
            $chr = decbin($chr);
            $chr = str_pad($chr,8,'0',STR_PAD_LEFT);
            $bits .= $chr;
        }
       
        for ($j = 0; $j < 56; $j += 7){
            $chr = substr($bits,$j,7);
            if ($chr === false) break;
            $chr = bindec($chr);
           
            if ($chr >= 0x40){
                $chr += 0x7F;
            }
            else {
                $chr += 0x3F;
            }
            $out .= chr($chr);
        }
    }   
    return $out.$pad;
}


/**
 * Decodes a string encoded with 128-base encoding.
 * @param string $str Data to be decoded
 * @return string Decoded data
 */
function base128_decode($str){
    $length = strlen($str);
    $out = '';
   
    for ($i = 0; $i < $length; $i += 8){
        $bits = '';
   
        for ($j = 0; $j < 8; $j++){
            if (!isset ($str[$i+$j]) ) {
                continue;
            }
            $chr = $str[$i+$j];
            if ($chr == '=') break;
            $chr = ord ($chr);
           
            if ($chr > 0x80){
                $chr -= 0x7F;
            }
            else {
                $chr -= 0x3F;
            }
           
            $chr = decbin($chr & 0x7f);
            $chr = str_pad($chr,7,'0',STR_PAD_LEFT);
            $bits .= $chr;
        }
       
        for ($j = 0; $j < 56; $j += 8){
            $chr = substr($bits,$j,8);
            if (strlen ($chr) < 8) break;
            $chr = bindec($chr);           
            $out .= chr($chr);
        }
    }   
    return $out;
}