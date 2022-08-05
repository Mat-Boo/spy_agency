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

    public function checkMissionBeforeDelete(Person $person, string $personItem, array $missionIds): array
    {
        $message = '';
        $typeMessage ='';
        if (!empty($person->getMissions())) {
            /* $missionIds = [];
            foreach($person->getMissions() as $missionFromPerson) {
                $missionIds[] = $missionFromPerson->getId_mission();
            }
            sort($missionIds);
            var_dump($missionIds); */
            $CountPersonPerMission = array_count_values($missionIds);
            /* var_dump($CountPersonPerMission); */
            foreach($person->getMissions() as $missionFromPerson) {
                foreach($CountPersonPerMission as $mission => $personNb) {
                   /*  echo 'missionFromPerson ' . $missionFromPerson->getId_mission() . '</br>';
                    echo 'mission ' . $mission . '</br>';
                    var_dump(gettype($mission)) . '</br>';
                    echo 'nbperson ' . $personNb . '</br>';
                    var_dump(gettype($personNb)) . '</br></br>'; */
                    /* echo $mission === $missionFromPerson->getId_mission() && $personNb === 1 ? 'vrai' : 'faux'; */
                    if ($mission === $missionFromPerson->getId_mission() && $personNb === 1) {
                        $typeMessage = 'alert';
                        $routerUrl = false;
                        if ($personItem === 'agent') {
                            $message = "L\'agent " . $person->getId() . " - " . $person->getFirstname() . " " . $person->getLastname() . " est le seul agent qui est affecté à la mission " . $missionFromPerson->getId_mission() . " - " . $missionFromPerson->getCode_name() . ".\\n\\nPour pouvoir le supprimer, veuillez d\'abord affecter un autre agent à cette mission";
                        } elseif ($personItem === 'contact') {
                            $message = "Le contact " . $person->getId() . " - " . $person->getFirstname() . " " . $person->getLastname() . " est le seul contact qui est affecté à la mission " . $missionFromPerson->getId_mission() . " - " . $missionFromPerson->getCode_name() . ".\\n\\nPour pouvoir le supprimer, veuillez d\'abord affecter un autre contact à cette mission";
                        } else {
                            $message = "La cible " . $person->getId() . " - " . $person->getFirstname() . " " . $person->getLastname() . " est la seule cible qui est affectée à la mission " . $missionFromPerson->getId_mission() . " - " . $missionFromPerson->getCode_name() . ".\\n\\nPour pouvoir la supprimer, veuillez d\'abord affecter une autre cible à cette mission";
                        }
                    } elseif ($typeMessage !== 'alert') {
                        $typeMessage = 'confirm';
                        $routerUrl = true;
                        if ($personItem === 'agent') {
                            $message = "L\'agent " . $person->getId() . " - " . $person->getFirstname() . " " . $person->getLastname() . " est affecté à la mission " . $missionFromPerson->getId_mission() . " - " . $missionFromPerson->getCode_name() . ".\\n\\nVoulez-vous vraiment le supprimer ?";
                        } elseif ($personItem === 'contact') {
                            $message = "Le contact " . $person->getId() . " - " . $person->getFirstname() . " " . $person->getLastname() . " est affecté à la mission " . $missionFromPerson->getId_mission() . " - " . $missionFromPerson->getCode_name() . ".\\n\\nVoulez-vous vraiment le supprimer ?";
                        } else {
                            $message = "La cible " . $person->getId() . " - " . $person->getFirstname() . " " . $person->getLastname() . " est affectée à la mission " . $missionFromPerson->getId_mission() . " - " . $missionFromPerson->getCode_name() . ".\\n\\nVoulez-vous vraiment la supprimer ?";
                        }
                    }
                }
            }
        } else {
            $routerUrl = true;
            $typeMessage = 'confirm';
            $message = "Voulez-vous vraiment supprimer ". ($personItem === 'agent' ? 'l\'agent ' : ($personItem === 'contact' ? 'le contact ' : 'la cible ')) . $person->getId() . " ?";
        }
        return ['onsubmitMessage' => $typeMessage . "('$message')", 'routerUrl' => $routerUrl];
    }

    public function deletePerson(int $id, string $personItem): void
    {
        $persons = new Persons((new Connection)->getPdo(), $personItem);
        $persons->deletePerson($id);
    }

    public function createPerson(array $newPerson, string $personItem): int
    {
        $persons = new Persons((new Connection)->getPdo(), $personItem);
        return $persons->createPerson($newPerson);
    }
}