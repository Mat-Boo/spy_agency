<?php

namespace App\Model;

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
            /* $stmt = $this->pdo->query(
                'SELECT Mission.id_mission, code_name, title, description, Mission.country, Mission.type,
                status, start_date, end_date, 
                Speciality.name AS speciality
                FROM Mission
                INNER JOIN Speciality ON Mission.id_speciality = Speciality.id_speciality
                ORDER BY start_date, title;'
            ); */
            $stmt = $this->pdo->query(
                "SELECT Mission.id_mission, code_name, title, description, Mission.country, Mission.type,
                status, start_date, end_date, 
                Speciality.name AS speciality
                FROM Mission
                INNER JOIN Speciality ON Mission.id_speciality = Speciality.id_speciality
                WHERE Mission.id_speciality IN (" . implode(",", [1,2,3,9]) . ");"
            );
            
        }
        $missions = [];
        while ($mission = $stmt->fetchObject(Mission::class)) {
            $missions[] = $mission;
        }
        return $missions;
    }

    public function getStatus(): array
    {
        $status = [];
        foreach($this->getMissionsList() as $mission) {
            if (!in_array($mission->getStatus(), $status)) {
                $status[] = $mission->getStatus();
            }
        }

        usort($status, function ($a, $b)
        {
            if ($a['status'] == $b['status']) {
                return 0;
            } else {
                return ($a['status'] < $b['status']) ? -1 : 1;
            }
        });

        return $status;
    }

    public function getTypes(): array
    {
        $types = [];
        foreach($this->getMissionsList() as $mission) {
            if (!in_array($mission->getType(), $types)) {
                $types[] = $mission->getType();
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

/*     public function filterMissions($filterOptions): array
    {
        if (!empty($filterOptions)) {
            $filterMissions = [];
            foreach($this->getMissionsList() as $mission) {
                if (
                    in_array($mission->getId_mission(), ($filterOptions['idMissionFilter'])) &&
                    in_array($mission->getType(), $filterOptions['typeMissionFilter'])
                ) 
                {
                    $filterMissions[] = $mission;
                }
            }
            return $filterMissions;
        }

        return $this->getMissionsList();
    } */
}