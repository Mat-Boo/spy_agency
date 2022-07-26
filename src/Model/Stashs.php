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
                'SELECT Stash.id_code_stash, address, country, type, id_code_mission
                FROM Stash
                INNER JOIN MissionStash ON Stash.id_code_stash = MissionStash.id_code_stash'
            );
        }
        $stashs = [];
        while ($stash = $stmt->fetchObject(Stash::class)) {
            $stashs[] = $stash;
        }
        return $stashs;
    }

    public function hydrateMissions(array $missions, array $stashs): void
    {
        foreach($missions as $mission) {
            foreach($stashs as $stash) {
                if ($mission->getId_code_mission() === $stash->getId_code_mission()) {
                    $mission->addStashs($stash);
                }
            }
        }
    }
}