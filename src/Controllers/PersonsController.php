<?php

namespace App\Controllers;

use App\Connection;
use App\Model\Person;
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
        $filterConditions = [];
        $filterSort = '';

        if (isset($filterOptions['codenamePersonFilter'])) {
            $filterConditions[] = "code_name LIKE '%" . $filterOptions['codenamePersonFilter'] . "%'";
        }

        if (isset($filterOptions['personFilter'])) {
            $filterConditions[] = "id IN (" . implode(",", $filterOptions['personFilter']) . ")";
        }

        if (isset($filterOptions['nationalityPersonFilter']) && strlen($filterOptions['nationalityPersonFilter']) > 0) {
            $filterConditions[] = "nationality = '" . $filterOptions['nationalityPersonFilter'] . "'";
        }

        if (isset($filterOptions['specialitiesPersonFilter'])) {
            $filterConditions[] = "id IN (" . implode(",", $specialityFilter) . ")";
        }

        if (isset($filterOptions['startBirthdatePersonFilter']) && strlen($filterOptions['startBirthdatePersonFilter']) > 0) {
            $filterConditions[] = "birthdate >= '" . $filterOptions['startBirthdatePersonFilter'] . "'";
        }

        if (isset($filterOptions['endBirthdatePersonFilter']) && strlen($filterOptions['endBirthdatePersonFilter']) > 0) {
            $filterConditions[] = "birthdate <= '" . $filterOptions['endBirthdatePersonFilter'] . "'";
        }

        if (isset($filterOptions['missionsFilter'])) {
            $filterConditions[] = "id IN (" . implode(",", $missionsFilter) . ")";
        }

        if (isset($filterOptions['orderByFilter']) && isset($filterOptions['orderByDirection'])  && strlen($filterOptions['orderByFilter']) > 0) {
            $filterSort = $filterOptions['orderByFilter'] . ' ' . $filterOptions['orderByDirection'];
        }


        $persons = new Persons((new Connection)->getPdo(), $personItem);

        return $persons->filterPersons($filterConditions, $filterSort);
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
            $CountPersonPerMission = array_count_values($missionIds);
            foreach($person->getMissions() as $missionFromPerson) {
                foreach($CountPersonPerMission as $mission => $personNb) {
                    if ($mission === $missionFromPerson->getId_mission() && $personNb === 1) {
                        $typeMessage = 'alert';
                        $routerUrl = false;
                        if ($personItem === 'agent') {
                            $message = "L\'agent " . $person->getCode_name() . " - " . $person->getFirstname() . " " . $person->getLastname() . " est le seul agent qui est affecté à la mission " . $missionFromPerson->getId_mission() . " - " . $missionFromPerson->getCode_name() . ".\\n\\nPour pouvoir le supprimer, veuillez d\'abord affecter un autre agent à cette mission";
                        } elseif ($personItem === 'contact') {
                            $message = "Le contact " . $person->getCode_name() . " - " . $person->getFirstname() . " " . $person->getLastname() . " est le seul contact qui est affecté à la mission " . $missionFromPerson->getId_mission() . " - " . $missionFromPerson->getCode_name() . ".\\n\\nPour pouvoir le supprimer, veuillez d\'abord affecter un autre contact à cette mission";
                        } else {
                            $message = "La cible " . $person->getCode_name() . " - " . $person->getFirstname() . " " . $person->getLastname() . " est la seule cible qui est affectée à la mission " . $missionFromPerson->getId_mission() . " - " . $missionFromPerson->getCode_name() . ".\\n\\nPour pouvoir la supprimer, veuillez d\'abord affecter une autre cible à cette mission";
                        }
                    } elseif ($typeMessage !== 'alert') {
                        $typeMessage = 'confirm';
                        $routerUrl = true;
                        if ($personItem === 'agent') {
                            $message = "L\'agent " . $person->getCode_name() . " - " . $person->getFirstname() . " " . $person->getLastname() . " est affecté à la mission " . $missionFromPerson->getId_mission() . " - " . $missionFromPerson->getCode_name() . ".\\n\\nVoulez-vous vraiment le supprimer ?";
                        } elseif ($personItem === 'contact') {
                            $message = "Le contact " . $person->getCode_name() . " - " . $person->getFirstname() . " " . $person->getLastname() . " est affecté à la mission " . $missionFromPerson->getId_mission() . " - " . $missionFromPerson->getCode_name() . ".\\n\\nVoulez-vous vraiment le supprimer ?";
                        } else {
                            $message = "La cible " . $person->getCode_name() . " - " . $person->getFirstname() . " " . $person->getLastname() . " est affectée à la mission " . $missionFromPerson->getId_mission() . " - " . $missionFromPerson->getCode_name() . ".\\n\\nVoulez-vous vraiment la supprimer ?";
                        }
                    }
                }
            }
        } else {
            $routerUrl = true;
            $typeMessage = 'confirm';
            $message = "Voulez-vous vraiment supprimer ". ($personItem === 'agent' ? "l\'agent " : ($personItem === 'contact' ? "le contact " : "la cible ")) . $person->getCode_name() . " ?";
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

    public function getNationalitiesPersons(): array
    {
        foreach($this->getPersonsLists('nationality') as $key => $personsList) {
            ${$key} = [];
            foreach($personsList as $person) {
                if (!in_array($person->getNationality(), ${$key})) {
                    ${$key}[] = $person->getNationality();
                }
            }
            $nationalitiesPersons[substr($key, 0, -4) . 'Nationalities'] = ${$key};
        }
        return $nationalitiesPersons;
    }
    
    public function controlsRules(array $personPost, string $personItem, Person $person): array
    {
        $errors = [];

        $personItems = 
        [
            'codenamePerson' => 'Le <b>CODE NAME</b> ',
            'firstnamePerson' => 'Le <b>PRÉNOM</b> ',
            'lastnamePerson' => 'Le <b>NOM</b> ',
            'birthdatePerson' => 'La <b>DATE DE NAISSANCE</b> ',
            'nationalityPerson' => 'La <b>NATIONALITÉ</b>'
        ];

        // Vérifie si tous les champs sont bien renseignés car tous obligatoires
        foreach($personPost as $keyPost => $itemPost) {
            foreach($personItems as $key => $item) {
                if ($itemPost === '' && $keyPost === $key) {
                    $errors['blank_' . $key] = '<li class="error">' . $item . ' est obligatoire sur la fiche ' . ($personItem === 'target' ? 'Cible' : ucfirst($personItem)) . '</li>';
                }
            }
        }

        // Vérifie l'unicité du champs CodeName
        foreach($this->getPersonsLists('id')[$personItem . 'sList'] as $person) {
            if ($person->getCode_name() === $personPost['codenamePerson']) {
                $errors['uniqueCodeName'] = '<li class="error">Le <b>CODE NAME</b> saisi existe déjà</li>';
            }
        }

        // Vérifie que, si on change le pays d'une personne, celui ci n'est pas affecté à une mission, sinon message d'erreur selon si les règles suivantes ne sont respectées
            // La nationalité du contact doit être identique au pays de la mission
            // La nationalité de l'agent doit être différent de celle de la cible
            if ($personPost['nationalityPerson'] !== $person->getNationality()) {
                if (!empty($person->getMissions())) {
                    foreach ($person->getMissions() as $mission) {
                        if ($personItem === 'contact') {
                            if ($personPost['nationalityPerson'] !== $mission->getCountry()) {
                                $errors['nationalityChange_' . $person->getId() . '-' . $mission->getId_mission()] = 
                                "<li class='error'>Ce contact est affecté à la mission <b>" . strtoupper($mission->getCode_name()) ."</b> dont la pays est <b>" . strtoupper($mission->getCountry()) . 
                                "</b> or la mission doit avoir son ou ses contact(s) dans le même pays. Si vous souhaitez vraiment changer la nationalité, veuillez d'abord le désaffecter de la mission concernée.</li>";
                            }
                        } else if ($personItem === 'agent') {
                            $targetsNationality = [];
                            foreach($mission->getTargets() as $target) {
                                if (!in_array($target->getNationality(), $targetsNationality)) {
                                    $targetsNationality[] = $target->getNationality();
                                }
                            }
                        if (in_array($personPost['nationalityPerson'], $targetsNationality)) {
                            $errors['nationalityChange_' . $person->getId() . '-' . $mission->getId_mission()] = 
                            "<li class='error'>Cet agent est affecté à la mission <b>" . strtoupper($mission->getCode_name()) ."</b> dont l'une des cibles a la même nationalité, soit <b>" . strtoupper($personPost['nationalityPerson']) . 
                            "</b> or sur une mission, il ne peut y avoir d'agent et de cible de même nationalité. Si vous souhaitez vraiment changer la nationalité, veuillez d'abord désaffecter l'agent ou la cible de la mission concernée.</li>";
                        }
                    } else if ($personItem === 'target') {
                        $agentsNationality = [];
                        foreach($mission->getAgents() as $agent) {
                            if (!in_array($agent->getNationality(), $agentsNationality)) {
                                $agentsNationality[] = $agent->getNationality();
                            }
                        }
                        if (in_array($personPost['nationalityPerson'], $agentsNationality)) {
                            $errors['nationalityChange_' . $person->getId() . '-' . $mission->getId_mission()] = 
                            "<li class='error'>Cette cible est affectée à la mission <b>" . strtoupper($mission->getCode_name()) ."</b> dont l'un des agents a la même nationalité, soit <b>" . strtoupper($personPost['nationalityPerson']) . 
                            "</b> or sur une mission, il ne peut y avoir d'agent et de cible de même nationalité. Si vous souhaitez vraiment changer la nationalité, veuillez d'abord désaffecter l'agent ou la cible de la mission concernée.</li>";
                        }
                    }
                }
            }
        }

        return $errors;
    }
}