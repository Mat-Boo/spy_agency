<?php

namespace App\model;

use Exception;
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

    public function getMissionsPersonsLists(): array
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
                    foreach($this->getMissionsPersonsLists() as $missionPerson) {
                    if ($mission->getId_mission() === $missionPerson->getId_mission()) {
                        if ($person->getId() === $missionPerson->getId()) {
                            $mission->addPersons($person, $this->personItem);
                        }
                    }
                }
            }
        }
    }

    public function hydratePersons(array $persons, array $missions): void
    {
        foreach($persons as $person) {
            foreach($missions as $mission) {
                    foreach($this->getMissionsPersonsLists() as $missionPerson) {
                    if ($person->getId() === $missionPerson->getId()) {
                        if ($mission->getId_mission() === $missionPerson->getId_mission()) {
                            $person->addMissions($mission, $this->personItem);
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

    public function filterMissions(array $filterOptions): array
    {
        if (!is_null($this->pdo)) {
            $MissionFilter = isset($filterOptions['missionsFilter']) ? " WHERE id_mission IN (" . implode(",", $filterOptions['missionsFilter']) . ")" : '';

            $stmt = $this->pdo->query(
                "SELECT id
                FROM Mission" . ucfirst($this->personItem)
                . $MissionFilter
            );
            $personIdsFromMissions = [];
            while ($personIdsFromMission = $stmt->fetchColumn()) {
                $personIdsFromMissions[] = $personIdsFromMission;
            }
        }
        return $personIdsFromMissions;
    }

    public function updateMissionsPersons(array $mission, int $id_mission)
    {
        foreach(['Agent', 'Contact', 'Target'] as $item) {
            $this->pdo->exec("DELETE FROM Mission" . $item . " WHERE id_mission = " . $id_mission);
    
            $query = $this->pdo->prepare(
                "INSERT INTO Mission" . $item . " SET 
                id_mission = :id_mission,
                id = :id
            ");
    
            foreach($mission[strtolower($item) . 'Mission'] as $id) {
                ${'updateMission' . $item}[] = $query->execute(
                    [
                        'id_mission' => $id_mission,
                        'id' => $id
                    ]
                );
            }
            if (${'updateMission' . $item} === false) {
                throw new Exception("Impossible de modifier l'enregistrement {$id_mission} dans la table 'Mission" . $item . "'");
            }
        }
    }
}