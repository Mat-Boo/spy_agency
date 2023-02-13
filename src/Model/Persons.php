<?php

namespace App\Model;

use App\Model\Exception\NotFoundException;
use Exception;
use PDO;

class Persons
{
    private $pdo;
    private $personItem;

    public function __construct(PDO $pdo, string $personItem)
    {
        $this->pdo = $pdo;
        $this->personItem = $personItem;
    }

    public function getPersonsList($sortBy)
    {
        $sql = "SELECT * FROM " . strtolower($this->personItem) . " ORDER BY " . $sortBy;

        ${$this->personItem . 's'} = $this->pdo->query($sql, PDO::FETCH_CLASS, Person::class)->fetchAll();
        
        return ${$this->personItem . 's'};
    }

    public function filterPersons(array $filterConditions, string $filterSort, int $page): array
    {
        //Pagination
        $perPage = 6;
        $currentPage = (int)$page;
        if ($currentPage <= 0) {
            throw new Exception('Numéro de page invalide');
        }
        $offset = $perPage * ($currentPage - 1);
        $sqlCount = 'SELECT COUNT(id) FROM ' . strtoupper($this->personItem);


        $sql = "SELECT * FROM " . strtoupper($this->personItem);

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

        $persons = $this->pdo->query($sql, PDO::FETCH_CLASS, Person::class)->fetchAll();

        $count = $this->pdo->query($sqlCount)->fetch(PDO::FETCH_NUM)[0];
        $pages = ceil($count / $perPage);

        return ['persons' => $persons, 'pages' => $pages];
    }

    public function findPerson(int $idPerson): Person
    {
        $query = $this->pdo->prepare(
            "SELECT *
            FROM " . strtolower($this->personItem) . "
            WHERE id = :id");
        $query->execute(['id' => $idPerson]);
        $foundPerson = $query->fetchObject(Person::class);
        if ($foundPerson === false) {
            throw new NotFoundException('Person', $idPerson);
        }
        return $foundPerson;
    }

    public function updatePerson(array $person, int $id_person): void
    {
        $query = $this->pdo->prepare(
            "UPDATE " . strtolower($this->personItem) . " SET 
            code_name = :code_name,
            firstname = :firstname,
            lastname = :lastname,
            birthdate = :birthdate,
            nationality = :nationality
            WHERE id = :id
        ");
        $updatePerson = $query->execute(
            [
                'code_name' => $person['codenamePerson'],
                'firstname' => $person['firstnamePerson'],
                'lastname' => $person['lastnamePerson'],
                'birthdate' => $person['birthdatePerson'],
                'nationality' => $person['nationalityPerson'],
                'id' => $id_person
            ]
        );
    }

    public function deletePerson(int $id): void
    {
        $query = $this->pdo->prepare(
            "DELETE FROM " . strtolower($this->personItem) . "
            WHERE id = :id");
        $deletePerson = $query->execute(['id' => $id]);
        if ($deletePerson === false) {
            throw new Exception("Impossible de supprimer l'enregistrement $id dans la table '" . strtolower($this->personItem) . "'");
        }
    }

    public function createPerson(array $newPerson): int
    {
        $query = $this->pdo->prepare(
            "INSERT INTO " . strtolower($this->personItem) . " SET 
            code_name = :code_name,
            firstname = :firstname,
            lastname = :lastname,
            birthdate = :birthdate,
            nationality = :nationality
        ");
        $createPerson = $query->execute(
            [
                'code_name' => $newPerson['codenamePerson'],
                'firstname' => $newPerson['firstnamePerson'],
                'lastname' => $newPerson['lastnamePerson'],
                'birthdate' => $newPerson['birthdatePerson'],
                'nationality' => $newPerson['nationalityPerson']
            ]
        );
        if ($createPerson === false) {
            throw new Exception("Impossible de créer le nouvel enregistrement {$newPerson['idPerson']} dans la table '" . strtolower($this->personItem) . "'");
        }
        return $this->pdo->lastInsertId();
    }
}