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

    public function convertToStringList(array $arrayToConvert, string $formItem): string
    {
        $newString = '';
        if ($formItem === 'checkbox') {
            foreach($arrayToConvert as $key => $item) {
                $newString .= "'" . str_replace('_', ' ', $key) . "'" . ",";
            }
        } else if ($formItem === 'select') {
            foreach($arrayToConvert as $item) {
                $newString .= "'" . $item . "'" . ",";
            }
        }
        return $newString = substr($newString, 0, -1);
    }

    public function filterMissions(array $filterOptions, array $missionIdsFromAgents, array $missionIdsFromContacts, array $missionIdsFromTargets, array $missionIdsFromStashs): array
    {
        if (!is_null($this->pdo)) {
            $stmt1 = $this->pdo->query("SELECT id_mission FROM Mission ORDER BY id_mission");
            $missionIds = [];
            while ($missionId = $stmt1->fetchColumn()) {
                $missionIds[] = $missionId;
            }

            $missionFilter = isset($filterOptions['idMissionFilter']) ? " WHERE Mission.id_mission IN (" . implode(",", $filterOptions['idMissionFilter']) . ")" : " WHERE Mission.id_mission IN (" . implode(",", $missionIds) . ")";
            $countryMissionFilter = isset($filterOptions['countryMissionFilter']) && strlen($filterOptions['countryMissionFilter']) > 0 ? " AND country = '" . $filterOptions['countryMissionFilter'] . "'" : '';
            $typeMissionFilter = isset($filterOptions['typeMissionFilter']) ? " AND type IN (" . $this->convertToStringList($filterOptions['typeMissionFilter'], 'select') . ")" : '';
            $specialityMissionFilter = isset($filterOptions['specialityMissionFilter']) ? " AND Mission.id_speciality IN (" . implode(",", $filterOptions['specialityMissionFilter']) . ")" : '';
            $statusMissionFilter = isset($filterOptions['statusMissionFilter']) ? " AND status IN (" . str_replace('_', ' ', $this->convertToStringList($filterOptions['statusMissionFilter'], 'checkbox')) . ")" : '';
            $startDateMissionFilter = isset($filterOptions['startDateMissionFilter']) && strlen($filterOptions['startDateMissionFilter']) > 0 ? " AND start_date >= '" . $filterOptions['startDateMissionFilter'] . "'" : '';
            $endDateMissionFilter = isset($filterOptions['endDateMissionFilter']) && strlen($filterOptions['endDateMissionFilter']) > 0 ? " AND end_date <= '" . $filterOptions['endDateMissionFilter'] . "'" : '';
            $agentFilter = isset($filterOptions['agentFilter']) ? " AND Mission.id_mission IN (" . implode(",", $missionIdsFromAgents) . ")" :'';
            $contactFilter = isset($filterOptions['contactFilter']) ? " AND Mission.id_mission IN (" . implode(",", $missionIdsFromContacts) . ")" :'';
            $targetFilter = isset($filterOptions['targetFilter']) ? " AND Mission.id_mission IN (" . implode(",", $missionIdsFromTargets) . ")" :'';
            $stashFilter = isset($filterOptions['stashFilter']) ? " AND Mission.id_mission IN (" . implode(",", $missionIdsFromStashs) . ")" :'';

            $stmt2 = $this->pdo->query( 
                "SELECT Mission.id_mission, code_name, title, description, country, type,
                status, start_date, end_date, Speciality.name AS speciality
                FROM Mission
                INNER JOIN Speciality ON Mission.id_speciality = Speciality.id_speciality"
                . $missionFilter
                . $typeMissionFilter
                . $specialityMissionFilter
                . $statusMissionFilter
                . $countryMissionFilter
                . $startDateMissionFilter
                . $endDateMissionFilter
                . $agentFilter
                . $contactFilter
                . $targetFilter
                . $stashFilter
            );
        }
        $missions = [];
        while ($mission = $stmt2->fetchObject(Mission::class)) {
            $missions[] = $mission;
        }
        return $missions;
    }
}