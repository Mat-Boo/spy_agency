<?php

namespace App\model;
use PDO;

class MissionsPersons
{
    private $pdo;
    private $personItem;

    public function __construct(PDO $pdo, string $personItem)
    {   
        $this->pdo = $pdo;
        $this->personItem = $personItem;
    }

    public function getMissionsPersons(): array
    {
        if (!is_null($this->pdo)) {
            $stmt = $this->pdo->query(
                "SELECT id_mission, id
                FROM Mission" . $this->personItem
            );
        }
        $missionsPersons = [];
        while ($missionPerson = $stmt->fetchObject(MissionPerson::class)) {
            $missionsPersons[] = $missionPerson;
        }
        return $missionsPersons;
    }

    public function hydrateMissions(array $missions, array $persons): void
    {
        foreach($missions as $mission) {
            foreach($persons as $person) {
                    foreach($this->getMissionsPersons() as $missionPerson) {
                    if ($mission->getId_mission() === $missionPerson->getId_mission()) {
                        if ($person->getId() === $missionPerson->getId()) {
                            $mission->addPersons($person, $this->personItem);
                        }
                    }
                }
            }
        }
    }

    public function filterPersons(array $filterOptions): array
    {
        if (!is_null($this->pdo)) {
            $personFilter = isset($filterOptions[$this->personItem . 'Filter']) ? " WHERE id IN (" . implode(",", $filterOptions[$this->personItem . 'Filter']) . ")" : '';

            $stmt = $this->pdo->query(
                "SELECT id_mission
                FROM Mission" . $this->personItem
                . $personFilter
            );
            ${'missionIdsFrom' . $this->personItem . 's'} = [];
            while (${'missionIdsFrom' . $this->personItem} = $stmt->fetchColumn()) {
                ${'missionIdsFrom' . $this->personItem . 's'}[] = ${'missionIdsFrom' . $this->personItem};
            }
        }
        return ${'missionIdsFrom' . $this->personItem . 's'};
    }
}