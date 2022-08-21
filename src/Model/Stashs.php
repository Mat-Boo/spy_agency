<?php

namespace App\Model;

use App\Model\Exception\NotFoundException;
use Exception;
use PDO;

class Stashs
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getStashsList(string $sortBy): array
    {
        $sql = 'SELECT * FROM Stash ORDER BY ' . $sortBy;

        $stashs = $this->pdo->query($sql, PDO::FETCH_CLASS, Stash::class)->fetchAll();

        return $stashs;
    }

    public function filterStashs(array $filterConditions, string $filterSort): array
    {
        $sql = "SELECT * FROM Stash";

        if (count($filterConditions) > 0) {
            $sql .= " WHERE " . $filterConditions[0];
        }

        if (count($filterConditions) > 1) {
            for ($i = 1 ; $i < count($filterConditions) ; $i++) {
                $sql .= " AND " . $filterConditions[$i];
            }
        }

        if (strlen($filterSort) > 0) {
            $sql .= " ORDER BY " . $filterSort;
        }

        $stashs = $this->pdo->query($sql, PDO::FETCH_CLASS, Stash::class)->fetchAll();

        return $stashs;
    }

    public function findStash(int $idStash): Stash
    {
        $query = $this->pdo->prepare(
            "SELECT *
            FROM Stash
            WHERE id_stash = :id_stash");
        $query->execute(['id_stash' => $idStash]);
        $foundStash = $query->fetchObject(Stash::class);
        if ($foundStash === false) {
            throw new NotFoundException('Stash', $idStash);
        }
        return $foundStash;
    }

    public function updateStash(array $stash, int $id_stash): void
    {
        $query = $this->pdo->prepare(
            "UPDATE Stash SET 
            code_name = :code_name,
            address = :address,
            country = :country,
            `type` = :type
            WHERE id_stash = :id_stash
        ");
        $updateStash = $query->execute(
            [
                'code_name' => $stash['codenameStash'],
                'address' => $stash['addressStash'],
                'country' => $stash['countryStash'],
                'type' => $stash['typeStash'],
                'id_stash' => $id_stash
            ]
        );
        if ($updateStash === false) {
            throw new Exception("Impossible de modifier l'enregistrement {$id_stash} dans la table 'Stash'");
        }
    }

    public function deleteStash(int $id_stash): void
    {
        $query = $this->pdo->prepare(
            "DELETE FROM Stash 
            WHERE id_stash = :id_stash");
        $deleteStash = $query->execute(['id_stash' => $id_stash]);
        if ($deleteStash === false) {
            throw new Exception("Impossible de supprimer l'enregistrement $id_stash dans la table 'Stash'");
        }
    }

    public function createStash(array $newStash): int
    {
        $query = $this->pdo->prepare(
            "INSERT INTO Stash SET 
            code_name = :code_name,
            address = :address,
            country = :country,
            `type` = :type
        ");
        $createStash = $query->execute(
            [
                'code_name' => $newStash['codenameStash'],
                'address' => $newStash['addressStash'],
                'country' => $newStash['countryStash'],
                'type' => $newStash['typeStash']
            ]
        );
        if ($createStash === false) {
            throw new Exception("Impossible de créer le nouvel enregistrement {$newStash['codenameStash']} dans la table 'Stash'");
        }
        return $this->pdo->lastInsertId();
    }
}