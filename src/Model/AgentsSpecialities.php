<?php

namespace App\Model;

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
        $sql = "SELECT id, id_speciality FROM AgentSpeciality";

        $agentsSpecialities = $this->pdo->query($sql, PDO::FETCH_CLASS, AgentSpeciality::class)->fetchAll();
        
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
        if (isset($filterOptions['specialitiesPersonFilter'])) {
            $sql = "SELECT id FROM AgentSpeciality WHERE id_speciality IN (" . implode(",", $filterOptions['specialitiesPersonFilter']) . ")";
        } else {
            $sql = "SELECT id FROM AgentSpeciality";
        }

        $agentIdsFromSpecialities = $this->pdo->query($sql, PDO::FETCH_COLUMN, 0)->fetchAll();

        if (empty($agentIdsFromSpecialities)) {
            $agentIdsFromSpecialities = [0];
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
            if ($updateAgentsSpecialities === false) {
                throw new Exception("Impossible de modifier l'enregistrement {$id_agent} dans la table 'AgentSpeciality'");
            }
        }

    }

    public function filterAgents(array $filterOptions): array
    {
        if (isset($filterOptions['agentsFilter'])) {
            $sql = "SELECT id_speciality FROM AgentSpeciality WHERE id IN (" . implode(",", $filterOptions['agentsFilter']) . ")";
        } else {
            $sql = "SELECT id_speciality FROM AgentSpeciality";
        }

        $specialityIdsFromAgents = $this->pdo->query($sql, PDO::FETCH_COLUMN, 0)->fetchAll();

        return $specialityIdsFromAgents;
    }

    public function hydrateSpecialities(array $specialities, array $agents): void
    {
        foreach($specialities as $speciality) {
            foreach($agents as $agent) {
                foreach($this->getAgentsSpecialitiesList() as $agentsSpecialities) {
                    if ($speciality->getId_speciality() === $agentsSpecialities->getId_speciality()) {
                        if ($agent->getId() === $agentsSpecialities->getId()) {
                            $speciality->addAgents($agent);
                        }
                    }
                }
            }
        }
    }

    public function deleteAgentSpecialityFromSpeciality($id_speciality): void
    {
        $query = $this->pdo->prepare(
            "DELETE FROM AgentSpeciality 
            WHERE id_speciality = :id_speciality");
        $deleteAgentSpeciality = $query->execute(['id_speciality' => $id_speciality]);
        if ($deleteAgentSpeciality === false) {
            throw new Exception("Impossible de supprimer l'enregistrement $id_speciality dans la table 'AgentSpeciality'");
        }
    }

    public function deleteAgentSpecialityFromAgent($id_agent): void
    {
        $query = $this->pdo->prepare(
            "DELETE FROM AgentSpeciality 
            WHERE id = :id_agent");
        $deleteAgentSpeciality = $query->execute(['id_agent' => $id_agent]);
        if ($deleteAgentSpeciality === false) {
            throw new Exception("Impossible de supprimer l'enregistrement $id_agent dans la table 'AgentSpeciality'");
        }
    }

    public function createAgentSpeciality(array $newAgent, int $id): void
    {
        $query = $this->pdo->prepare(
            "INSERT INTO AgentSpeciality SET 
            id = :id,
            id_speciality = :id_speciality
        ");
        foreach($newAgent['personSpecialities'] as $id_speciality) {
            $createAgentSpeciality = $query->execute(
                [
                    'id' => $id,
                    'id_speciality' => $id_speciality
                ]
            );
            if ($createAgentSpeciality === false) {
                throw new Exception("Impossible de créer le nouvel enregistrement {$newAgent['id']} . " - " . $id_speciality dans la table 'AgentSpeciality'");
            }

        }
    }
}