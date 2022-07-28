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

    public function getAgents()
    {
        if (!is_null($this->pdo)) {
            $stmt = $this->pdo->query("SELECT id_agent, firstname, lastname, birthdate, nationality FROM Agent ORDER BY lastname");
            $agents = [];
            while ($agent = $stmt->fetchObject(Agent::class)) {
                $agents[] = $agent;
            }
        }
        return $agents;
    }

    public function filterAgents(array $filterOptions): array
    {
        if (!is_null($this->pdo)) {
            $agentFilter = isset($filterOptions['agentFilter']) ? " WHERE id_agent IN (" . implode(",", $filterOptions['agentFilter']) . ")" : '';

            $stmt = $this->pdo->query(
                "SELECT id_mission
                FROM MissionAgent"
                .$agentFilter
            );
            $missionIdsFromAgents = [];
            while ($missionIdFromAgent = $stmt->fetchColumn()) {
                $missionIdsFromAgents[] = $missionIdFromAgent;
            }
        }
        return $missionIdsFromAgents;
    }
}