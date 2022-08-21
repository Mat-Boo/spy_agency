<?php

namespace App\Model;

use Exception;
use PDO;

class MissionsStashs
{
    private $pdo;

    public function __construct(PDO $pdo)
    {   
        $this->pdo = $pdo;
    }

    public function getMissionsStashsList(): array
    {
        $sql = "SELECT * FROM MissionStash";

        $missionsStashs = $this->pdo->query($sql, PDO::FETCH_CLASS, MissionStash::class)->fetchAll();
        return $missionsStashs;
    }

    public function hydrateMissions(array $missions, array $stashs): void
    {
        foreach($missions as $mission) {
            foreach($stashs as $stash) {
                    foreach($this->getMissionsStashsList() as $missionStash) {
                    if ($mission->getId_mission() === $missionStash->getId_mission()) {
                        if ($stash->getId_stash() === $missionStash->getId_stash()) {
                            $mission->addStashs($stash);
                        }
                    }
                }
            }
        }
    }

    public function filterStashs(array $filterOptions): array
    {              
        if (isset($filterOptions['stashFilter'])) {
            $sql = "SELECT id_mission FROM MissionStash WHERE id_stash IN (" . implode(",", $filterOptions['stashFilter']) . ")";
        } else {
            $sql = "SELECT id_mission FROM MissionStash";
        }

        $missionIdsFromStashs = $this->pdo->query($sql, PDO::FETCH_COLUMN, 0)->fetchAll();

        if (empty($missionIdsFromStashs)) {
            $missionIdsFromStashs = [0];
        }
        return $missionIdsFromStashs;
    }

    public function updateMissionsStashs(array $mission, int $id_mission)
    {
        $this->pdo->exec("DELETE FROM MissionStash WHERE id_mission = " . $id_mission);

        $query = $this->pdo->prepare(
            "INSERT INTO Missionstash SET 
            id_mission = :id_mission,
            id_stash = :id_stash
        ");

        foreach($mission['stashMission'] as $id_stash) {
            $updateMissionStashs[] = $query->execute(
                [
                    'id_mission' => $id_mission,
                    'id_stash' => $id_stash
                ]
            );
        }

        if ($updateMissionStashs === false) {
            throw new Exception("Impossible de modifier l'enregistrement {$id_mission} dans la table 'MissionStash'");
        }
    }

    public function filterMissions(array $filterOptions): array
    {
        if (!is_null($this->pdo)) {
            $MissionFilter = isset($filterOptions['missionsFilter']) ? " WHERE id_mission IN (" . implode(",", $filterOptions['missionsFilter']) . ")" : '';

            $stmt = $this->pdo->query(
                "SELECT id_stash
                FROM MissionStash"
                . $MissionFilter
            );
            $stashIdsFromMissions = [];
            while ($stashIdsFromMission = $stmt->fetchColumn()) {
                $stashIdsFromMissions[] = $stashIdsFromMission;
            }
        }
        return $stashIdsFromMissions;
    }

    public function hydrateStashs(array $stashs, array $missions): void
    {
        foreach($stashs as $stash) {
            foreach($missions as $mission) {
                    foreach($this->getMissionsStashsList() as $missionStash) {
                    if ($stash->getId_stash() === $missionStash->getId_stash()) {
                        if ($mission->getId_mission() === $missionStash->getId_mission()) {
                            $stash->addMissions($mission);
                        }
                    }
                }
            }
        }
    }

    public function deleteMissionStashFromStash(int $id_stash): void
    {
        $query = $this->pdo->prepare(
            "DELETE FROM MissionStash 
            WHERE id_stash = :id_stash");
        $deleteMissionStash = $query->execute(['id_stash' => $id_stash]);
        if ($deleteMissionStash === false) {
            throw new Exception("Impossible de supprimer l'enregistrement $id_stash dans la table 'MissionStash'");
        }
    }

    public function deleteMissionStashFromMission(int $id_mission): void
    {
        $query = $this->pdo->prepare(
            "DELETE FROM MissionStash 
            WHERE id_mission = :id_mission");
        $deleteMissionStash = $query->execute(['id_mission' => $id_mission]);
        if ($deleteMissionStash === false) {
            throw new Exception("Impossible de supprimer l'enregistrement $id_mission dans la table 'MissionStash'");
        }
    }

    public function createMissionStash(array $newMissionStash, int $newId_mission): void
    {
        $query = $this->pdo->prepare(
            "INSERT INTO MissionStash SET 
            id_mission = :id_mission,
            id_stash = :id_stash
        ");
        foreach($newMissionStash['stashMission'] as $idStash) {
            $createMissionStash = $query->execute(
                [
                    'id_mission' => $newId_mission,
                    'id_stash' => $idStash
                ]
            );
            if ($createMissionStash === false) {
                throw new Exception("Impossible de créer le nouvel enregistrement " . $newId_mission . " - " . $idStash . " dans la table 'MissionStash'");
            }

        }
    }
}