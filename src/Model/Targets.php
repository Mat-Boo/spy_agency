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
                'SELECT Target.code_name_target, firstname, lastname, birthdate, nationality, id_code_mission
                FROM Target
                INNER JOIN MissionTarget ON Target.code_name_target = MissionTarget.code_name_target'
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
                if ($mission->getId_code_mission() === $target->getId_code_mission()) {
                    $mission->addTargets($target);
                }
            }
        }
    }
}