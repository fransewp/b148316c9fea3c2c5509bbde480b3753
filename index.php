<?php

require_once __DIR__ . '/vendor/autoload.php';
use App\Controller\OauthClientController;
use App\Controller\EmailController;
use App\Router;

$router = new Router();

// HELPER ROUTE FOR GET ALL OAUTH_CLIENT TABLE (WITHOUT MIDDLEWARE)
$router->get('/oauth', OauthClientController::class. '::retrieve');

// ROUTE FOR GENERATE TOKEN
$router->post('/token', function() {
	require_once __DIR__ . '/app/Controller/TokenController.php';
});

// ROUTE FOR SEND AND RETRIEVE ALL EMAIL
$router->get('/messages/emails', EmailController::class. '::retrieve');
$router->post('/messages/emails', EmailController::class. '::create');

// ROUTE FOR GET ALL EMAIL W/O MIDDLEWARE USING REDISH
$router->get('/messages/emails/redis', function() {
	require_once __DIR__ . '/app/Controller/WorkerController.php';
});

// 404 ROUTER
$router->addNotFoundHandler(function() {
	require_once __DIR__ . '/view/404.php';
});

// DEFINE DOTENV HERE
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// ROUTER RUN
$router->run();
