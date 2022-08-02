<?php

namespace App\model;
use PDO;

class Specialities
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getSpecialitiesList()
    {
        if (!is_null($this->pdo)) {
            $stmt = $this->pdo->query(
                'SELECT *
                FROM Speciality
                ORDER BY name'
            );
        }
        $specialities = [];
        while ($speciality = $stmt->fetchObject(Speciality::class)) {
            $specialities[] = $speciality;
        }
        return $specialities;
    }
}