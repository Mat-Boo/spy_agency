<?php

namespace App\model;
use PDO;

class Targets
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getTargetsList()
    {
        if (!is_null($this->pdo)) {
            $stmt = $this->pdo->query(
                'SELECT Target.id_target, firstname, lastname, birthdate, nationality, id_mission
                FROM Target
                INNER JOIN MissionTarget ON Target.id_target = MissionTarget.id_target'
            );
        }
        $targets = [];
        while ($target = $stmt->fetchObject(Target::class)) {
            $targets[] = $target;
        }
        return $targets;
    }

    public function hydrateMissions(array $missions, array $targets): void
    {
        foreach($missions as $mission) {
            foreach($targets as $target) {
                if ($mission->getId_mission() === $target->getId_mission()) {
                    $mission->addTargets($target);
                }
            }
        }
    }

    public function getTargets()
    {
        if (!is_null($this->pdo)) {
            $stmt = $this->pdo->query("SELECT id_target, firstname, lastname, birthdate, nationality FROM Target ORDER BY lastname");
            $targets = [];
            while ($target = $stmt->fetchObject(Target::class)) {
                $targets[] = $target;
            }
        }
        return $targets;
    }

    public function filterTargets(array $filterOptions): array
    {
        if (!is_null($this->pdo)) {
            $targetFilter = isset($filterOptions['targetFilter']) ? " WHERE id_target IN (" . implode(",", $filterOptions['targetFilter']) . ")" : '';

            $stmt = $this->pdo->query(
                "SELECT id_mission
                FROM MissionTarget"
                .$targetFilter
            );
            $missionIdsFromTargets = [];
            while ($missionIdFromTarget = $stmt->fetchColumn()) {
                $missionIdsFromTargets[] = $missionIdFromTarget;
            }
        }
        return $missionIdsFromTargets;
    }
}