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

/**
 * Gerenciador de recursos e erros do framework.
 * @author Vanduir Volpato Maia 
 */
final class Manager extends Object {

	/**
	 * Retorna os caminhos de inclusão
	 * @var Array
	 */
	private static $paths = array();

	/**
	 * Retorna os caminhos de inclusão
	 * @return array
	 */
	public static function getPaths() {
		return self::$paths;
	}

	/**
	 * Tipos de erro que podem ser ignorados com o operador @
	 * @var int
	 */
	private static $ignorableErrors;

	/**
	 * Tipos de erros causados por práticas depreciadas
	 * @var int
	 */
	private static $deprecatedErrors;

	/**
	 * Define se erros de depreciação devem ser logados
	 * @var bool
	 */
	private static $logDeprecated;

	/**
	 * Timestamp de início
	 * @var int
	 */
	private static $startTime;

	/**
	 * Define se o gerenciamento simples de erro está ativo.
	 * @var bool
	 */
	private static $simpleError;

	/**
	 * Define de foi encontrado um erro após a ativação do gerenciamento simples de erro.
	 * @var bool 
	 */
	private static $hasError;

	/**
	 * Inicia o gerenciador usando o dado caminho como primeiro diretório de inclusão.
	 * Este método só pode ser chamado uma única vez. Tentativas subsequentes não 
	 * surtirão efeito.
	 * @param string $path Caminho inicial
	 * @param bool $log_deprecated Define se erros de depreciação devem ser logados
	 * @todo HIGH PRIORITY: fix excoptions throws without a stack frame and re-enable custom error 
	 * reporting
	 */
	public static function init($path, $log_deprecated = false) {
		if (count(self::$paths)) {
			return;
		}
		set_include_path($path);
		self::$startTime = time();
		self::$paths[] = $path;
		self::$ignorableErrors = E_NOTICE | E_USER_NOTICE;
		self::$deprecatedErrors = E_DEPRECATED | E_USER_DEPRECATED | E_STRICT;
		self::$logDeprecated = $log_deprecated;

		set_error_handler(__CLASS__ . '::errorHandler');
		set_exception_handler(__CLASS__ . '::exceptionHandler');
		error_reporting(0x7fffffff);
	}

	/**
	 * Adiciona o caminho 
	 * @param type $path 
	 */
	public static function addIncludePath($path) {
		set_include_path($path . PATH_SEPARATOR . get_include_path());
		self::$paths[] = $path;
	}

	public static function loadClass($className) {
		$className = str_replace('\\', '/', $className);		
		include_once 'classes/' . $className . '.class.php';
	}

	/**
	 * Starts the simple error handler.
	 * The simple error handler allows to handle erros in a quicker, cleaner way, since 
	 * it avoids the overhead of creating and throwing exceptions.
	 * @uses $simpleError
	 * @uses $hasError
	 * @see simpleError_end
	 * @see errorHandler
	 */
	public static function simpleError_start() {
		self::$simpleError = true;
		self::$hasError = false;
	}

	/**
	 * Ends the simple error handler and returns the result.
	 * @return bool <b>TRUE</b> if a error has occurred, <b>FALSE</b> if otherwise.
	 * @uses $simpleError
	 * @uses $hasError
	 * @see simpleError_start
	 * @see errorHandler
	 */
	public static function simpleError_end() {
		self::$simpleError = false;
		return self::$hasError;
	}

	/**
	 * Handler for the system errors and <i>trigger_error()</i> calls
	 * @param int $errno Type of error
	 * @param string $errstr Error message
	 * @param string $errfile File where the error occurred
	 * @param int $errline Line of the file where the error occurred
	 * @throws \ErrorException 
	 * @uses $simpleError
	 * @uses $hasError
	 * @uses $ignorableErrors
	 * @uses $deprecatedErrors
	 * @uses $logDeprecated
	 * @uses \ErrorException
	 * @uses error_reporting
	 * @uses logError
	 * @see trigger_error
	 */
	public static function errorHandler($errno, $errstr, $errfile = null, $errline = null) {
		if (self::$simpleError) {
			self::$hasError = true;
			return;
		}
		if (!error_reporting() and $errno & self::$ignorableErrors) {
			return;
		}
		$ex = new \ErrorException($errstr, 0, $errno, $errfile, $errline, NULL);
		if ($errno & self::$deprecatedErrors) {
			if (self::$logDeprecated) {
				self::logError($ex);
			}
		} else {
			throw $ex;
		}
	}

	public static function exceptionHandler($ex) {
		self::logError($ex);
		die;
	}

	/**
	 * Armazena os erros
	 * @var Manager_ErrorLog
	 */
	private static $logh;

	public static function logError(\Exception $ex) {
		if (empty(self::$logh)) {
			try {
				self::$logh = new Manager_ErrorLog(self::$paths[0], date('Ymd', self::$startTime));
			} catch (Exception $ex2) {
				die('Unable to open log file:' . $ex2->getMessage());
			}
		}

		self::$logh->add($ex);

		return;
	}

}

class Manager_ErrorLog {

	private $handler;
	private $currentHandler;
	private $count = 0;

	function __construct($path, $name) {
		$path = $path . '/data/';
		if (!file_exists($path)) {
			mkdir($path, 0777, true);
		}
		$filename = $path . $name . '.errors.xml';
		$lfilename = $path . 'latest.errors.xml';
		$this->currentHandler = fopen($lfilename, 'w');

		if (!file_exists($filename)) {
			$this->handler = fopen($path . $name . '.errors.xml', 'w');
			$this->write('<?xml version="1.0" encoding="UTF-8"?><errorLog>');
		} else {
			$this->handler = fopen($path . $name . '.errors.xml', 'r+');
			fseek($this->handler, filesize($filename) - strlen('</errorLog>'), SEEK_SET);
			fwrite($this->currentHandler, '<?xml version="1.0" encoding="UTF-8"?><errorLog>');
		}

		$this->write('<execution time="' . date(\DateTime::RFC3339) . '"><env>');

		$r = array();

		foreach ($_SERVER as $key => $value) {
			$skey = explode('_', $key, 2);
			if (isset($skey[1]) and !in_array($skey[0], array('DOCUMENT', 'GATEWAY', 'PHP', 'QUERY'))) {
				$r[$skey[0]][$skey[1]] = $value;
			} else {
				$r[$key] = $value;
			}
		}

		if (isset($r['PATH'])) {
			$r['PATH'] = explode(PATH_SEPARATOR, $r['PATH']);
		}
		if (isset($r['PATHEXT'])) {
			$r['PATHEXT'] = explode(PATH_SEPARATOR, $r['PATHEXT']);
		}
		ksort($r);

		$this->addVars($r, '$_SERVER');
		$this->addVars($_SESSION, '$_SESSION');
		$this->addVars($_GET, '$_GET');
		$this->addVars($_POST, '$_POST');
		$this->addVars($_COOKIE, '$_COOKIE');
		$this->addVars($_FILES, '$_FILES');
		$this->addVars($_ENV, '$_ENV');
		$this->write('</env><errors>');
	}

	function __destruct() {
		$this->write('</errors></execution></errorLog>');
		fclose($this->handler);
	}

	private function write($content) {
		fwrite($this->currentHandler, $content);
		fwrite($this->handler, $content);
	}

	private function escape($var) {
		$var = addcslashes($var, "\0..\10\13\14\16..\37");
		if (!mb_check_encoding($var, 'UTF-8')) {
			$var = mb_convert_encoding($var, 'UTF-8', mb_detect_encoding($var));
		}
		return htmlspecialchars($var);
	}

	private function addVars($var, $varname, $recursion = 3) {
		if (is_object($var)) {
			$type = gettype($var) . '(' . get_class($var) . ')';
		} else {
			$type = gettype($var);
		}
		$varname = ($varname or is_numeric($varname) ) ? ' name="' . $varname . '"' : '';

		$this->write('<var' . $varname . ' type="' . $type . '"');
		if (is_array($var)) {
			$count = count($var);
			$this->write(' count="' . $count . '"');
			if ($recursion and $count) {
				$this->write('>');
				$recursion--;
				foreach ($var as $key => $value) {
					$this->addVars($value, $key, $recursion);
				}
				$this->write('</var>');
			} else {
				$this->write('/>');
			}
		} else {
			if (is_null($var)) {
				$this->write('/>');
			} else {
				if (!is_string($var) and !is_numeric($var)) {
					$var = var_export($var, true);
				}

				$var = $this->escape($var);
				$this->write(' value="' . $var . '"/>');
			}
		}
	}

	function add(\Exception $ex) {
		$tagName = get_class($ex);
		$this->count++;
		$this->write('<error num="' . $this->count . '">');
		while ($ex) {
			$this->write('<exception class="' . $tagName . '"' .
					' file="' . $this->escape($ex->getFile()) . '"' .
					' line="' . $ex->getLine() . '"' .
					' code="0x' . dechex($ex->getCode()) . '"' .
					'>'
			);

			//fixing php 5.4 bug that prevents trigger_error messages from coming when it 
			//contains certain characters
			$bTrace = $ex->getTrace();
			unset($bTrace[0]);

			if (
					!empty($btrace) and
					strcasecmp($bTrace[1]['function'], 'trigger_error') == 0
			) {
				$msg = $bTrace[1]['args'][0];
			} else {
				$msg = $ex->getMessage();
			}

			$this->write('<message>' . $this->escape($msg) . '</message>');
			if ($ex instanceof \ErrorException) {
				$this->write('<severity code="' . $ex->getSeverity() . '">');
				switch ($ex->getSeverity()) {
					case E_ERROR:
					case E_USER_ERROR:
						$this->write('E_ERROR');
						break;
					case E_WARNING:
					case E_USER_WARNING:
						$this->write('E_WARNING');
						break;
					case E_NOTICE:
					case E_USER_NOTICE:
						$this->write('E_NOTICE');
						break;
					case E_DEPRECATED:
					case E_USER_DEPRECATED:
						$this->write('E_DEPRECATED');
						break;

					case E_STRICT:
						$this->write('E_STRICT');
						break;
					case E_RECOVERABLE_ERROR:
						$this->write('E_RECOVERABLE_ERROR');
						break;

					case E_PARSE:
						$this->write('E_PARSE');
						break;

					case E_COMPILE_ERROR:
						$this->write('E_COMPILE_ERROR');
						break;
					case E_COMPILE_WARNING:
						$this->write('E_COMPILE_WARNING');
						break;

					case E_CORE_ERROR:
						$this->write('E_CORE_ERROR');
						break;
					case E_CORE_WARNING:
						$this->write('E_CORE_WARNING');
						break;

					default:
						$this->write('E_UNKNOWN');
						break;
				}
				$this->write('</severity>');
			} elseif ($ex instanceof Database\Exception) {
				$this->write('<sql>' . $this->escape($ex->getSql()) . '</sql>');
			}

			if (count($bTrace)) {
				$this->write('<backTrace>');
				foreach ($bTrace as $trace) {
					$this->write('<trace');
					if (isset($trace['args'])) {
						$args = $trace['args'];
						unset($trace['args']);
					} else {
						$args = null;
					}

					foreach ($trace as $key => $value) {
						$value = $this->escape($value);
						$this->write(' ' . $key . '="' . $value . '"');
					}

					if (isset($args)) {
						$this->write('>');
						foreach ($args as $key => $arg) {
							$this->addVars($arg, $key);
						}
						$this->write('</trace>');
					} else {
						$this->write('/>');
					}
				}
				$this->write('</backTrace>');
			}

			$this->write('</exception>');

			$ex = $ex->getPrevious();
		}
		$this->write('</error>');
	}

}

