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
                'SELECT Stash.id_stash, address, country, type, id_mission
                FROM Stash
                INNER JOIN MissionStash ON Stash.id_stash = MissionStash.id_stash'
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
                if ($mission->getId_mission() === $stash->getId_mission()) {
                    $mission->addStashs($stash);
                }
            }
        }
    }

    public function getTypes()
    {
        $types = [];
        foreach($this->getStashsList() as $stash) {
            if (!in_array($stash->getType(), $types)) {
                $types[] = $stash->getType();
            }
        }

        usort($types, function ($a, $b)
        {
            if ($a == $b) {
                return 0;
            } else {
                return ($a < $b) ? -1 : 1;
            }
        });

        return $types;
    }

    public function convertToStringList(array $arrayToConvert, string $formItem): string
    {
        $newString = '';
        if ($formItem === 'checkbox') {
            foreach($arrayToConvert as $key => $item) {
                $newString .= "'" . str_replace('_', ' ', $key) . "'" . ",";
            }
        } else if ($formItem === 'select') {
            foreach($arrayToConvert as $item) {
                $newString .= "'" . $item . "'" . ",";
            }
        }
        return $newString = substr($newString, 0, -1);
    }

    public function filterStashs(array $filterOptions): array
    {
        if (!is_null($this->pdo)) {
            $stashFilter = isset($filterOptions['stashFilter']) ? " WHERE type IN (" . $this->convertToStringList($filterOptions['stashFilter'], 'select') . ")" : '';
            $stmt = $this->pdo->query(
                "SELECT id_mission
                FROM MissionStash
                INNER JOIN Stash ON MissionStash.id_stash = Stash.id_stash"
                .$stashFilter
            );
            $missionIdsFromStashs = [];
            while ($missionIdFromStash = $stmt->fetchColumn()) {
                $missionIdsFromStashs[] = $missionIdFromStash;
            }
        }
        return $missionIdsFromStashs;
    }
}