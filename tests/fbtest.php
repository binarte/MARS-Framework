<?php

namespace MARSFW;

require '../start.inc.php';

$data = parse_ini_file('apps.ini',true);
var_dump ($data);
extract($data['facebook']);
$fb = new Connectivity\Facebook($appId, $appSecret);
$bstr = base128_encode($str);
var_dump ($bstr,$str);

/*
$str = base64_decode($str, $strict = false, $alphabet = BASE64_URLSAFE);
var_dump ($str);*/