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

class Result implements \MailMan\Database\Result {
	private $handler;
	
	function __construct(\SQLite3Result	$h){
		$this->handler = $h;
	}
	
	function __destruct(){
		$this->handler->finalize();
	}
	
	function fetch(){
		return $this->handler->fetchArray(SQLITE3_ASSOC);
	}
	function fetchNum(){
		return $this->handler->fetchArray(SQLITE3_NUM);
	}
	function fetchBoth(){
		return $this->handler->fetchArray(SQLITE3_BOTH);
	}
}
