<?php

namespace App\Model;

use App\Model\Exception\NotFoundException;
use Exception;
use PDO;

class Missions
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getMissionsList(): array
    {
        if (!is_null($this->pdo)) {
            $stmt = $this->pdo->query(
                'SELECT Mission.id_mission, code_name, title, description, country, type,
                status, start_date, end_date, Speciality.name AS speciality
                FROM Mission
                INNER JOIN Speciality ON Mission.id_speciality = Speciality.id_speciality
                ORDER BY start_date, title;'
            );
        }
        $missions = [];
        while ($mission = $stmt->fetchObject(Mission::class)) {
            $missions[] = $mission;
        }
        return $missions;
    }

    public function filterMissions(array $filterConditions): array
    {
        if (!is_null($this->pdo)) {
            $stmt = $this->pdo->query( 
                "SELECT Mission.id_mission, code_name, title, description, country, type,
                status, start_date, end_date, Speciality.name AS speciality
                FROM Mission
                INNER JOIN Speciality ON Mission.id_speciality = Speciality.id_speciality"
                . implode('', $filterConditions)
            );
        }
        $missions = [];
        while ($mission = $stmt->fetchObject(Mission::class)) {
            $missions[] = $mission;
        }
        return $missions;
    }

    public function findMission(int $idMission): Mission
    {
        $query = $this->pdo->prepare(
            'SELECT Mission.id_mission, code_name, title, description, country, type,
            status, start_date, end_date, Speciality.name AS speciality
            FROM Mission
            INNER JOIN Speciality ON Mission.id_speciality = Speciality.id_speciality
            WHERE id_mission = :id_mission');
        $query->execute(['id_mission' => $idMission]);
        $foundMission = $query->fetchObject(Mission::class);
        if ($foundMission === false) {
            throw new NotFoundException('Mission', $idMission);
        }
        return $foundMission;
    }

    public function updateMission(array $mission, int $id_mission): void
    {
        $query = $this->pdo->prepare(
            "UPDATE Mission SET 
            code_name = :code_name,
            title = :title,
            description = :description,
            country = :country,
            type = :type,
            status = :status,
            start_date = :start_date,
            end_date = :end_date,
            id_speciality = :id_speciality
            WHERE id_mission = :id_mission
        ");
        $updateMission = $query->execute(
            [
                'code_name' => $mission['codeNameMission'],
                'title' => $mission['titleMission'],
                'description' => $mission['descriptionMission'],
                'country' => $mission['countryMission'],
                'type' => $mission['typeMission'],
                'status' => $mission['status'],
                'start_date' => $mission['startDateMission'],
                'end_date' => $mission['endDateMission'],
                'id_speciality' => $mission['specialityMission'],
                'id_mission' => $id_mission
            ]
        );
        if ($updateMission === false) {
            throw new Exception("Impossible de modifier l'enregistrement {$id_mission} dans la table 'Mission'");
        }
    }

    public function filterMissionsForSpeciality(array $filterOptions): array
    {
        if (!is_null($this->pdo)) {
            $missionFilter = isset($filterOptions['missionsFilter']) ? " WHERE id_mission IN (" . implode(",", $filterOptions['missionsFilter']) . ")" : '';

            $stmt = $this->pdo->query(
                "SELECT id_speciality
                FROM Mission"
                . $missionFilter
            );
            $specialityIdsFromMissions = [];
            while ($specialityIdsFromMission = $stmt->fetchColumn()) {
                $specialityIdsFromMissions[] = $specialityIdsFromMission;
            }
        }
        return $specialityIdsFromMissions;
    }

    public function hydrateSpecialities(array $specialities): void
    {
        foreach($specialities as $speciality) {
            foreach($this->getMissionsList() as $mission) {
                if ($speciality->getName() === $mission->getSpeciality()) {
                    $speciality->addMissions($mission);
                }
            }
        }
    }

    public function deleteMission(int $id_mission): void
    {
        $query = $this->pdo->prepare(
            "DELETE FROM Mission
            WHERE id_mission = :id_mission");
        $deleteMission = $query->execute(['id_mission' => $id_mission]);
        if ($deleteMission === false) {
            throw new Exception("Impossible de supprimer l'enregistrement $id_mission dans la table 'Mission'");
        }
    }

    public function createMission(array $newMission)
    {
        $query = $this->pdo->prepare(
            "INSERT INTO Mission SET 
            code_name = :code_name,
            title = :title,
            description = :description,
            country = :country,
            type = :type,
            status = :status,
            start_date = :start_date,
            end_date = :end_date,
            id_speciality = :id_speciality
        ");
        $createMission = $query->execute(
            [
                'code_name' => $newMission['codeNameMission'],
                'title' => $newMission['titleMission'],
                'description' => $newMission['descriptionMission'],
                'country' => $newMission['countryMission'],
                'type' => $newMission['typeMission'],
                'status' => $newMission['status'],
                'start_date' => $newMission['startDateMission'],
                'end_date' => $newMission['endDateMission'],
                'id_speciality' => $newMission['specialityMission'],
                ]
            );
            if ($createMission === false) {
                throw new Exception("Impossible de créer le nouvel enregistrement {$newMission['codeNameMission']} dans la table 'Mission'");
            }
        return $this->pdo->lastInsertId();
    }
}