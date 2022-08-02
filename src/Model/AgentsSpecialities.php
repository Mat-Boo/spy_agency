<?php

namespace App\model;

use Exception;
use PDO;

class AgentsSpecialities
{
    private $pdo;

    public function __construct(PDO $pdo)
    {   
        $this->pdo = $pdo;
    }

    public function getAgentsSpecialitiesList(): array
    {
        if (!is_null($this->pdo)) {
            $stmt = $this->pdo->query(
                "SELECT id, id_speciality
                FROM AgentSpeciality"
            );
        }
        $agentsSpecialities = [];
        while ($agentSpeciality = $stmt->fetchObject(AgentSpeciality::class)) {
            $agentsSpecialities[] = $agentSpeciality;
        }
        return $agentsSpecialities;
    }

    public function hydrateAgents(array $agents, array $specialities): void
    {
        foreach($agents as $agent) {
            foreach($specialities as $speciality) {
                    foreach($this->getAgentsSpecialitiesList() as $agentSpeciality) {
                    if ($agent->getId() === $agentSpeciality->getId()) {
                        if ($speciality->getId_speciality() === $agentSpeciality->getId_speciality()) {
                            $agent->addSpecialities($speciality);
                        }
                    }
                }
            }
        }
    }

    public function filterSpecialities(array $filterOptions): array
    {
        if (!is_null($this->pdo)) {
            $specialityFilter = isset($filterOptions['specialitiesPersonFilter']) ? " WHERE id_speciality IN (" . implode(",", $filterOptions['specialitiesPersonFilter']) . ")" : '';

            $stmt = $this->pdo->query(
                "SELECT id
                FROM AgentSpeciality"
                . $specialityFilter
            );
            $agentIdsFromSpecialities = [];
            while ($agentIdsFromSpeciality = $stmt->fetchColumn()) {
                $agentIdsFromSpecialities[] = $agentIdsFromSpeciality;
            }
        }
        return $agentIdsFromSpecialities;
    }

    public function updateAgentsSpecialities($agent, $id_agent)
    {
        $this->pdo->exec("DELETE FROM AgentSpeciality WHERE id = " . $id_agent);

        $query = $this->pdo->prepare(
            "INSERT INTO AgentSpeciality SET 
            id = :id,
            id_speciality = :id_speciality
        ");

        foreach($agent['personSpecialities'] as $id_speciality) {
            $updateAgentsSpecialities[] = $query->execute(
                [
                    'id' => $id_agent,
                    'id_speciality' => $id_speciality
                ]
            );
        }

        if ($updateAgentsSpecialities === false) {
            throw new Exception("Impossible de modifier l'enregistrement {$id_agent} dans la table 'AgentSpeciality'");
        }
    }
}