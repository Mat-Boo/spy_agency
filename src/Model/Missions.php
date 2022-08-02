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

/*     public function createPersonsLists(): array
    {
        $personsLists = [];
        foreach(['agent', 'contact', 'target'] as $person) {
            ${$person . 's'} = new Persons($this-> pdo, $person);
            $personsLists[$person . 'sList'] = ${$person . 's'}->getPersonsList();
        }
        $stashs = new Stashs($this->pdo);
        $personsLists['stashsList'] = $stashs->getStashsList();
        return $personsLists;
    }

    public function createPersonsFilters(array $filterOptions): array
    {
        $personsFilters = [];
        foreach(['agent', 'contact', 'target'] as $person) {
            $personsFilters['missions' . ucfirst($person . 's')] = new MissionsPersons($this->pdo, $person);
            $personsFilters[$person . 'sListFiltered'] = $personsFilters['missions' . ucfirst($person . 's')]->filterPersons($filterOptions); //Besoin pour filtrer selon les personnes (Agents, contacts et cibles)
        }
        $personsFilters['missionsStashs'] = new MissionsStashs($this->pdo);
        $personsFilters['stashsListFiltered'] = $personsFilters['missionsStashs']->filterStashs($filterOptions); //Besoin pour filtrer selon les planques
        return $personsFilters;
    } */

    /* public function hydrateMissionsFromTables(array $missionsListFiltered, array $personsLists, array $personsFilters, array $stashsLists, array $stashsFilters)
    {
        // Hydratation des missions avec les personnes (Agents, contacts, et cibles)
        foreach(['agent', 'contact', 'target'] as $person) {
            $personsFilters['missions' . ucfirst($person . 's')]->hydrateMissions($missionsListFiltered, $personsLists[$person . 'sList']); //Besoin pour hydrater les missions filtrées    
        }
        //

        // Hydratation des missions avec les planques
        $stashsFilters['missionsStashs']->hydrateMissions($missionsListFiltered, $stashsLists['stashsList']);
        //
    } */

    /* public function getStatus(): array
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
    } */

    /* public function convertToStringList(array $arrayToConvert, string $formItem): string
    {
        $newString = '';
            foreach($arrayToConvert as $item) {
                $newString .= "'" . $item . "'" . ",";
        }
        return $newString = substr($newString, 0, -1);
    } */

    public function filterMissions(array $filterConditions): array
    {
        if (!is_null($this->pdo)) {
            /* $stmt1 = $this->pdo->query("SELECT id_mission FROM Mission ORDER BY id_mission");
            $missionIds = [];
            while ($missionId = $stmt1->fetchColumn()) {
                $missionIds[] = $missionId;
            } */
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

    public function delete(int $idMission): void
    {
        $query = $this->pdo->prepare("DELETE FROM Mission WHERE id_mission = :idMission");
        $ok = $query->execute(['idMission' => $idMission]);
        if ($ok === false) {
            throw new Exception("Impossible de supprimer l'enregistrement $idMission dans la table Mission");
        }
    }

    public function find(int $idMission): Mission
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

    public function update(array $mission, int $id_mission): void
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