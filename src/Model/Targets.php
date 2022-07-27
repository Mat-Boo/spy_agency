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

    public function getNames()
    {
        $names = [];
        foreach($this->getTargetsList() as $target) {
            if (!in_array($target->getfirstname() . ' ' . $target->getlastname(), $names)) {
                $names[] = $target->getfirstname() . ' ' . $target->getlastname();
            }
        }

        usort($names, function ($a, $b)
        {
            if ($a == $b) {
                return 0;
            } else {
                return ($a < $b) ? -1 : 1;
            }
        });

        return $names;
    }
}