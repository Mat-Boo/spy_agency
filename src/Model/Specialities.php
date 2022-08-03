<?php

namespace App\model;

use App\Model\Exception\NotFoundException;
use Exception;
use PDO;

class Specialities
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getSpecialitiesList($sortBy)
    {
        if (!is_null($this->pdo)) {
            $stmt = $this->pdo->query(
                "SELECT *
                FROM Speciality
                ORDER BY " . $sortBy
            );
        }
        $specialities = [];
        while ($speciality = $stmt->fetchObject(Speciality::class)) {
            $specialities[] = $speciality;
        }
        return $specialities;
    }

    public function filterSpecialities(array $filterConditions): array
    {
        if (!is_null($this->pdo)) {
            $stmt = $this->pdo->query( 
                "SELECT id_speciality, name
                FROM Speciality"
                . implode('', $filterConditions)
            );
        }
        $specialities = [];
        while ($speciality = $stmt->fetchObject(Speciality::class)) {
            $specialities[] = $speciality;
        }
        return $specialities;
    }

    public function findSpeciality(int $idSpeciality): Speciality
    {
        $query = $this->pdo->prepare(
            "SELECT id_speciality, name
            FROM Speciality
            WHERE id_speciality = :id_speciality");
        $query->execute(['id_speciality' => $idSpeciality]);
        $foundSpeciality = $query->fetchObject(Speciality::class);
        if ($foundSpeciality === false) {
            throw new NotFoundException('Speciality', $idSpeciality);
        }
        return $foundSpeciality;
    }

    public function updateSpeciality(array $speciality, int $id_speciality): void
    {
        $query = $this->pdo->prepare(
            "UPDATE Speciality SET 
            id_speciality = :id_speciality,
            name = :name
            WHERE id_speciality = :id_speciality
        ");
        $updateSpeciality = $query->execute(
            [
                'id_speciality' => $id_speciality,
                'name' => $speciality['nameSpeciality']
            ]
        );
        if ($updateSpeciality === false) {
            throw new Exception("Impossible de modifier l'enregistrement {$id_speciality} dans la table 'Speciality'");
        }
    }

    public function deleteSpeciality(int $id_speciality): void
    {
        $query = $this->pdo->prepare(
            "DELETE FROM Speciality 
            WHERE id_speciality = :id_speciality");
        $deleteSpeciality = $query->execute(['id_speciality' => $id_speciality]);
        if ($deleteSpeciality === false) {
            throw new Exception("Impossible de supprimer l'enregistrement $id_speciality dans la table 'Speciality'");
        }
    }
}