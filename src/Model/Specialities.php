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
                FROM Speciality'
            );
        }
        $specialities = [];
        while ($speciality = $stmt->fetchObject(Speciality::class)) {
            $specialities[] = $speciality;
        }
        
        usort($specialities, function ($a, $b)
        {
            if ($a->getName() == $b->getName()) {
                return 0;
            } else {
                return ($a->getName() < $b->getName()) ? -1 : 1;
            }
        });

        return $specialities;
    }

/*     public function getNames()
    {
        $specialities = [];
        foreach($this->getSpecialitiesList() as $speciality) {
            if (!in_array($speciality->getName(), $specialities)) {
                $specialities[] = $speciality->getName();
            }
        }

        usort($specialities, function ($a, $b)
        {
            if ($a == $b) {
                return 0;
            } else {
                return ($a < $b) ? -1 : 1;
            }
        });

        return $specialities;
    } */
}