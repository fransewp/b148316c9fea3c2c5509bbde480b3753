<?php

// DEFINE DATABASE CONNECTION
$dsn = 'pgsql:host='.$_ENV["DB_HOST"].';port='.$_ENV["DB_PORT"].';dbname='.$_ENV["DB_DATABASE"].'';
$username = $_ENV["DB_USERNAME"];
$password = $_ENV["DB_PASSWORD"];

// AUTOLOADER
require_once(__DIR__ . '/../../vendor/bshaffer/oauth2-server-php/src/OAuth2/Autoloader.php');

OAuth2\Autoloader::register();

$storage = new OAuth2\Storage\Pdo(array('dsn' => $dsn, 'username' => $username, 'password' => $password));

$server = new OAuth2\Server($storage);

$server->addGrantType(new OAuth2\GrantType\ClientCredentials($storage));

$server->addGrantType(new OAuth2\GrantType\AuthorizationCode($storage));

?>