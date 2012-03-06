<?php

namespace MARSFW;

require '../start.inc.php';

$prot = explode('/',$_SERVER['SERVER_PROTOCOL']);
echo '<pre>';
var_dump ($_GET,$_POST);
echo '</pre>';

$oa = new API\Requests\OAuth2('https://www.deviantart.com/oauth2/draft15/authorize', '$tokenEndpoint',149,'********************************');

$oa->redirect=$prot[0].'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
echo '<a href="',$oa->authUrl,'">yuke!</a>';