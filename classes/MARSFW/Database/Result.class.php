<?php

namespace MailMan\Database;

interface Result {
	function fetch();
	function fetchNum();
	function fetchBoth();
}
