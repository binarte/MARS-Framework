<?php

namespace MARSFW;

require '../start.inc.php';

$prot = explode('/',$_SERVER['SERVER_PROTOCOL']);
echo '<pre>';
var_dump ($_GET,$_POST);
echo '</pre>';

$oa = new API\Client\OAuth2('https://www.deviantart.com/oauth2/draft15/',149,'e641092e669e8b9d8486ca20310bca4e');

$oa->redirect=$prot[0].'://'.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'];
$oa->grantType = 'authorization_code';
echo '<a href="',$oa->get_authUrl(),'">yuke!</a>';

$oa->code = $_GET['code'];
try {
var_dump (($oa->get_accessToken() ) );
}
catch (Exception $ex){
	var_dump ($ex);
}