<?php

namespace App\model;

use Exception;
use PDO;

class MissionsStashs
{
    private $pdo;

    public function __construct(PDO $pdo)
    {   
        $this->pdo = $pdo;
    }

    public function getMissionsStashs(): array
    {
        if (!is_null($this->pdo)) {
            $stmt = $this->pdo->query(
                "SELECT id_mission, id_stash
                FROM MissionStash"
            );
        }
        $missionsStashs = [];
        while ($missionStash = $stmt->fetchObject(MissionStash::class)) {
            $missionsStashs[] = $missionStash;
        }
        return $missionsStashs;
    }

    public function hydrateMissions(array $missions, array $stashs): void
    {
        foreach($missions as $mission) {
            foreach($stashs as $stash) {
                    foreach($this->getMissionsStashs() as $missionStash) {
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
        if (!is_null($this->pdo)) {
            $stashFilter = isset($filterOptions['stashFilter']) ? " WHERE id_stash IN (" . implode(",", $filterOptions['stashFilter']) . ")" : '';

            $stmt = $this->pdo->query(
                "SELECT id_mission
                FROM MissionStash"
                . $stashFilter
            );
            $missionIdsFromStashs = [];
            while ($missionIdsFromStash = $stmt->fetchColumn()) {
                $missionIdsFromStashs[] = $missionIdsFromStash;
            }
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
}