<?php

require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__. '/ServerController.php');

header('Content-Type: application/json; charset=UTF-8');

//  CHECK IF USER HAVE AUTH BEARER TOKEN
if (!$server->verifyResourceRequest(OAuth2\Request::createFromGlobals())) {
    echo json_encode(array('code' => -1, 'message' => 'You are unauthorize'));
    exit;
}

?>