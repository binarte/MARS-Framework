<?php


/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace MARSFW\Database;
declare (encoding='UTF-8');


/**
 * Description of TableSchema
 *
 * @author vanduir
 */
class TableSchema extends \MARSFW\Object {

	const TYPES_INT = 0x100;
	const TYPES_NUMBER = 0x200;
	const TYPES_VARIABLE = 0x300;
	const TYPES_FIXED = 0x400;
	const TYPES_DATETIME = 0x500;
	const TYPES_GEOMETRIC = 0x600;

	//Signed integers
	/**
	 * Signed 8-bit integer.
	 */
	const T_INT8 = 0x11;
	/**
	 * Signed 16-bit integer.
	 */
	const T_INT16 = 0x12;
	/**
	 * Signed 24-bit integer.
	 */
	const T_INT24 = 0x13;
	/**
	 * Signed 32-bit integer.
	 */
	const T_INT32 = 0x14;
	/**
	 * Signed 64-bit integer.
	 * Note: PHP will not recognize 64-bit integers in 32-bit installs. When running a
	 * 32-bit version, 64-bit integers should be output as strings.
	 */
	const T_INT64 = 0x15;

	//Unsigned integers
	/**
	 * Unsigned 8-bit integer.
	 */
	const T_UINT8 = 0x19;
	/**
	 * Unsigned 16-bit integer.
	 */
	const T_UINT16 = 0x1A;
	/**
	 * Unsigned 24-bit integer.
	 */
	const T_UINT24 = 0x1B;
	/**
	 * Unsigned 32-bit integer.
	 * Note: PHP will not recognize 32-bit unsigned integers in 32-bit installs. When
	 * running a 32-bit version, 32-bit unsigned integers should be output as strings.
	 */
	const T_UINT32 = 0x1C;
	/**
	 * Unsigned 64-bit integer.
	 * Note: PHP does not recognize 64-bit unsigned integers at all. In addition, few
	 * databases support unsigned integers and therefore won't have a proper equivalent
	 * for them. Use this type only when absolutely necessary.
	 */
	const T_UINT64 = 0x1D;

	//Non-integers
	/**
	 * A number with (optional) decimal value
	 */
	const T_NUMBER = 0x21;
	/**
	 * A monetary value
	 */
	const T_MONEY = 0x22;
	/**
	 * Floating point numbers
	 */
	const T_FLOAT = 0x23;
	/**
	 * Double-precision floating point numbers
	 */
	const T_DOUBLE = 0x24;

	//Variable-length binary types
	/**
	 * Variable-length unicode text.
	 */
	const T_VARTEXT = 0x31;
	/**
	 * Variable-length text containing only characters in the 0-127 range.
	 */
	const T_VARASCIITEXT = 0x32;
	/**
	 * Variable-length binary blob.
	 */
	const T_VARBINARY = 0x33;
	/**
	 * Variable-length e-mail address.
	 * This type may actually be used to things other than mail address, hence why it's
	 * simply called "ADDRESS".
	 */
	const T_ADDRESS = 0x34;
	/**
	 * Uniform resource identifier.
	 * Location of a resource on the internet or internal network.
	 */
	const T_URI = 0x35;
	/**
	 * Telephone number.
	 * Uses the international format "+xx(yy)zz...zz[:www]" where x is the international
	 * calling code, y is the area code, z is the telephone number (only numbers and
	 * hyphens) and w is the branch line.
	 */
	const T_TELEPHONE = 0x36;
	/**
	 * A software version number.
	 * Version numbers can be separated by a dot (.), "r", "rc", "b", "beta", "a",
	 * "alpha", "p", "pre", "n" or "nightly". And version numbers will use this same order.
	 * For example 1.0 is higher than 1b2 which is higher than 1p900.
	 */
	const T_VERSION = 0x37;

	//Fixed-length binary types
	/**
	 * Fixed-length unicode text.
	 */
	const T_TEXT = 0x41;
	/**
	 * Fixed-length text containing only characters in the 0-127 range.
	 */
	const T_ASCIITEXT = 0x42;
	/**
	 * Fixed-length binary blob.
	 */
	const T_BINARY = 0x43;
	/**
	 * Boolean type.
	 */
	const T_BOOL = 0x44;
	/**
	 * Holds an IPv4 or IPv6 host address, and optionally the identity of the subnet it
	 * is in, all in one field.
	 */
	const T_INET = 0x45;
	/**
	 * Holds an IPv4 or IPv6 network specification.
	 */
	const T_CIDR = 0x46;
	/**
	 * Media Access Control address of a network device.
	 */
	const T_MACADDRESS = 0x47;
	/**
	 * A MD5 hash.
	 * This hash should be output in hex format.
	 */
	const T_MD5 = 0x48;
	/**
	 * A SHA1 hash.
	 * This hash should be output in hex format.
	 */
	const T_SHA1 = 0x49;
	/**
	 * A CRC32 hash.
	 * This hash should be output in hex format.
	 */
	const T_CRC32 = 0x4A;
	/**
	 * Globally unique identifier
	 */
	const T_GUID = 0x4B;

	//Time/date
	/**
	 * Represents an year.
	 * This data type has a limited range - it is designed primarily for current dates,
	 * not historical ones.
	 */
	const T_YEAR = 0x51;
	/**
	 * Represents a month of an year
	 */
	const T_MONTH = 0x52;
	/**
	 * Represents an week of an year
	 */
	const T_WEEK = 0x53;
	/**
	 * Represents a date
	 */
	const T_DATE = 0x54;
	/**
	 * Represents a date without timezone
	 */
	const T_DATETIMELOCAL = 0x55;
	/**
	 * Represents a date with timezone
	 */
	const T_DATETIME = 0x56;
	/**
	 * Represents a time of the day
	 */
	const T_TIME = 0x57;
	/**
	 * Represents a time zone
	 */
	const T_TIMEZONE = 0x58;
	/**
	 * Represents a timestamp that stores the last change made on the database.
	 */
	const T_TIMESTAMP = 0x59;

	//Geometric types
	/**
	 * Represents an angle.
	 * The value must be between 0*PI and 2*PI
	 */
	const T_ANGLE = 0x61;
	/**
	 * Represents a point in 2d space
	 */
	const T_POINT = 0x62;
	/**
	 * Represents an infinite line in 2d space
	 */
	const T_LINE = 0x63;
	/**
	 * Represents a line segment (finite line) in 2d space
	 */
	const T_LSEG = 0x64;
	/**
	 * Represents an path in 2d space that doesn't close.
	 */
	const T_PATH = 0x65;
	/**
	 * Represents an path in 2d space that closes.
	 */
	const T_POLYGON = 0x66;
	/**
	 * Represents a circle in 2d space.
	 */
	const T_CIRCLE = 0x67;
	/**
	 * Represents a rectangle in 2d space.
	 */
	const T_RECT = 0x68;

	private $fields = array();

	function __construct(array $fields) {
		foreach ($fields as $name => $field) {
			$this->fields[$name] = new TableSchema_Field(
				$field['type'], @$field['isNull'], @$field['length'], @$field['decLength']
			);
		}
	}

}

class TableSchema_Field {

	protected $type;
	protected $isNull;
	protected $length;
	protected $decLength;

	function construct($type, $isNull, $length, $decLength) {
		$this->type = (int) $type;
		$this->isNull = filter_var($isNull, FILTER_VALIDATE_BOOLEAN);
		if ($this->type & TableSchema::TYPES_VARIABLE) {
			$this->length = (int) $length;
		} else {
			switch ($this->type) {
				case TableSchema::T_NUMBER:
					$this->decLength = (int) $decLength;
				case TableSchema::T_TEXT:
				case TableSchema::T_ASCIITEXT:
				case TableSchema::T_BINARY:
					$this->length = (int) $length;
			}
		}
	}

}
