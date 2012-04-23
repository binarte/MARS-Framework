<?php

namespace MARSFW;

require '../start.inc.php';


$ah = new AcceptHeader('en-us,ja,es-mx',  AcceptHeader::LANGUAGE);

echo $ah->find('en');    //en-us
echo $ah->find('ja-jp'); //ja
