<?php
// Relies on the oAuth2 library by Pierrick Charron: https://github.com/adoy/PHP-OAuth2/
// git checkout https://github.com/adoy/PHP-OAuth2.git /path/to/this/script/OAuth2
function __autoload($classname) {
    $name = preg_split('/\\\\/', $classname . '.php', -1, PREG_SPLIT_NO_EMPTY);
    require_once(implode(DIRECTORY_SEPARATOR, $name));
}

$data = parse_ini_file('../apps.ini',true);

define('CLIENT_ID',$data['da']['id']); // OAuth 2.0 client_id
define('CLIENT_SECRET',$data['da']['secret']); // OAuth 2.0 client_secret

const REDIRECT_URI = 'http://localhost:81/tests/DA/DOA.php';
const APPNAME = 'MARS';

const AUTHORIZATION_ENDPOINT = 'https://www.deviantart.com/oauth2/draft15/authorize';
const TOKEN_ENDPOINT = 'https://www.deviantart.com/oauth2/draft15/token';
const SUBMIT_API = "https://www.deviantart.com/api/draft15/stash/submit";
const USER_API = "https://www.deviantart.com/api/draft15/user/whoami";

#const AUTHORIZATION_ENDPOINT = 'http://localhost/info.php';
#const TOKEN_ENDPOINT = 'http://localhost/info.php';
#const SUBMIT_API = 'http://localhost/info.php';

try {
  $client = new OAuth2\Client(CLIENT_ID, CLIENT_SECRET, OAuth2\Client::AUTH_TYPE_AUTHORIZATION_BASIC);
      if (!isset($_REQUEST['code'])) {
            $params = array('redirect_uri' => REDIRECT_URI);
            $auth_url = $client->getAuthenticationUrl(AUTHORIZATION_ENDPOINT, REDIRECT_URI);
            header('Location: ' . $auth_url);
            die('Redirecting ...');
      } else {
            $params = array('code' => $_REQUEST['code'], 'redirect_uri' => REDIRECT_URI);
            $response = $client->getAccessToken(TOKEN_ENDPOINT, OAuth2\Client::GRANT_TYPE_AUTH_CODE, $params);
			var_dump ($response);
            $val = ($response['result']);

            if (!$val) {
                  throw new Exception('No valid JSON response returned');
            }

            if (!$val['access_token']) {
                  throw new Exception("No access token returned: ".$val['error_description']);
            }

            $client->setAccessToken($val['access_token']);

            $client->setAccessTokenType(OAuth2\Client::ACCESS_TOKEN_OAUTH);

			 $response = $client->fetch(
                    USER_API,
                    array(                ),
                  OAuth2\Client::HTTP_METHOD_POST
            );
			 var_dump($response);die;
						
            $response = $client->fetch(
                    SUBMIT_API,
                    array(
                        'title' => 'Fella Sample Image',
                        'artist_comments' => 'Fella Sample Image',
                        'keywords' => 'fella sample image',
                        'folder' => APPNAME,
                        'file' => "@fella.png"
                  ),
                  OAuth2\Client::HTTP_METHOD_POST
            );

			var_dump ($response);
            $result = ($response['result']);

            if (!$result) {
                  throw new Exception('No valid JSON response returned');
            }

            if ($result['status'] == 'success') {
                  print "Great Success! <a href=\"http://sta.sh/1{$result['stashid']}\" target=\"_blank\">Stash ID {$result->stashid}</a>";
                  print "<br>Your submission is in the folder: {$result['folderid']}";
            } else {
                  throw new Exception($result['error_description']);
            }
      }
} catch (Exception $e) {
      print "Fatal Error: ".$e->getMessage();
}
?>