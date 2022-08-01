<?php

namespace App\Model;

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

    public function getPersonsList()
    {
        if (!is_null($this->pdo)) {
            $stmt = $this->pdo->query(
                "SELECT id, firstname, lastname, birthdate, nationality
                FROM " . ucfirst($this->personItem) . "
                ORDER BY lastname"
            );
        }
        ${$this->personItem . 's'} = [];
        while (${$this->personItem} = $stmt->fetchObject(Person::class)) {
            ${$this->personItem . 's'}[] = ${$this->personItem};
        }
        return ${$this->personItem . 's'};
    }
}