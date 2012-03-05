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

namespace MailMan\Database\SQLite3;

class Connection extends \MailMan\Database\Connection {
	/** Successful result */
	const OK         = 0;
	/** SQL error or missing database */
	const ERROR      = 1;
	/** Internal logic error in SQLite */
	const INTERNAL   = 2;
	/** Access permission denied */
	const PERM       = 3;
	/** Callback routine requested an abort */
	const ABORT      = 4;
	/** The database file is locked */
	const BUSY       = 5;
	/** A table in the database is locked */
	const LOCKED     = 6;
	/** A malloc() failed */
	const NOMEM      = 7;
	/** Attempt to write a readonly database */
	const READONLY   = 8;
	/** Operation terminated by sqlite3_interrupt()*/
	const INTERRUPT  = 9;
	/** Some kind of disk I/O error occurred */
	const IOERR      =10;
	/** The database disk image is malformed */
	const CORRUPT    =11;
	/** Unknown opcode in sqlite3_file_control() */
	const NOTFOUND   =12;
	/** Insertion failed because database is full */
	const FULL       =13;
	/** Unable to open the database file */
	const CANTOPEN   =14;
	/** Database lock protocol error */
	const PROTOCOL   =15;
	/** Database is empty */
	const EMPTYDB    =16;
	/** The database schema changed */
	const SCHEMA     =17;
	/** String or BLOB exceeds size limit */
	const TOOBIG     =18;
	/** Abort due to constraint violation */
	const CONSTRAINT =19;
	/** Data type mismatch */
	const MISMATCH   =20;
	/** Library used incorrectly */
	const MISUSE     =21;
	/** Uses OS features not supported on host */
	const NOLFS      =22;
	/** Authorization denied */
	const AUTH       =23;
	/** Auxiliary database format error */
	const FORMAT     =24;
	/** 2nd parameter to sqlite3_bind out of range */
	const RANGE      =25;
	/** File opened that is not a database file */
	const NOTADB     =26;
	/** sqlite3_step() has another row ready */
	const ROW        =100;
	/** sqlite3_step() has finished executing */
	const DONE       =101;

	private $handler;

	function __construct(array $params,$persistent = false){
		$params += array ('flags' => SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
		
		if (isset ($params['encryption_key']) ){
			$this->handler = new \SQLite3 (
				$params['filename'],$params['flags'],$params['encryption_key']
			);
		}
		else {
			$this->handler = new \SQLite3 (
				$params['filename'],$params['flags']
			);
		}
		
		if (isset ($params['busy_timeout']) ){
			$this->handler->busyTimeout($params['busy_timeout']);
		}
	}

	function exec($sql){
		try {
			$this->handler->exec($sql);	
		}
		catch (\ErrorException $ex) {
			throw new \MailMan\Database\Exception(
				$sql,$this->handler->lastErrorMsg(),$this->handler->lastErrorCode()
			);
		}
		return $this->handler->changes();
	}

	function insert($sql,$key){
		try {
			$this->handler->exec($sql);	
		}
		catch (\ErrorException $ex) {
			throw new \MailMan\Database\Exception(
				$sql,$this->handler->lastErrorMsg(),$this->handler->lastErrorCode()
			);
		}
		return $this->handler->lastInsertRowID();
	}
	
	function query($sql){
		try {
			return new Result($this->handler->query($sql) );
		}
		catch (\ErrorException $ex) {
			throw new \MailMan\Database\Exception(
				$sql,$this->handler->lastErrorMsg(),$this->handler->lastErrorCode()
			);
		}
	}
	
	function boolQuery($sql){
		try {
			$res = $this->handler->query($sql);
		}
		catch (\ErrorException $ex) {
			throw new \MailMan\Database\Exception(
				$sql,$this->handler->lastErrorMsg(),$this->handler->lastErrorCode()
			);
		}
		return (bool) $res->fetchArray(SQLITE3_NUM);
	}
	
	function escape($value,$use_quotes = true){
		if (is_null($value) ) {
			return 'NULL';
		}
		if (is_bool($value) ) {
			return $value ? '1' : '0';
		}
		if (is_numeric($value) ) {
			return (string) $value;
		}
		
		if ($value instanceof \DateTime){
			$value = gmdate('Y-m-d H:i:s',$value->getTimestamp() );
		}
		else {
			$value = $this->handler->escapeString($value);
		}
		if ($use_quotes) return "'$value'";
		return $value;				
	}
	
	function getInfo($parm){
		switch ($parm){
			case self::INFO_SAFE_IDS: return false;
			case self::INFO_LOCAL_IDS: return true;
			case self::INFO_FOREIGN_KEYS: return false;
			case self::INFO_TRIGGERS: return true;
		}
		return false;
	}
}
