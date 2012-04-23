<?php
namespace MARSFW\GD;
require '../start.inc.php';

$f = new Filter(Filter::BRIGHTNESS);
$f->brightness = 20;
$f = new Filter(Filter::MEAN_REMOVAL);
$im = Image::createFrompng('/home/vanduir/Área de trabalho/unmarked action.png');
$im->filter(Filter::PIXELATE,3,0);
header ('Content-Type: image/png');
$png = $im->png(null, null, null);