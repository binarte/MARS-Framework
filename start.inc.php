<?php
/*
 * Copyright (C) 2012 Vanduir Volpato Maia
 * 
 * This library is free software; you can redistribute it and/or modify it under the 
 * terms of the GNU Lesser General Public License as published by the Free Software 
 * Foundation; either version 2.1 of the License, or (at your option) any later version.
 * 
 * This library is distributed in the hope that it will be useful, but WITHOUT ANY 
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A 
 * PARTICULAR PURPOSE.  See the GNU Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public License along with 
 * this library; if not, write to the Free Software Foundation, Inc., 51 Franklin Street, 
 * Fifth Floor, Boston, MA  02110-1301  USA
 */

const _MARSFW_ = '_MARSFW_';
if (!isset ($_SERVER['REQUEST_TIME_FLOAT'])){
	$t = microtime();
	$t = explode(' ', $t);
	$_SERVER['REQUEST_TIME'] = (int) $t[1];
	$_SERVER['REQUEST_TIME_FLOAT'] = (float) $t[0]+$t[1];		
}

if (isset ($default_timezone) ){
	date_default_timezone_set($default_timezone);
}
elseif (!ini_get('date.timezone') ){
	date_default_timezone_set('UTC');
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

require __DIR__ . '/lib/main.lib.php';
require __DIR__ . '/classes/MARSFW/Object.class.php';
require __DIR__ . '/classes/MARSFW/Manager.class.php';

if (isset ($logDeprecated)){
	MARSFW\Manager::init(__DIR__, $logDeprecated);
}
else {
	MARSFW\Manager::init(__DIR__, false);
}
