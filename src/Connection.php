<?php

namespace App;

use PDO;

class Connection
{
    public function getPdo(): PDO
    {
        return new PDO('mysql:host=localhost;dbname=spy_agency;charset=utf8mb4', 'root');
    }
}