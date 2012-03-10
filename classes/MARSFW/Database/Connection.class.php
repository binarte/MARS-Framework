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

namespace MARSFW\Database;
declare (encoding='UTF-8');

abstract class Connection {

	const SINGLE = 0;
	const ASSOC = 1;
	const NUM = 2;
	const BOTH = 3;
	const INFO_SAFE_IDS = 1;
	const INFO_LOCAL_IDS = 2;
	const INFO_FOREIGN_KEYS = 3;
	const INFO_TRIGGERS = 4;

	private $id;
	static private $lastId = 0;
	static private $last;

	static function create($driver, array $params, $persistent = false) {
		$driver = __NAMESPACE__ . "\\{$driver}\\Connection";

		$out = new $driver($params, $persistent);
		self::$lastId++;
		$out->id = self::$lastId;
		self::$last = $out;

		return $out;
	}

	static function getLast() {
		return self::$last;
	}

	function getId() {
		return $this->id;
	}
	
	abstract function className();

	abstract function __construct(array $params, $persistent = false);

	abstract function insert($sql, $get_key = null);

	abstract function query($sql);

	abstract function boolQuery($sql);

	abstract function exec($sql);

	abstract function escape($value, $use_quotes = true);

	abstract function getInfo($parm);
	
	abstract function listDatabases();
	
	abstract function listTables();
	
	function begin(){
		$this->query('BEGIN');
	}
	
	function commit(){
		$this->query('COMMIT');
	}
	
	function rollback(){
		$this->query('ROLLBACK');
	}
}

/**
 * This exception must be thrown when a database-related error occurs.
 */
class Exception extends \LogicException {

	/**
	 * SQL Query
	 * @var string 
	 */
	private $sql;

	function __construct(
	$sql = '', $message = "", $code = 0, \Exception $previous = NULL
	) {
		parent::__construct($message, $code, $previous);
		$this->sql = (string) $sql;
	}

	function getSql() {
		return $this->sql;
	}

}

/**
 * This exception must be thrown when the program fails to connect to the database 
 */
class ConnectionFailedException extends Exception {

}

/**
 * This exception must be thrown when the operation fails because required data is 
 * missing (typically from a foreign key)
 */
class MissingDataException extends Exception {

}

/**
 * This exception must be thrown when the operation fails due to data conflict
 */
class DataAlreadyExistsException extends Exception {

}

interface Result {
	function fetch();
	function fetchNum();
	function fetchBoth();
}
