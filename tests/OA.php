<?php

namespace MARSFW;

require '../start.inc.php';

$oa = new API\Requests\OAuth2('$authEndpoint', '$tokenEndpoint', '$clientId', '$clientSecret');

$oa->redirect="REDIR";
echo $oa->authUrl;