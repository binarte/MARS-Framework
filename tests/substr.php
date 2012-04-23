<?php

$name = 'text/html';
var_dump (strpos($name,'/'));
var_dump (substr($name,0,strpos($name,'/') ).'/*');