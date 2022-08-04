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
        if (!is_null($this->pdo)) {
            $stmt = $this->pdo->query(
                "SELECT id, firstname, lastname, birthdate, nationality
                FROM " . ucfirst($this->personItem) . "
                ORDER BY " . $sortBy
            );
        }
        ${$this->personItem . 's'} = [];
        while (${$this->personItem} = $stmt->fetchObject(Person::class)) {
            ${$this->personItem . 's'}[] = ${$this->personItem};
        }
        return ${$this->personItem . 's'};
    }

    public function filterPersons(array $filterConditions): array
    {
        if (!is_null($this->pdo)) {
            $stmt = $this->pdo->query( 
                "SELECT " . strtoupper($this->personItem) . ".id, firstname, lastname, birthdate, nationality
                FROM " . strtoupper($this->personItem)
                . implode('', $filterConditions)
            );
        }
        $persons = [];
        while ($person = $stmt->fetchObject(Person::class)) {
            $persons[] = $person;
        }
        return $persons;
    }

    /* public function delete(int $idMission): void
    {
        $query = $this->pdo->prepare("DELETE FROM Mission WHERE id_mission = :idMission");
        $ok = $query->execute(['idMission' => $idMission]);
        if ($ok === false) {
            throw new Exception("Impossible de supprimer l'enregistrement $idMission dans la table Mission");
        }
    } */

    public function findPerson(int $idPerson): Person
    {
        $query = $this->pdo->prepare(
            "SELECT id, firstname, lastname, birthdate, nationality
            FROM " . ucfirst($this->personItem) . "
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
            "UPDATE " . ucfirst($this->personItem) . " SET 
            id = :id,
            firstname = :firstname,
            lastname = :lastname,
            birthdate = :birthdate,
            nationality = :nationality
            WHERE id = :id
        ");
        $updatePerson = $query->execute(
            [
                'id' => $person['idPerson'],
                'firstname' => $person['firstnamePerson'],
                'lastname' => $person['lastnamePerson'],
                'birthdate' => $person['birthdatePerson'],
                'nationality' => $person['nationalityPerson'],
            ]
        );
        if ($updatePerson === false) {
            throw new Exception("Impossible de modifier l'enregistrement {$id_person} dans la table '" . ucfirst($this->personItem) . "'");
        }
    }

    public function deletePerson(int $id): void
    {
        $query = $this->pdo->prepare(
            "DELETE FROM " . ucfirst($this->personItem) . "
            WHERE id = :id");
        $deletePerson = $query->execute(['id' => $id]);
        if ($deletePerson === false) {
            throw new Exception("Impossible de supprimer l'enregistrement $id dans la table '" . ucfirst($this->personItem) . "'");
        }
    }
}