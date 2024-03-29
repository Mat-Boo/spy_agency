<?php

namespace App\Class;
use Dotenv\Dotenv;
use PDO;

class Connection
{
    public function getPdo(): PDO
    {
        
        $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
        $dotenv->load();

        if ($_ENV['APP_ENV'] === 'prod') {
            $url = parse_url($_ENV["PROD_DATABASE_URL"]);
        } elseif ($_ENV['APP_ENV'] === 'dev') {
            $url = parse_url($_ENV["LOCAL_DATABASE_URL"]);
        }
        
        $host = $url["host"];
        $db_username = $url["user"];
        $db_password = $url["pass"];
        $db = substr($url["path"],1);
        return new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $db_username, $db_password);
       
    }
}