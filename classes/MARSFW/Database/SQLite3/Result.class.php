<?php

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
