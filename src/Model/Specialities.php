<?php

namespace App\Model;

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
        $sql = "SELECT * FROM speciality ORDER BY " . $sortBy;
        $specialities = $this->pdo->query($sql, PDO::FETCH_CLASS, Speciality::class)->fetchAll();

        return $specialities;
    }

    public function filterSpecialities(array $filterConditions, string $filterSort, int $page): array
    {
        //Pagination
        $perPage = 6;
        $currentPage = (int)$page;
        if ($currentPage <= 0) {
            throw new Exception('Numéro de page invalide');
        }
        $offset = $perPage * ($currentPage - 1);
        $sqlCount = 'SELECT COUNT(id_speciality) FROM speciality';


        $sql = "SELECT * FROM speciality";

        if (count($filterConditions) > 0) {
            $sql .= " WHERE " . $filterConditions[0];
            $sqlCount .= " WHERE " . $filterConditions[0];
        }

        if (count($filterConditions) > 1) {
            for ($i = 1 ; $i < count($filterConditions) ; $i++) {
                $sql .= " AND " . $filterConditions[$i];
                $sqlCount .= " AND " . $filterConditions[$i];
            }
        }

        if (strlen($filterSort) > 0) {
            $sql .= " ORDER BY " . $filterSort;
        }

        $sql .= " LIMIT " . $perPage . " OFFSET " . $offset;

        $specialities = $this->pdo->query($sql, PDO::FETCH_CLASS, Speciality::class)->fetchAll();

        $count = $this->pdo->query($sqlCount)->fetch(PDO::FETCH_NUM)[0];
        $pages = ceil($count / $perPage);

        return ['specialities' => $specialities, 'pages' => $pages];
    }

    public function findSpeciality(int $idSpeciality): Speciality
    {
        $query = $this->pdo->prepare(
            "SELECT *
            FROM speciality
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
            "UPDATE speciality SET 
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
            "DELETE FROM speciality 
            WHERE id_speciality = :id_speciality");
        $deleteSpeciality = $query->execute(['id_speciality' => $id_speciality]);
        if ($deleteSpeciality === false) {
            throw new Exception("Impossible de supprimer l'enregistrement $id_speciality dans la table 'Speciality'");
        }
    }

    public function createSpeciality(array $newSpeciality): int
    {
        $query = $this->pdo->prepare(
            "INSERT INTO speciality SET 
            id_speciality = :id_speciality,
            name = :name
        ");
        $createSpeciality = $query->execute(
            [
                'id_speciality' => $newSpeciality['idSpeciality'],
                'name' => $newSpeciality['nameSpeciality']
            ]
        );
        if ($createSpeciality === false) {
            throw new Exception("Impossible de créer le nouvel enregistrement {$newSpeciality['idSpeciality']} dans la table 'Speciality'");
        }
        return $this->pdo->lastInsertId();
    }
}