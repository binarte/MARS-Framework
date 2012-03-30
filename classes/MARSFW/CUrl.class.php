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

namespace MARSFW;

declare (encoding = "UTF-8");

/**
 * Manages CUrl operation.
 * This class wraps curl_* functions for easy URL handling. Only single handlers here, 
 * no curl_multi_*.
 * 
 * Note that while {@link setOpt()} and {@link setOptArray()} are present, options can be 
 * set via magic methods.
 * <code>
 * 
 * $curl = new CUrl('http://www.example.com');
 * 
 * //those three instructions have the same effect
 * $curl->BUFFERSIZE = 1000;
 * $curl->setOpt(CURLOPT_BUFFERSIZE,1000);
 * $curl->setOptArray(array(CURLOPT_BUFFERSIZE=>1000));
 * </code>
 * 
 * The same applies to {@link getInfo()}
 * <code>
 * 
 * $curl = new CUrl('http://www.example.com');
 * $curl->exec();
 * 
 * //both instructions have the same effect
 * $v = $curl->EFFECTIVE_URL;
 * $v = $curl->getInfo(CURLINFO_EFFECTIVE_URL);
 * </code>
 * 
 * @property-write bool AUTOREFERER 	<b>TRUE</b> to automatically set the Referer: 
 * field in requests where it follows a Location: redirect. 	
 * @property-write bool BINARYTRANSFER 	<b>TRUE</b> to return the raw output when 
 * <b>CURLOPT_RETURNTRANSFER</b> is used. 	
 * @property-write bool COOKIESESSION 	<b>TRUE</b> to mark this as a new cookie 
 * "session". It will force libcurl to ignore all cookies it is about to load that are 
 * "session cookies" from the previous session. By default, libcurl always stores and 
 * loads all cookies, independent if they are session cookies or not. Session cookies are 
 * cookies without expiry date and they are meant to be alive and existing for this 
 * "session" only. 	
 * @property-write bool CERTINFO 	<b>TRUE</b> to output SSL certification information 
 * to STDERR on secure transfers. Requires <b>CURLOPT_VERBOSE</b> to be on to have an 
 * effect.
 * @property-write bool CRLF 	<b>TRUE</b> to convert Unix newlines to CRLF newlines on 
 * transfers. 	
 * @property-write bool DNS_USE_GLOBAL_CACHE 	<b>TRUE</b> to use a global DNS cache. 
 * This option is not thread-safe and is enabled by default. 	
 * @property-write bool FAILONERROR 	<b>TRUE</b> to fail silently if the HTTP code 
 * returned is greater than or equal to 400. The default behavior is to return the page 
 * normally, ignoring the code. 	
 * @property-write bool FILETIME 	<b>TRUE</b> to attempt to retrieve the modification 
 * date of the remote document. This value can be retrieved using the 
 * <b>CURLINFO_FILETIME</b> option with curl_getinfo(). 	
 * @property-write bool FOLLOWLOCATION 	<b>TRUE</b> to follow any "Location: " header 
 * that the server sends as part of the HTTP header (note this is recursive, PHP will 
 * follow as many "Location: " headers that it is sent, unless <b>CURLOPT_MAXREDIRS</b> 
 * is set). 	
 * @property-write bool FORBID_REUSE 	<b>TRUE</b> to force the connection to explicitly 
 * close when it has finished processing, and not be pooled for reuse. 	
 * @property-write bool FRESH_CONNECT 	<b>TRUE</b> to force the use of a new connection 
 * instead of a cached one. 	
 * @property-write bool FTP_USE_EPRT 	<b>TRUE</b> to use EPRT (and LPRT) when doing 
 * active FTP downloads. Use FALSE to disable EPRT and LPRT and use PORT only. 	
 * @property-write bool FTP_USE_EPSV 	<b>TRUE</b> to first try an EPSV command for FTP 
 * transfers before reverting back to PASV. Set to FALSE to disable EPSV. 	
 * @property-write bool FTP_CREATE_MISSING_DIRS 	<b>TRUE</b> to create missing 
 * directories when an FTP operation encounters a path that currently doesn't exist. 	
 * @property-write bool FTPAPPEND 	<b>TRUE</b> to append to the remote file instead of
 * overwriting it. 	
 * @property-write bool FTPASCII 	An alias of <b>CURLOPT_TRANSFERTEXT</b>. Use that 
 * instead. 	
 * @property-write bool FTPLISTONLY 	<b>TRUE</b> to only list the names of an FTP 
 * directory. 	
 * @property-write bool HEADER 	<b>TRUE</b> to include the header in the output. 
 * <b>CURLINFO_HEADER_OUT</b> 	<b>TRUE</b> to track the handle's request string. The 
 * CURLINFO_ prefix is intentional.
 * @property-write bool HTTPGET 	<b>TRUE</b> to reset the HTTP request method to GET. 
 * Since GET is the default, this is only necessary if the request method has been 
 * changed. 	
 * @property-write bool HTTPPROXYTUNNEL 	<b>TRUE</b> to tunnel through a given HTTP 
 * proxy. 	
 * @property-write bool MUTE 	<b>TRUE</b> to be completely silent with regards to the 
 * cURL functions. 	
 * @property-write bool NETRC 	<b>TRUE</b> to scan the ~/.netrc file to find a username 
 * and password for the remote site that a connection is being established with. 	
 * @property-write bool NOBODY 	<b>TRUE</b> to exclude the body from the output. Request 
 * method is then set to HEAD. Changing this to FALSE does not change it to GET. 	
 * @property-write bool NOPROGRESS <b>TRUE</b> to disable the progress meter for cURL 
 * transfers.
 * @property-write bool NOSIGNAL 	<b>TRUE</b> to ignore any cURL function that causes a 
 * signal to be sent to the PHP process. This is turned on by default in multi-threaded 
 * SAPIs so timeout options can still be used.
 * @property-write bool POST 	<b>TRUE</b> to do a regular HTTP POST. This POST is the 
 * normal application/x-www-form-urlencoded kind, most commonly used by HTML forms. 	
 * @property-write bool PUT 	<b>TRUE</b> to HTTP PUT a file. The file to PUT must be 
 * set with <b>CURLOPT_INFILE</b> and <b>CURLOPT_INFILESIZE</b>. 	
 * @property-write bool RETURNTRANSFER 	<b>TRUE</b> to return the transfer as a string of 
 * the return value of curl_exec() instead of outputting it out directly. 	
 * @property-write bool SSL_VERIFYPEER 	FALSE to stop cURL from verifying the peer's 
 * certificate. Alternate certificates to verify against can be specified with the 
 * <b>CURLOPT_CAINFO</b> option or a certificate directory can be specified with the 
 * <b>CURLOPT_CAPATH</b> option. 	<b>TRUE</b> by default as of cURL 7.10. Default 
 * bundle installed as of cURL 7.10.
 * @property-write bool TRANSFERTEXT 	<b>TRUE</b> to use ASCII mode for FTP transfers. 
 * For LDAP, it retrieves data in plain text instead of HTML. On Windows systems, it will 
 * not set STDOUT to binary mode. 	
 * @property-write bool UNRESTRICTED_AUTH 	<b>TRUE</b> to keep sending the username and 
 * password when following locations (using <b>CURLOPT_FOLLOWLOCATION</b>), even when the 
 * hostname has changed. 	
 * @property-write bool UPLOAD 	<b>TRUE</b> to prepare for an upload. 	
 * @property-write bool VERBOSE 	<b>TRUE</b> to output verbose information. Writes 
 * output to STDERR, or the file specified using <b>CURLOPT_STDERR</b>. 
 * 
 * 
 * @property-write int BUFFERSIZE 	The size of the buffer to use for each read. There is no guarantee this request will be fulfilled, however. 	Added in cURL 7.10.
 * @property-write int CLOSEPOLICY 	Either CURLCLOSEPOLICY_LEAST_RECENTLY_USED or CURLCLOSEPOLICY_OLDEST. There are three other CURLCLOSEPOLICY_ constants, but cURL does not support them yet. 	
 * @property-write int CONNECTTIMEOUT 	The number of seconds to wait while trying to connect. Use 0 to wait indefinitely. 	
 * @property-write int CONNECTTIMEOUT_MS 	The number of milliseconds to wait while trying to connect. Use 0 to wait indefinitely. If libcurl is built to use the standard system name resolver, that portion of the connect will still use full-second resolution for timeouts with a minimum timeout allowed of one second. 	Added in cURL 7.16.2. Available since PHP 5.2.3.
 * @property-write int DNS_CACHE_TIMEOUT 	The number of seconds to keep DNS entries in memory. This option is set to 120 (2 minutes) by default. 	
 * @property-write int FTPSSLAUTH 	The FTP authentication method (when is activated): CURLFTPAUTH_SSL (try SSL first), CURLFTPAUTH_TLS (try TLS first), or CURLFTPAUTH_DEFAULT (let cURL decide). 	Added in cURL 7.12.2.
 * @property-write int HTTP_VERSION 	CURL_HTTP_VERSION_NONE (default, lets CURL decide which version to use), CURL_HTTP_VERSION_1_0 (forces HTTP/1.0), or CURL_HTTP_VERSION_1_1 (forces HTTP/1.1). 	
 * @property-write int HTTPAUTH 	

The HTTP authentication method(s) to use. The options are: CURLAUTH_BASIC, CURLAUTH_DIGEST, CURLAUTH_GSSNEGOTIATE, CURLAUTH_NTLM, CURLAUTH_ANY, and CURLAUTH_ANYSAFE.

The bitwise | (or) operator can be used to combine more than one method. If this is done, cURL will poll the server to see what methods it supports and pick the best one.

CURLAUTH_ANY is an alias for CURLAUTH_BASIC | CURLAUTH_DIGEST | CURLAUTH_GSSNEGOTIATE | CURLAUTH_NTLM.

CURLAUTH_ANYSAFE is an alias for CURLAUTH_DIGEST | CURLAUTH_GSSNEGOTIATE | CURLAUTH_NTLM.
	
 * @property-write int INFILESIZE 	The expected size, in bytes, of the file when uploading a file to a remote site. Note that using this option will not stop libcurl from sending more data, as exactly what is sent depends on CURLOPT_READFUNCTION. 	
 * @property-write int LOW_SPEED_LIMIT 	The transfer speed, in bytes per second, that the transfer should be below during the count of CURLOPT_LOW_SPEED_TIME seconds before PHP considers the transfer too slow and aborts. 	
 * @property-write int LOW_SPEED_TIME 	The number of seconds the transfer speed should be below CURLOPT_LOW_SPEED_LIMIT before PHP considers the transfer too slow and aborts. 	
 * @property-write int MAXCONNECTS 	The maximum amount of persistent connections that are allowed. When the limit is reached, CURLOPT_CLOSEPOLICY is used to determine which connection to close. 	
 * @property-write int MAXREDIRS 	The maximum amount of HTTP redirections to follow. Use this option alongside CURLOPT_FOLLOWLOCATION. 	
 * @property-write int PORT 	An alternative port number to connect to. 	
 * @property-write int PROTOCOLS 	

Bitmask of CURLPROTO_* values. If used, this bitmask limits what protocols libcurl may use in the transfer. This allows you to have a libcurl built to support a wide range of protocols but still limit specific transfers to only be allowed to use a subset of them. By default libcurl will accept all protocols it supports. See also CURLOPT_REDIR_PROTOCOLS.

Valid protocol options are: CURLPROTO_HTTP, CURLPROTO_HTTPS, CURLPROTO_FTP, CURLPROTO_FTPS, CURLPROTO_SCP, CURLPROTO_SFTP, CURLPROTO_TELNET, CURLPROTO_LDAP, CURLPROTO_LDAPS, CURLPROTO_DICT, CURLPROTO_FILE, CURLPROTO_TFTP, CURLPROTO_ALL
	Added in cURL 7.19.4.
 * @property-write int PROXYAUTH 	The HTTP authentication method(s) to use for the proxy connection. Use the same bitmasks as described in CURLOPT_HTTPAUTH. For proxy authentication, only CURLAUTH_BASIC and CURLAUTH_NTLM are currently supported. 	Added in cURL 7.10.7.
 * @property-write int PROXYPORT 	The port number of the proxy to connect to. This port number can also be set in CURLOPT_PROXY. 	
 * @property-write int PROXYTYPE 	Either CURLPROXY_HTTP (default) or CURLPROXY_SOCKS5. 	Added in cURL 7.10.
 * @property-write int REDIR_PROTOCOLS 	Bitmask of CURLPROTO_* values. If used, this bitmask limits what protocols libcurl may use in a transfer that it follows to in a redirect when CURLOPT_FOLLOWLOCATION is enabled. This allows you to limit specific transfers to only be allowed to use a subset of protocols in redirections. By default libcurl will allow all protocols except for FILE and SCP. This is a difference compared to pre-7.19.4 versions which unconditionally would follow to all protocols supported. See also CURLOPT_PROTOCOLS for protocol constant values. 	Added in cURL 7.19.4.
 * @property-write int RESUME_FROM 	The offset, in bytes, to resume a transfer from. 	
 * @property-write int SSL_VERIFYHOST 	1 to check the existence of a common name in the SSL peer certificate. 2 to check the existence of a common name and also verify that it matches the hostname provided. In production environments the value of this option should be kept at 2 (default value). 	
 * @property-write int SSLVERSION 	The SSL version (2 or 3) to use. By default PHP will try to determine this itself, although in some cases this must be set manually. 	
 * @property-write int TIMECONDITION 	How CURLOPT_TIMEVALUE is treated. Use CURL_TIMECOND_IFMODSINCE to return the page only if it has been modified since the time specified in CURLOPT_TIMEVALUE. If it hasn't been modified, a "304 Not Modified" header will be returned assuming CURLOPT_HEADER is TRUE. Use CURL_TIMECOND_IFUNMODSINCE for the reverse effect. CURL_TIMECOND_IFMODSINCE is the default. 	
 * @property-write int TIMEOUT 	The maximum number of seconds to allow cURL functions to execute. 	
 * @property-write int TIMEOUT_MS 	The maximum number of milliseconds to allow cURL functions to execute. If libcurl is built to use the standard system name resolver, that portion of the connect will still use full-second resolution for timeouts with a minimum timeout allowed of one second. 	Added in cURL 7.16.2. Available since PHP 5.2.3.
 * @property-write int TIMEVALUE 	The time in seconds since January 1st, 1970. The time will be used by CURLOPT_TIMECONDITION. By default, CURL_TIMECOND_IFMODSINCE is used. 	
 * @property-write int MAX_RECV_SPEED_LARGE 	If a download exceeds this speed (counted in bytes per second) on cumulative average during the transfer, the transfer will pause to keep the average rate less than or equal to the parameter value. Defaults to unlimited speed. 	Added in cURL 7.15.5. Available since PHP 5.4.0.
 * @property-write int MAX_SEND_SPEED_LARGE 	If an upload exceeds this speed (counted in bytes per second) on cumulative average during the transfer, the transfer will pause to keep the average rate less than or equal to the parameter value. Defaults to unlimited speed. 	Added in cURL 7.15.5. Available since PHP 5.4.0.
 * @property-write int SSH_AUTH_TYPES 	A bitmask consisting of one or more of CURLSSH_AUTH_PUBLICKEY, CURLSSH_AUTH_PASSWORD, CURLSSH_AUTH_HOST, CURLSSH_AUTH_KEYBOARD. Set to CURLSSH_AUTH_ANY to let libcurl pick one. 
 * 
 * @property-write string CAINFO 	The name of a file holding one or more certificates to verify the peer with. This only makes sense when used in combination with CURLOPT_SSL_VERIFYPEER. 	Requires absolute path.
 * @property-write string CAPATH 	A directory that holds multiple CA certificates. Use this option alongside CURLOPT_SSL_VERIFYPEER. 	
 * @property-write string COOKIE 	The contents of the "Cookie: " header to be used in the HTTP request. Note that multiple cookies are separated with a semicolon followed by a space (e.g., "fruit=apple; colour=red") 	
 * @property-write string COOKIEFILE 	The name of the file containing the cookie data. The cookie file can be in Netscape format, or just plain HTTP-style headers dumped into a file. If the name is an empty string, no cookies are loaded, but cookie handling is still enabled. 	
 * @property-write string COOKIEJAR 	The name of a file to save all internal cookies to when the handle is closed, e.g. after a call to curl_close. 	
 * @property-write string CUSTOMREQUEST 	

A custom request method to use instead of "GET" or "HEAD" when doing a HTTP request. This is useful for doing "DELETE" or other, more obscure HTTP requests. Valid values are things like "GET", "POST", "CONNECT" and so on; i.e. Do not enter a whole HTTP request line here. For instance, entering "GET /index.html HTTP/1.0\r\n\r\n" would be incorrect.

    Note:

    Don't do this without making sure the server supports the custom request method first.

	
 * @property-write string EGDSOCKET 	Like CURLOPT_RANDOM_FILE, except a filename to an Entropy Gathering Daemon socket. 	
 * @property-write string ENCODING 	The contents of the "Accept-Encoding: " header. This enables decoding of the response. Supported encodings are "identity", "deflate", and "gzip". If an empty string, "", is set, a header containing all supported encoding types is sent. 	Added in cURL 7.10.
 * @property-write string FTPPORT 	The value which will be used to get the IP address to use for the FTP "POST" instruction. The "POST" instruction tells the remote server to connect to our specified IP address. The string may be a plain IP address, a hostname, a network interface name (under Unix), or just a plain '-' to use the systems default IP address. 	
 * @property-write string INTERFACE 	The name of the outgoing network interface to use. This can be an interface name, an IP address or a host name. 	
 * @property-write string KEYPASSWD 	The password required to use the CURLOPT_SSLKEY or CURLOPT_SSH_PRIVATE_KEYFILE private key. 	Added in cURL 7.16.1.
 * @property-write string KRB4LEVEL 	The KRB4 (Kerberos 4) security level. Any of the following values (in order from least to most powerful) are valid: "clear", "safe", "confidential", "private".. If the string does not match one of these, "private" is used. Setting this option to NULL will disable KRB4 security. Currently KRB4 security only works with FTP transactions. 	
 * @property-write string POSTFIELDS 	The full data to post in a HTTP "POST" operation. To post a file, prepend a filename with @ and use the full path. The filetype can be explicitly specified by following the filename with the type in the format ';type=mimetype'. This parameter can either be passed as a urlencoded string like 'para1=val1&para2=val2&...' or as an array with the field name as key and field data as value. If value is an array, the Content-Type header will be set to multipart/form-data. As of PHP 5.2.0, value must be an array if files are passed to this option with the @ prefix. 	
 * @property-write string PROXY 	The HTTP proxy to tunnel requests through. 	
 * @property-write string PROXYUSERPWD 	A username and password formatted as "[username]:[password]" to use for the connection to the proxy. 	
 * @property-write string RANDOM_FILE 	A filename to be used to seed the random number generator for SSL. 	
 * @property-write string RANGE 	Range(s) of data to retrieve in the format "X-Y" where X or Y are optional. HTTP transfers also support several intervals, separated with commas in the format "X-Y,N-M". 	
 * @property-write string REFERER 	The contents of the "Referer: " header to be used in a HTTP request. 	
 * @property-write string SSH_HOST_PUBLIC_KEY_MD5 	A string containing 32 hexadecimal digits. The string should be the MD5 checksum of the remote host's public key, and libcurl will reject the connection to the host unless the md5sums match. This option is only for SCP and SFTP transfers. 	Added in cURL 7.17.1.
 * @property-write string SSH_PUBLIC_KEYFILE 	The file name for your public key. If not used, libcurl defaults to $HOME/.ssh/id_dsa.pub if the HOME environment variable is set, and just "id_dsa.pub" in the current directory if HOME is not set. 	Added in cURL 7.16.1.
 * @property-write string SSH_PRIVATE_KEYFILE 	The file name for your private key. If not used, libcurl defaults to $HOME/.ssh/id_dsa if the HOME environment variable is set, and just "id_dsa" in the current directory if HOME is not set. If the file is password-protected, set the password with CURLOPT_KEYPASSWD. 	Added in cURL 7.16.1.
 * @property-write string SSL_CIPHER_LIST 	A list of ciphers to use for SSL. For example, RC4-SHA and TLSv1 are valid cipher lists. 	
 * @property-write string SSLCERT 	The name of a file containing a PEM formatted certificate. 	
 * @property-write string SSLCERTPASSWD 	The password required to use the CURLOPT_SSLCERT certificate. 	
 * @property-write string SSLCERTTYPE 	The format of the certificate. Supported formats are "PEM" (default), "DER", and "ENG". 	Added in cURL 7.9.3.
 * @property-write string SSLENGINE 	The identifier for the crypto engine of the private SSL key specified in CURLOPT_SSLKEY. 	
 * @property-write string SSLENGINE_DEFAULT 	The identifier for the crypto engine used for asymmetric crypto operations. 	
 * @property-write string SSLKEY 	The name of a file containing a private SSL key. 	
 * @property-write string SSLKEYPASSWD 	

The secret password needed to use the private SSL key specified in CURLOPT_SSLKEY.

    Note:

    Since this option contains a sensitive password, remember to keep the PHP script it is contained within safe.

	
 * @property-write string SSLKEYTYPE 	The key type of the private SSL key specified in CURLOPT_SSLKEY. Supported key types are "PEM" (default), "DER", and "ENG". 	
 * @property-write string URL 	The URL to fetch. This can also be set when initializing a session with curl_init(). 	
 * @property-write string USERAGENT 	The contents of the "User-Agent: " header to be used in a HTTP request. 	
 * @property-write string USERPWD 	A username and password formatted as "[username]:[password]" to use for the connection. 
 * 
 * @property-write resource FILE 	The file that the transfer should be written to. The default is STDOUT (the browser window).
 * @property-write resource INFILE 	The file that the transfer should be read from when uploading.
 * @property-write resource STDERR 	An alternative location to output errors to instead of STDERR.
 * @property-write resource WRITEHEADER 	The file that the header part of the transfer is written to. 
 * 
 * 
 * @property-write callback HEADERFUNCTION 	The name of a callback function where the callback function takes two parameters. The first is the cURL resource, the second is a string with the header data to be written. The header data must be written when using this callback function. Return the number of bytes written.
 * @property-write callback PASSWDFUNCTION 	The name of a callback function where the callback function takes three parameters. The first is the cURL resource, the second is a string containing a password prompt, and the third is the maximum password length. Return the string containing the password.
 * @property-write callback PROGRESSFUNCTION 	The name of a callback function where the callback function takes three parameters. The first is the cURL resource, the second is a file-descriptor resource, and the third is length. Return the string containing the data.
 * @property-write callback READFUNCTION 	The name of a callback function where the callback function takes three parameters. The first is the cURL resource, the second is a stream resource provided to cURL through the option CURLOPT_INFILE, and the third is the maximum amount of data to be read. The callback function must return a string with a length equal or smaller than the amount of data requested, typically by reading it from the passed stream resource. It should return an empty string to signal EOF.
 * @property-write callback WRITEFUNCTION 	The name of a callback function where the callback function takes two parameters. The first is the cURL resource, and the second is a string with the data to be written. The data must be saved by using this callback function. It must return the exact number of bytes written or the transfer will be aborted with an error. 
 * 
 * @property-read string EFFECTIVE_URL - Last effective URL
 * @property-read int HTTP_CODE - Last received HTTP code
 * @property-read int FILETIME - Remote time of the retrieved document, if -1 is returned the time of the document is unknown
 * @property-read int TOTAL_TIME - Total transaction time in seconds for last transfer
 * @property-read int NAMELOOKUP_TIME - Time in seconds until name resolving was complete
 * @property-read int CONNECT_TIME - Time in seconds it took to establish the connection
 * @property-read int PRETRANSFER_TIME - Time in seconds from start until just before file transfer begins
 * @property-read int STARTTRANSFER_TIME - Time in seconds until the first byte is about to be transferred
 * @property-read int REDIRECT_TIME - Time in seconds of all redirection steps before final transaction was started
 * @property-read int SIZE_UPLOAD - Total number of bytes uploaded
 * @property-read int SIZE_DOWNLOAD - Total number of bytes downloaded
 * @property-read int SPEED_DOWNLOAD - Average download speed
 * @property-read int SPEED_UPLOAD - Average upload speed
 * @property-read int HEADER_SIZE - Total size of all headers received
 * @property-read string HEADER_OUT - The request string sent. For this to work, add the CURLINFO_HEADER_OUT option to the handle by calling curl_setopt()
 * @property-read int REQUEST_SIZE - Total size of issued requests, currently only for HTTP requests
 * @property-read int SSL_VERIFYRESULT - Result of SSL certification verification requested by setting CURLOPT_SSL_VERIFYPEER
 * @property-read int CONTENT_LENGTH_DOWNLOAD - content-length of download, read from Content-Length: field
 * @property-read int CONTENT_LENGTH_UPLOAD - Specified size of upload
 * @property-read string CONTENT_TYPE - Content-Type: of the requested document, NULL indicates server did not send valid Content-Type: header

 */
class CUrl extends WrapperObject {

	
	/**
	 * Creates an instance fo CUrl
	 * @param string $url If provided, request URL option will be set to its value. You 
	 * can manually set this later. 
	 * @uses \curl_init()
	 * @see setOpt()
	 * @see setOptArray()
	 */
	function __construct($url = null){
		$this->handler = \curl_init($url);
	}
	
	/**
	 * Closes the resource and cleans the memory
	 * @uses \curl_close()
	 */
	function __destruct(){
		\curl_close($this->handler);
	}
	
	/**
	 * Gets information about the handler
	 * @param string $attr Name of the attribute to get. Must be the name of a CURLINFO_* 
	 * constant without the CURLINFO_ prefix.
	 * @return mixed The value of the requested information 
	 * @uses \curl_getinfo()
	 */
	function __get($attr){
		return \curl_getinfo($this->handler,constant('CURLINFO_'.strtoupper($attr) ) );
	}
	
	/**
	 * Sets a CUrl parameter.
	 * @param type $attr Name of the parameter to be set. Must be the name of a CURLOPT_* 
	 * constant without the CURLOPT_ prefix.
	 * @param mixed $value The value to set the parameter to
	 * @uses \curl_setopt()
	 */
	function __set($attr,$value){
		\curl_setopt($this->handler,constant('CURLOPT_'.strtoupper($attr) ),$value);
	}
	
	/**
	 * Ensures that clones will refer to different resources.
	 * @uses \curl_copy_handle()
	 */
	function __clone(){
		$this->handler = \curl_copy_handle($this->handler);
	}
	
	/**
	 * Return a string containing the last error for the current session.
	 * Returns a clear text error message for the last cURL operation.
	 * @return string Returns the error message or '' (empty string) if no error 
	 * occurred. 
	 * @uses \curl_error()
	 */
	function error(){
		return \curl_error($this->handler,$option);
	}
	
	/**
	 * Return the last error number.
	 * Returns the error number for the last cURL operation. 
	 * @return int Returns the error number or 0 (zero) if no error occurred. 
	 * @uses \curl_errNo()
	 */
	function errNo(){
		return \curl_errno($this->handler,$option);
	}
	
	/**
	 * Get information regarding a specific transfer.
	 * Gets information about the last transfer. 
	 * @param int $option If specified, will return the given parameter, otherwise will 
	 * return an array will all the information.
	 * @return mixed If $option is given, returns its value as a string. Otherwise, 
	 * returns an associative array with all elements, or FALSE on failure
	 * @uses \curl_getinfo()
	 */
	function getInfo($option = null){
		if (func_num_args () ) return \curl_getinfo($this->handler,$option);
		return \curl_getinfo($this->handler);
	}
	
	/**
	 * Sets an option
	 * @param int $option
	 * @param mixed $value
	 * @return bool
	 * @uses \curl_setopt()
	 */
	function setOpt($option,$value){
		return \curl_setopt($this->handler,$option,$value);
	}
	
	/**
	 * Sets several options at a time
	 * @param array $value
	 * @return bool 
	 * @uses \curl_setopt_array()
	 */
	function setOptArray(Array $value){
		return \curl_setopt_array($this->handler,$value);
	}
	
	/**
	 * Runs the request
	 * @return mixed
	 */
	function exec(){
		return \curl_exec($this->handler);
	}	
	
	/**
	 * Runs the request.
	 * Identical to {@link exec()}, except it will throw an exception if an error occurs.
	 * @return mixed
	 * @throws CUrlException Will be thrown if an error occurs on the cURL operation.
	 */
	function execThrow(){
		$ret = \curl_exec($this->handler);
		$e = \curl_errno($this->handler);
		if ($e){
			throw new CUrlException(\curl_error($this->handler),$e);
		}
		
		return $ret;
	}
	
}

class CUrlException extends \RuntimeException{}