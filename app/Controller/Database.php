<?php

namespace App\Controller;
use PDO;

class Database
{
    public $db;

    public function initiate()
    {
        $dbhost = $_ENV['DB_HOST'];
        $dbname = $_ENV['DB_DATABASE'];
        $dbuser = $_ENV['DB_USERNAME'];
        $dbpass = $_ENV['DB_PASSWORD'];

        $this->db = new PDO("pgsql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
        return $this->db;
    }
}
