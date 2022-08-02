<?php

namespace App\Controllers;

use App\Connection;
use App\model\Person;
use App\Model\Persons;

class PersonsController
{
    public function getPersonsLists($sortBy): array
    {
        $personsLists = [];
        foreach(['agent', 'contact', 'target'] as $person) {
            ${$person . 's'} = new Persons((new Connection)->getPdo(), $person);
            $personsLists[$person . 'sList'] = ${$person . 's'}->getPersonsList($sortBy);
        }
        return $personsLists;
    }

    public function filterPersons(array $filterOptions, array $specialityFilter, array $missionsFilter, string $personItem): array
    {
        $personIds = [];
        foreach($this->getPersonsLists('id') as $personsList) {
            foreach($personsList as $person) {
                $personIds[] = $person->getId();
            }
        }

        $filterConditions = [];
        $filterConditions['personFilter'] = isset($filterOptions['personFilter']) ? " WHERE id IN (" . implode(",", $filterOptions['personFilter']) . ")" : " WHERE id IN (" . implode(",", $personIds) . ")";
        $filterConditions['nationalityPersonFilter'] = isset($filterOptions['nationalityPersonFilter']) && strlen($filterOptions['nationalityPersonFilter']) > 0 ? " AND nationality = '" . $filterOptions['nationalityPersonFilter'] . "'" : '';
        $filterConditions['specialitiesPersonFilter'] = isset($filterOptions['specialitiesPersonFilter']) ? " AND id IN (" . implode(",", $specialityFilter) . ")" : '';
        $filterConditions['startBirthdatePersonFilter'] = isset($filterOptions['startBirthdatePersonFilter']) && strlen($filterOptions['startBirthdatePersonFilter']) > 0 ? " AND birthdate >= '" . $filterOptions['startBirthdatePersonFilter'] . "'" : '';
        $filterConditions['endBirthdatePersonFilter'] = isset($filterOptions['endBirthdatePersonFilter']) && strlen($filterOptions['endBirthdatePersonFilter']) > 0 ? " AND birthdate <= '" . $filterOptions['endBirthdatePersonFilter'] . "'" : '';
        $filterConditions['missionsFilter'] = isset($filterOptions['missionsFilter']) ? " AND id IN (" . implode(",", $missionsFilter) . ")" : '';

        $persons = new Persons((new Connection)->getPdo(), $personItem);

        return $persons->filterPersons($filterConditions);
    }

    public function findPerson(int $idPerson, string $personItem): Person
    {
        $persons = new Persons((new Connection)->getPdo(), $personItem);
        return $persons->findPerson($idPerson);
    }

    public function updatePerson(array $person, int $id_person, string $personItem): void
    {
        $persons = new Persons((new Connection)->getPdo(), $personItem);
        $persons->updatePerson($person, $id_person);
    }
}