<?php

namespace App\Controller;

class BaseController
{
    public $db;
    public function __construct()
    {
        $this->connection();
    }

    // CALL CONNECTION DATABASE
    public function connection()
    {
        $connection = new \App\Controller\Database();
        $this->db = $connection->initiate();
        return $this->db;
    }
    
    // CALL MIDDLEWARE - CHECK IF BEARER TOKEN IS VALID
    public function middleware()
    {
        require_once __DIR__ . '/MiddlewareController.php';
    }
}
