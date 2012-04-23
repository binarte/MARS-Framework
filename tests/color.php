<?php
namespace MARSFW;
require '../start.inc.php';

$c = Color::createFromCss('#abc');
var_dump ($c);
$c = Color::createFromCss('#abcabc');
var_dump ($c);
$c = Color::createFromCss('rgba(1,2,3)');
var_dump ($c);
$c = Color::createFromCss('rgb(1,2,3)');
var_dump ($c);
$c = Color::createFromCss('rgba(1,2,3,0.1)');
var_dump ($c);
$c = Color::createFromCss('red');
var_dump ($c);
