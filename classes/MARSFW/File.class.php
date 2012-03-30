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

namespace MARS;

/**
 * @todo MEDIUM PRIORITY: make this a wrapperobject and finish documentation 
 */
class File extends Object{

	private $handler;

	/**
	 * Opens file or URL
	 * @param string $filename Name of the file to open
	 * @param string $mode The mode parameter specifies the type of access you require to 
	 * the stream. See {@link fopen()} for a list of available modes
	 * @param bool $use_include_path The optional third parameter can be set to '1' or 
	 * <b>TRUE</b> if you want to search for the file in the include_path, too. 
	 * @param type $context Context where the file will be opened
	 * @uses \fopen()
	 */
	function __construct($filename, $mode = 'r', $use_include_path = false, $context = null) {
		if (func_num_args() > 3) {
			$file = \fopen($filename, $mode, $use_include_path, $context);
		} else {
			$file = \fopen($filename, $mode, $use_include_path);
		}
		$this->handler = $file;
	}

	/**
	 * Cleans the memory from the object.
	 * @uses \fclose()
	 */
	function __destruct() {
		\fclose($this->handler);
	}

	/**
	 * Tests for end-of-file on a file pointer.
	 * @return bool Returns <b>TRUE</b> if the file pointer is at EOF or an error occurs; 
	 * otherwise returns <b>FALSE</b>. 
	 * @uses \feof()
	 */
	function eof() {
		return \feof($this->handler);
	}

	/**
	 * Flushes the output to a file.
	 * This function forces a write of all buffered output to the resource pointed to by 
	 * the object. 
	 * @return bool Returns <b>TRUE</b> on success or <b>FALSE</b> on failure.  
	 * @uses \fflush()
	 */
	function flush() {
		return fflush($this->handler);
	}

	/**
	 * Gets character from file. 
	 * @return string Returns a string containing a single character read from the file 
	 * pointed to by handle. Returns <b>FALSE</b> on EOF.  
	 * @uses \fgetc()
	 */
	function getChar() {
		return fgetc($this->handler);
	}

	/**
	 * Gets line from file pointer and parse for CSV fields.
	 * Similar to {@link getLine()} except that fgetcsv() parses the line it reads for 
	 * fields in CSV format and returns an array containing the fields read. 
	 * @param int $length     Must be greater than the longest line (in characters) to be 
	 * found in the CSV file (allowing for trailing line-end characters). Setting it to 0 
	 * the maximum line length is not limited, which is slightly slower. 
	 * @param type $delimiter Set the field delimiter (one character only). 
	 * @param type $enclosure Set the field enclosure character (one character only). 
	 * @param type $escape    Set the escape character (one character only). Defaults as 
	 * a backslash. 
	 * @return array  Returns an indexed array containing the fields read. Returns NULL 
	 * if an invalid handle is supplied or FALSE on other errors, including end of file
	 * @uses \fgetcsv()
	 */
	function getCSV($length = 1024, $delimiter = ',', $enclosure = '"', $escape = '\\') {
		return \fgetcsv($this->handler, $length, $delimiter, $enclosure, $escape);
	}

	/**
	 * Gets line from file.
	 * @param int $length Reading ends when length - 1 bytes have been read, on a newline 
	 * (which is included in the return value), or on EOF (whichever comes first). If 0 
	 * is specified, it will keep reading from the stream until it reaches the end of the 
	 * line. 
	 * @return string Returns a string of up to <i>$length</i> - 1 bytes read from the 
	 * file pointed to by handle. If there is no more data to read in the file pointer, 
	 * then FALSE is returned.
	 * 
	 * If an error occurs, FALSE is returned.  
	 * @uses \fgets()
	 */
	function getLine($length = 1024) {
		if ($length) {
			return \fgets($this->handler, $length);
		}
		return \fgets($this->handler);
	}

	/**
	 * Gets line from file pointer and strip HTML tags.
	 * Identical to {@link getLine()}, except that fgetss() attempts to strip any NUL 
	 * bytes, HTML and PHP tags from the text it reads. 
	 * @param int $length Length of the data to be retrieved. 
	 * @param string $allowable_tags You can use the optional third parameter to specify 
	 * tags which should not be stripped. 
	 * @return string Returns a string of up to length - 1 bytes read from the file 
	 * pointed to by handle, with all HTML and PHP code stripped.
	 * 
	 * If an error occurs, returns FALSE. 
	 * @uses \fgetss()
	 */
	function getHTMLLine($length = 1024, $allowable_tags = '') {
		return fgetss($this->handler, $length, $allowable_tags);
	}

	/**
	 * Portable advisory file locking.
	 * Allows you to perform a simple reader/writer model which can be used on virtually 
	 * every platform (including most Unix derivatives and even Windows).
	 * 
	 * On versions of PHP before 5.3.2, the lock is released also by fclose() (which is 
	 * also called automatically when script finished).
	 * 
	 * PHP supports a portable way of locking complete files in an advisory way (which 
	 * means all accessing programs have to use the same way of locking or it will not 
	 * work). By default, this function will block until the requested lock is acquired;
	 * this may be controlled (on non-Windows platforms) with the LOCK_NB option 
	 * documented below. 
	 * @param int $operation operation is one of the following:
	 * 
	 * - LOCK_SH to acquire a shared lock (reader).
	 * - LOCK_EX to acquire an exclusive lock (writer).
	 * - LOCK_UN to release a lock (shared or exclusive).
	 * 
	 * It is also possible to add LOCK_NB as a bitmask to one of the above operations if 
	 * you don't want to block while locking. (not supported on Windows)
	 * @param int &$wouldblock The optional third argument is set to <b>TRUE</b> if the 
	 * lock would block (EWOULDBLOCK errno condition). (not supported on Windows) 
	 * @return bool Returns <b>TRUE</b> on success or <b>FALSE</b> on failure.  
	 * @uses \flock()
	 */
	function lock($operation, &$wouldblock = null) {
		return flock($this->handler, $operation, $wouldblock);
	}

	/**
	 * Output all remaining data on a file pointer.
	 * Reads to EOF on the given file pointer from the current position and writes the 
	 * results to the output buffer.
	 * 
	 * You may need to call {@link rewind()} to reset the file pointer to the beginning 
	 * of the file if you have already written data to the file.
	 * 
	 * If you just want to dump the contents of a file to the output buffer, without 
	 * first modifying it or seeking to a particular offset, you may want to use the 
	 * {@link readfile()}, which saves you the file open call. 
	 * @return int if an error occurs, returns <b>FALSE</b>. Otherwise, returns the 
	 * number of characters read from handle and passed through to the output.  
	 * @uses \fpassthru()
	 */
	function passthru() {
		return fpassthru($this->handler);
	}

	/**
	 * Format line as CSV and write to file pointer.
	 * Formats a line (passed as a <i>$fields</i> array) as CSV and write it (terminated 
	 * by a newline) to the object. 
	 * @param array $fields An array of values. 
	 * @param string $delimiter The optional <i>$delimiter</i> parameter sets the field 
	 * delimiter (one character only). 
	 * @param string $enclosure The optional <i>$enclosure</i> parameter sets the field 
	 * enclosure (one character only). 
	 * @return int Returns the length of the written string or <b>FALSE</b> on failure.     
	 * @uses \fputcsv()
	 */
	function putCSV(array $fields, $delimiter = ',', $enclosure = '"') {
		return fputcsv($this->handler, $fields, $delimiter, $enclosure);
	}

	/**
	 * Binary-safe file read.
	 * fread() reads up to length bytes from the file pointer referenced by handle. 
	 * Reading stops as soon as one of the following conditions is met:
	 * 
	 * - length bytes have been read
	 * - EOF (end of file) is reached
	 * - a packet becomes available or the socket timeout occurs (for network streams)
	 * - if the stream is read buffered and it does not represent a plain file, at most 
	 * one read of up to a number of bytes equal to the chunk size (usually 8192) is 
	 * made; depending on the previously buffered data, the size of the returned data may 
	 * be larger than the chunk size.
	 * @param int $length Up to <i>$length</i> number of bytes read. 
	 * @return string Returns the read string or <b>FALSE</b> on failure.  
	 * @uses \fread()
	 */
	function read($length = 1024) {
		return fread($this->handler, $length);
	}

	/**
	 * Parses input from a file according to a format.
	 * The method scanf() is similar to {@link sscanf()}, but it takes its input from a 
	 * file associated with handle and interprets the input according to the specified
	 * format, which is described in the documentation for {@link sprintf()}.
	 * 
	 * Any whitespace in the format string matches any whitespace in the input stream. 
	 * This means that even a tab (\t) in the format string can match a single space 
	 * character in the input stream.
	 * 
	 * Each call to scanf() reads one line from the file. 
	 * @param string $format See {@link \sprintf()} for a description of format. 
	 * @return mixed If only two parameters were passed to this function, the values 
	 * parsed will be returned as an array. Otherwise, if optional parameters are passed, 
	 * the function will return the number of assigned values. The optional parameters 
	 * must be passed by reference.   
	 * @uses fscanf()  
	 * @see sscanf()
	 */
	function scanf($format) {
		$pnum = func_num_args();
		if ($pnum == 1) {
			return \fscanf($this->handler, $format);
		}
		$args = func_get_args();
		switch ($pnum) {
			case 2: return \fscanf(
					$this->handler, $format, $args[1]
				);
			case 3: return \fscanf(
					$this->handler, $format, $args[1], $args[2]
				);
			case 4: return \fscanf(
					$this->handler, $format, $args[1], $args[2], $args[3]
				);
			case 5: return \fscanf(
					$this->handler, $format, $args[1], $args[2], $args[3], $args[4]
				);
			case 6: return \fscanf(
					$this->handler, $format, $args[1], $args[2], $args[3], $args[4], $args[5]
				);
			case 7: return \fscanf(
					$this->handler, $format, $args[1], $args[2], $args[3], $args[4], $args[5], $args[6]
				);
			case 8: return \fscanf(
					$this->handler, $format, $args[1], $args[2], $args[3], $args[4], $args[5], $args[6], $args[7]
				);
		}
		$str = '';
		for ($x = 0; $x < $pnum; $x++) {
			$str .= ',$args[' . $x . ']';
		}
		eval('$v=fscanf($this->handler,$format' . $str . ');');
		return $v;
	}

	/**
	 * Write a formatted string to a stream.
	 * Write a string produced according to <i>$format</i> to the stream resource 
	 * specified by the object. 
	 * @param string $format See {@link sprintf()} for a description of format. 
	 * @return int Returns the length of the string written. 
	 * @uses \fprintf()
	 * @see  \sprintf()
	 */
	function printf($format) {
		$pnum = func_num_args();
		if ($pnum == 1)
			return fprintf($this->handler, $format);
		$args = func_get_args();
		switch ($pnum) {
			case 2: return fprintf($this->handler, $format, $args[1]
				);
			case 3: return fprintf($this->handler, $format, $args[1], $args[2]
				);
			case 4: return fprintf($this->handler, $format, $args[1], $args[2], $args[3]
				);
			case 5: return fprintf($this->handler, $format, $args[1], $args[2], $args[3], $args[4]
				);
			case 6: return fprintf($this->handler, $format, $args[1], $args[2], $args[3], $args[4], $args[5]
				);
			case 7: return fprintf($this->handler, $format, $args[1], $args[2], $args[3], $args[4], $args[5], $args[6]
				);
			case 8: return fprintf($this->handler, $format, $args[1], $args[2], $args[3], $args[4], $args[5], $args[6], $args[7]
				);
		}
		$str = '';
		for ($x = 0; $x < $pnum; $x++) {
			$str .= ',$args[' . $x . ']';
		}
		eval('$v=fprintf($this->handler,$format' . $str . ');');
		return $v;
	}

	/**
	 * Seeks on a file pointer.
	 * Sets the file position indicator for the file referenced by the object. The new 
	 * position, measured in bytes from the beginning of the file, is obtained by adding 
	 * <i>$offset</i> to the position specified by <i>$whence</i>.
	 * 
	 * In general, it is allowed to seek past the end-of-file; if data is then written, 
	 * reads in any unwritten region between the end-of-file and the sought position will 
	 * yield bytes with value 0. However, certain streams may not support this behavior,
	 * especially when they have an underlying fixed size storage. 
	 * @param int $offset The offset.
	 * 
	 * To move to a position before the end-of-file, you need to pass a negative value in
	 * <i>$offset</i> and set whence to SEEK_END. 
	 * @param int $whence whence values are:
	 * 
	 * - SEEK_SET - Set position equal to offset bytes.
	 * - SEEK_CUR - Set position to current location plus offset.
	 * - SEEK_END - Set position to end-of-file plus offset.
	 * @return int Upon success, returns 0; otherwise, returns -1.  
	 */
	function seek($offset, $whence = SEEK_SET) {
		return fseek($this->handler, $offset, $whence);
	}

	/**
	 * Gets information about a file using an open file pointer.
	 * Gathers the statistics of the file opened by the object's file pointer handle. 
	 * This function is similar to the stat() function except that it operates on an open 
	 * file pointer instead of a filename. 
	 * @return array Returns an array with the statistics of the file; the format of the 
	 * array is described in detail on the stat() manual page.  
	 * @uses \fstat()
	 * @see \stat()
	 */
	function stat() {
		return fstat($this->handler);
	}

	/**
	 * Returns the current position of the file read/write pointer. 
	 * @return int Returns the position of the file pointer referenced by handle as an 
	 * integer; i.e., its offset into the file stream.
	 * 
	 * If an error occurs, returns <b>FALSE</b>.  
	 * @uses \ftell()
	 */
	function tell() {
		return ftell($this->handler);
	}

	/**
	 * Rewind the position of the file pointer.
	 * Sets the file position indicator for the object to the beginning of the file 
	 * stream.
	 * @return bool Returns <b>TRUE</b> on success or <b>FALSE</b> on failure. 
	 * @uses \rewind()
	 */
	function rewind() {
		return rewind($this->handler);
	}

	/**
	 * Truncates a file to a given length.
	 * Takes the filepointer on the object, and truncates the file to length, 
	 * <i>$size</i>. 
	 * @param int $size
	 * @return bool Returns <b>TRUE</b> on success or <b>FALSE</b> on failure. 
	 * @uses \ftruncate()
	 */
	function truncate($size) {
		return ftruncate($this->handler, $size);
	}

	/**
	 * Binary-safe file write.
	 * Writes the contents of string to the file stream pointed to by the object.  
	 * @param string $string The string that is to be written. 
	 * @param int    $length If the length argument is given, writing will stop after 
	 * length bytes have been written or the end of string is reached, whichever comes 
	 * first.
	 * @return int the number of bytes written, or <b>FALSE</b> on error.  
	 * @uses \fwrite()
	 */
	function write($string, $length = null) {
		return fwrite($this->handler, $string, $length);
	}

}
