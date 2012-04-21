<?php

namespace MARSFW;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Imap
 *
 * @author vanduir
 */
class Imap extends WrapperObject {

//<editor-fold defaultstate="collapsed">
	static function to8Bit($string) {
		return \imap_8bit($string);
	}

	static function base64($string) {
		return \imap_base64($string);
	}

	static function binary($string) {
		return \imap_binary($string);
	}

	static function alerts() {
		return \imap_alerts();
	}

	static function errors() {
		return \imap_errors();
	}

	static function mail($to, $subject, $message, $additional_headers = null, $cc = null, $bcc = null, $rpath = null) {
		return \imap_mail($to, $subject, $message, $additional_headers, $cc, $bcc, $rpath);
	}

	static function mailCompose(array $envelope, array $body) {
		return \imap_mail_compose($envelope, $body);
	}
	
	static function mimeHeaderDecode($text){
		return \imap_mime_header_decode($text);
	}

	static function qPrint($string) {
		return \imap_qprint($string);
	}

	static function rfc822ParseAdrList($address, $default_host) {
		return \imap_rfc822_parse_adrlist($address, $default_host);
	}

	static function rfc822ParseHeaders($address, $default_host = 'UNKNOWN') {
		return \imap_rfc822_parse_headers($address, $default_host);
	}

	static function rfc822WriteAddress($mailbox, $host, $personal) {
		return \imap_rfc822_write_address($mailbox, $host, $personal);
	}

	static function timeout($timeout_type, $timeout = -1) {
		return \imap_timeout($timeout_type, $timeout);
	}

	static function utf7Decode($text) {
		return \imap_utf7_decode($text);
	}

	static function utf7Encode($text) {
		return \imap_utf7_encode($text);
	}

	static function utf8($mime_encoded_text) {
		return \imap_utf8($mime_encoded_text);
	}

//</editor-fold>
	function __construct($mailbox, $username, $password, $options = 0, $n_retries = 0, array $params = null) {
		$this->handler = \imap_open($mailbox, $username, $password, $options, $n_retries, $params);
	}

	function __destruct() {
		\imap_check($this->handler, $this->closeFlags);
	}

	private $closeFlags = 0;

	function setCloseFlags($options) {
		$this->closeFlags = (int) $options;
	}

	private $options = 0;

	function setOptions($options) {
		$this->options = (int) $options;
	}

//<editor-fold defaultstate="collapsed">
	function append($mailbox, $message, $options = null, \DateTime $internal_date = null) {
		if ($internal_date !== null) {
			$internal_date = $internal_date::format('d-M-Y H:i:s O');
		}
		return \imap_append($this->handler, $mailbox, $message, $options, $internal_date);
	}

	function body($msg_number, $options = 0) {
		return \imap_body($this->handler, $msg_number, $options);
	}

	function bodyStruct($msg_number, $section) {
		return \imap_bodystruct($this->handler, $msg_number, $section);
	}

	function check() {
		return \imap_check($this->handler);
	}

	function clearFlagFull($sequence, $flag, $options) {
		return \imap_clearflag_full($this->handler, $sequence, $flag, $options);
	}

	function createMailBox($mailbox) {
		return \imap_createmailbox($this->handler, $mailbox);
	}

	function delete($msg_number, $options) {
		return \imap_delete($this->handler, $msg_number, $options);
	}

	function deleteMailBox($mailbox) {
		return \imap_deletemailbox($this->handler, $mailbox);
	}

	function expunge() {
		return \imap_expunge($this->handler);
	}

	function fetchOverview($sequence, $options = 0) {
		return \imap_fetch_overview($this->handler, $sequence, $options);
	}

	function fetchBody($msg_number, $section, $options = 0) {
		return \imap_fetchbody($this->handler, $msg_number, $section, $options);
	}

	function fetchHeader($msg_number, $options = 0) {
		return \imap_fetchheader($this->handler, $msg_number, $options);
	}

	function fetchStructure($msg_number, $options = 0) {
		return \imap_fetchstructure($this->handler, $msg_number, $options);
	}

	function fetchText($msg_no, $options = 0) {
		return \imap_fetchText($this->handler, $msg_no, $options);
	}

	function gc($caches) {
		return \imap_gc($this->handler, $caches);
	}

	function getQuota($quota_root) {
		return \imap_get_quota($this->handler, $quota_root);
	}

	function getQuotaRoot($quota_root) {
		return \imap_get_quotaroot($this->handler, $quota_root);
	}

	function getAcl($mailbox) {
		return \imap_getacl($this->handler, $mailbox);
	}

	function getMailBoxes($ref, $pattern) {
		return \imap_getmailboxes($this->handler, $ref, $pattern);
	}

	function getSubscribed($ref, $pattern) {
		return \imap_getsubscribed($this->handler, $ref, $pattern);
	}

	function headerInfo($msg_no, $from_length, $subject_length, $default_host) {
		return \imap_header($this->handler, $msg_no, $from_length, $subject_length, $default_host);
	}

	function headers() {
		return \imap_headers($this->handler);
	}

	function listMailBoxes($ref, $pattern) {
		return \imap_list($this->handler, $ref, $pattern);
	}

	function lsub($ref, $pattern) {
		return \imap_lsub($this->handler, $ref, $pattern);
	}

	function mailCopy($msglist, $mailbox, $options = 0) {
		return \imap_mail_copy($this->handler, $msglist, $mailbox, $options);
	}

	function mailMove($msglist, $mailbox, $options = 0) {
		return \imap_mail_move($this->handler, $msglist, $mailbox, $options);
	}

	function mailBoxMsgInfo() {
		return imap_mailboxmsginfo($this->handler);
	}

	function msgNo($uid) {
		return \imap_msgno($this->handler, $uid);
	}

	function numMsg() {
		return \imap_num_msg($this->handler);
	}

	function numRecent() {
		return \imap_num_recent($this->handler);
	}

	function ping() {
		return \imap_ping($this->handler);
	}

	function renameMailbox($old_name, $new_name) {
		return \imap_renamemailbox($this->handler, $old_name, $new_name);
	}

	function reopen($mailbox, $options = 0, $n_retries = 0) {
		return \imap_reopen($this->handler, $mailbox, $options, $n_retries);
	}

	function saveBody($file, $msg_number, $part_number = '', $options = 0) {
		return \imap_savebody($this->handler, $file, $msg_number, $part_number, $options);
	}

	function search($criteria, $options = SE_FREE, $charset = NIL) {
		return \imap_search($this->handler, $criteria, $options, $charset);
	}

	function setQuota($quota_root, $quota_limit) {
		return \imap_set_quota($this->handler, $quota_root, $quota_limit);
	}

	function setAcl($mailbox, $id, $rights) {
		return \imap_setacl($this->handler, $mailbox, $id, $rights);
	}

	function setFlagFull($sequence, $flag, $options = 0) {
		return \imap_setflag_full($this->handler, $sequence, $flag, $options);
	}

	function sort($criteria, $reverse, $options = 0, $search_criteria = null, $charset = NIL) {
		return \imap_sort($this->handler, $criteria, $reverse, $options, $search_criteria, $charset);
	}

	function subscribe($mailbox) {
		return \imap_subscribe($this->handler, $mailbox);
	}

	function thread($options = SE_FREE) {
		return \imap_thread($this->handler, $options);
	}

	function uid($msg_number) {
		return \imap_uid($this->handler, $msg_number);
	}

	function undelete($msg_number, $flags = 0) {
		return \imap_undelete($this->handler, $msg_number, $flags);
	}

	function unsubscribe($mailbox) {
		return \imap_unsubscribe($this->handler, $mailbox);
	}

//</editor-fold>

	function getMailBox($mailbox) {
		return new ImapMailbox($this->handler, (string) $mailbox);
	}
	
	function getMessage($msgNum,$options= 0){
		return new ImapMessage($this->handler, $msgNum, $options);
	}

}

//function 

class ImapMailBox extends Object {

	private $handler;
	private $name;

	function __construct($handler, $name) {
		$this->handler = $handler;
		$this->name = $name;
	}

	function rfc822WriteAddress($host, $personal) {
		return \imap_rfc822_write_address($this->name, $host, $personal);
	}

	function append($message, $options = null, \DateTime $internal_date = null) {
		if ($internal_date !== null) {
			$internal_date = $internal_date::format('d-M-Y H:i:s O');
		}
		return \imap_append($this->handler, $this->name, $message, $options, $internal_date);
	}

	function create() {
		return \imap_createmailbox($this->handler, $this->name);
	}

	function delete() {
		return \imap_deletemailbox($this->handler, $this->name);
	}

	function getAcl() {
		return \imap_getacl($this->handler, $this->name);
	}

	function mailCopy($msglist, $options = 0) {
		return \imap_mail_copy($this->handler, $msglist, $this->name, $options);
	}

	function mailMove($msglist, $options = 0) {
		return \imap_mail_move($this->handler, $msglist, $this->name, $options);
	}

	function reopen($options = 0, $n_retries = 0) {
		return \imap_reopen($this->handler, $this->name, $options, $n_retries);
	}

	function setAcl($id, $rights) {
		return \imap_setacl($this->handler, $this->name, $id, $rights);
	}

	function subscribe() {
		return \imap_subscribe($this->handler, $this->name);
	}

	function unsubscribe() {
		return \imap_unsubscribe($this->handler, $this->name);
	}

}

class ImapMessage extends ReadableObject {

	private $handler;
	protected $number;
	protected $options;
	
	function __construct($handler,$number,$options){
		$this->handler = $handler;
		$this->number = $number;
		$this->options = $options;
	}

	function body() {
		return \imap_body($this->handler, $this->number, $this->options);
	}

	function bodyStruct($section) {
		return \imap_bodystruct($this->handler, $this->number, $section, $this->options);
	}

	function delete() {
		return \imap_delete($this->handler, $this->number, $this->options);
	}

	function fetchBody($section) {
		return \imap_fetchbody($this->handler, $this->number, $section, $this->options);
	}

	function fetchHeader() {
		return \imap_fetchheader($this->handler, $this->number, $this->options);
	}

	function fetchStructure() {
		return \imap_fetchstructure($this->handler, $this->number, $this->options);
	}

	function fetchText() {
		return \imap_fetchText($this->handler, $this->number, $this->options);
	}

	function saveBody($file, $part_number = '') {
		return \imap_savebody($this->handler, $file, $this->msg_number, $part_number, $this->options);
	}
	
	function uid() {
		if ($this->options & FT_UID) return $this->number;
		return \imap_uid($this->handler, $this->number);
	}
	
	function msgno() {
		if (!($this->options & FT_UID) ) return $this->number;
		return \imap_msgno($this->handler, $this->number);
	}

	function undelete() {
		return \imap_undelete($this->handler, $this->number, $this->options);
	}

}