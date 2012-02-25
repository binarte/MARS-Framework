<?php

declare(encoding = 'UTF-8');

	const _MARSFW_ = '_MARSFW_';
if (!isset ($_SERVER['REQUEST_TIME_FLOAT'])){
	$t = microtime();
	$t = explode(' ', $t);
	$_SERVER['REQUEST_TIME'] = (int) $t[1];
	$_SERVER['REQUEST_TIME_FLOAT'] = (float) $t[0]+$t[1];	
}

if (isset ($session_name) ){
	session_name($session_name);
}
else {
	session_name('MARSFW_SESSION_ID');
}
session_start();

/**
 * Carrega as classes automaticamente
 * @param string $classname Nome da classe
 * @internal
 */
function __autoload($classname) {
	MARSFW\Manager::loadClass($classname);
}

require __DIR__ . '/classes/MARSFW/Object.class.php';
require __DIR__ . '/classes/MARSFW/Manager.class.php';

if (isset ($logDeprecated)){
	MARSFW\Manager::init(__DIR__, $logDeprecated);
}
else {
	MARSFW\Manager::init(__DIR__, false);
}
