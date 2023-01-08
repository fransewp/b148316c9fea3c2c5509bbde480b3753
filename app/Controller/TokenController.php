<?php

require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__. '/ServerController.php');

// GENERATE TOKEN
$server->handleTokenRequest(OAuth2\Request::createFromGlobals())->send();

?>