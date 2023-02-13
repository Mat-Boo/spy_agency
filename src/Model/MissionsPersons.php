<?php

namespace App\Model;

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
        $sql = "SELECT * FROM mission" . $this->personItem;

        $missionsPersons = $this->pdo->query($sql, PDO::FETCH_CLASS, MissionPerson::class)->fetchAll();

        return $missionsPersons;
    }

    public function hydrateMissions(array $missions, array $persons): void
    {
        $missionsPersons = $this->getMissionsPersonsLists();

        foreach($missions as $mission) {
            foreach($persons as $person) {
                    foreach($missionsPersons as $missionPerson) {
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
        $missionsPersons = $this->getMissionsPersonsLists();

        foreach($persons as $person) {
            foreach($missions as $mission) {
                    foreach($missionsPersons as $missionPerson) {
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
        if (isset($filterOptions[$this->personItem . 'Filter'])) {
            $sql = "SELECT id_mission FROM mission" . $this->personItem . " WHERE id IN (" . implode(",", $filterOptions[$this->personItem . 'Filter']) . ")";
        } else {
            $sql = "SELECT id_mission FROM mission" . $this->personItem;
        }
       
        ${'missionIdsFrom' . $this->personItem . 's'} = $this->pdo->query($sql, PDO::FETCH_COLUMN, 0)->fetchAll();

        if (empty(${'missionIdsFrom' . $this->personItem . 's'})) {
            ${'missionIdsFrom' . $this->personItem . 's'} = [0];
        }

        return ${'missionIdsFrom' . $this->personItem . 's'};
    }

    public function filterMissions(array $filterOptions): array
    {       
        if (isset($filterOptions['missionsFilter'])) {
            $sql = "SELECT id FROM mission" . ucfirst($this->personItem) . " WHERE id_mission IN (" . implode(",", $filterOptions['missionsFilter']) . ")";
        } else {
            $sql = "SELECT id FROM mission" . ucfirst($this->personItem);
        }

        $personIdsFromMissions = $this->pdo->query($sql, PDO::FETCH_COLUMN, 0)->fetchAll();

        return $personIdsFromMissions;
    }

    public function updateMissionsPersons(array $mission, int $id_mission)
    {
            $this->pdo->exec("DELETE FROM mission" . ucfirst($this->personItem) . " WHERE id_mission = " . $id_mission);
    
            $query = $this->pdo->prepare(
                "INSERT INTO mission" . ucfirst($this->personItem) . " SET 
                id_mission = :id_mission,
                id = :id
            ");
    
            foreach($mission[$this->personItem . 'Mission'] as $id) {
                'updateMission' . $this->personItem = $query->execute(
                    [
                        'id_mission' => $id_mission,
                        'id' => $id
                    ]
                );
                if ('updateMission' . $this->personItem === false) {
                    throw new Exception("Impossible de modifier l'enregistrement {$id_mission} dans la table 'Mission" . ucfirst($this->personItem) . "'");
                }
            }
    }

     public function deleteMissionPersonFromPerson($id): void
     {
        $query = $this->pdo->prepare(
            "DELETE FROM mission" . ucfirst($this->personItem) .
            " WHERE id = :id");
        $deleteMissionAgent = $query->execute(['id' => $id]);
        if ($deleteMissionAgent === false) {
            throw new Exception("Impossible de supprimer l'enregistrement $id dans la table 'Mission" . $this->personItem . "'");
        }
     }

     public function deleteMissionPersonFromMission($id_mission): void
     {
        $query = $this->pdo->prepare(
            "DELETE FROM mission" . ucfirst($this->personItem) .
            " WHERE id_mission = :id_mission");
        $deleteMissionAgent = $query->execute(['id_mission' => $id_mission]);
        if ($deleteMissionAgent === false) {
            throw new Exception("Impossible de supprimer l'enregistrement $id_mission dans la table 'Mission" . $this->personItem . "'");
        }
     }

     public function createMissionPerson(array $newMissionPerson, int $newId_mission): void
    {
        $query = $this->pdo->prepare(
            "INSERT INTO mission" . ucfirst($this->personItem) . " SET 
            id_mission = :id_mission,
            id = :id
        ");
        foreach($newMissionPerson[$this->personItem . 'Mission'] as $idPerson) {
            $createMissionPerson = $query->execute(
                [
                    'id_mission' => $newId_mission,
                    'id' => $idPerson
                ]
            );
            if ($createMissionPerson === false) {
                throw new Exception("Impossible de créer le nouvel enregistrement " . $newId_mission . " - " . $idPerson . " dans la table 'Mission" . $this->personItem . "'");
            }

        }
    }
}