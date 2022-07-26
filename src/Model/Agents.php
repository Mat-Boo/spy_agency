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
                'SELECT Agent.id_code_agent, firstname, lastname, birthdate, nationality, id_code_mission
                FROM Agent
                INNER JOIN MissionAgent ON Agent.id_code_agent = MissionAgent.id_code_agent'
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
                if ($mission->getId_code_mission() === $agent->getId_code_mission()) {
                    $mission->addAgents($agent);
                }
            }
        }
    }
}