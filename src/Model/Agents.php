<?php

namespace App\model;
use PDO;

class Agents
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAgentsList()
    {
        if (!is_null($this->pdo)) {
            $stmt = $this->pdo->query(
                'SELECT Agent.id_agent, firstname, lastname, birthdate, nationality, id_mission
                FROM Agent
                INNER JOIN MissionAgent ON Agent.id_agent = MissionAgent.id_agent'
            );
        }
        $agents = [];
        while ($agent = $stmt->fetchObject(Agent::class)) {
            $agents[] = $agent;
        }
        return $agents;
    }

    public function hydrateMissions(array $missions, array $agents): void
    {
        foreach($missions as $mission) {
            foreach($agents as $agent) {
                if ($mission->getId_mission() === $agent->getId_mission()) {
                    $mission->addAgents($agent);
                }
            }
        }
    }

    public function getNames()
    {
        $names = [];
        foreach($this->getAgentsList() as $agent) {
            if (!in_array($agent->getfirstname() . ' ' . $agent->getlastname(), $names)) {
                $names[] = $agent->getfirstname() . ' ' . $agent->getlastname();
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