<?php

namespace App\Config;
use PDO;
use PDOException;

class Database
{
    private $dbhost = '';
    private $dbname = '';
    private $dbuser = '';
    private $dbpass = '';
    
    private $error;
    public $db;

    public function __construct()
    {
        $this->dbhost = $_ENV['DB_HOST'];
        $this->dbname = $_ENV['DB_DATABASE'];
        $this->dbuser = $_ENV['DB_USERNAME'];
        $this->dbpass = $_ENV['DB_PASSWORD'];

        try {
            $this->db = new PDO("pgsql:host=$this->dbhost;dbname=$this->dbname", $this->dbuser, $this->dbpass);
        } catch(PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }
}
