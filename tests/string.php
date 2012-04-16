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


var_dump ($str);
}
catch(\Exception $ex){
	var_dump ($ex);
}