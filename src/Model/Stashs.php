<?php

namespace App\model;
use PDO;

class Stashs
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getStashsList()
    {
        if (!is_null($this->pdo)) {
            $stmt = $this->pdo->query(
                'SELECT Stash.id_stash, address, country, type
                FROM Stash
                ORDER BY country, type'
            );
        }
        $stashs = [];
        while ($stash = $stmt->fetchObject(Stash::class)) {
            $stashs[] = $stash;
        }
        return $stashs;
    }
}