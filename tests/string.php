<?php

namespace MARSFW;

header('content-type: text/plain; charset=UTF-8');

require '../start.inc.php';

$str = new String('the quick brown fox jumped over the lazy dog');
$str->caseSensitive = false;

//var_dump ($str['quick']); //4
//var_dump ($str['slow']); //false

try {
	$str['QUICK'] = 'fast';


	var_dump($str);
} catch (\Exception $ex) {
	var_dump($ex);
}

/**
 =?iso-8859-1?Q?Camilla_Ara=FAjo?= <bibillaraujo@hotmail.com>,
  =?iso-8859-1?Q?V=E2nia_Maia?= <gmaia.adm@hotmail.com>,
  =?iso-8859-1?Q?Fl=E1via_maia?= <pedatellamaia@hotmail.com>,
  =?iso-8859-1?Q?jo=E3o=2Erosa=40hotmail=2Ecom=2Ebr?= <jo??o.rosa@hotmail.com.br
 *//*
$str = String::decodeAscii('=?iso-8859-1?Q?V=E2nia_Maia?=');
var_dump ( ''.$str,$str->toAscii() );*/

var_dump(Imap::binary('Aaimeu pé'));