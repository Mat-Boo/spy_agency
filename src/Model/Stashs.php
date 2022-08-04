<?php

namespace App\model;

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
        if (!is_null($this->pdo)) {
            $stmt = $this->pdo->query(
                'SELECT Stash.id_stash, address, country, type
                FROM Stash
                ORDER BY ' . $sortBy
            );
        }
        $stashs = [];
        while ($stash = $stmt->fetchObject(Stash::class)) {
            $stashs[] = $stash;
        }
        return $stashs;
    }

    public function filterStashs(array $filterConditions): array
    {
        if (!is_null($this->pdo)) {
            $stmt = $this->pdo->query( 
                "SELECT id_stash, address, country, type
                FROM Stash"
                . implode('', $filterConditions)
            );
        }
        $stashs = [];
        while ($stash = $stmt->fetchObject(Stash::class)) {
            $stashs[] = $stash;
        }
        return $stashs;
    }

    public function findStash(int $idStash): Stash
    {
        $query = $this->pdo->prepare(
            "SELECT id_stash, address, country, type
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
            id_stash = :id_stash,
            address = :address,
            country = :country,
            type = :type
            WHERE id_stash = :id_stash
        ");
        $updateStash = $query->execute(
            [
                'id_stash' => $stash['idStash'],
                'address' => $stash['addressStash'],
                'country' => $stash['countryStash'],
                'type' => $stash['typeStash']
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

    public function createStash(array $newStash): void
    {
        $query = $this->pdo->prepare(
            "INSERT INTO Stash SET 
            id_stash = :id_stash,
            address = :address,
            country = :country,
            type = :type
        ");
        $createStash = $query->execute(
            [
                'id_stash' => $newStash['idStash'],
                'address' => $newStash['addressStash'],
                'country' => $newStash['countryStash'],
                'type' => $newStash['typeStash']
            ]
        );
        if ($createStash === false) {
            throw new Exception("Impossible de créer le nouvel enregistrement {$newStash['idStash']} dans la table 'Stash'");
        }
    }
}