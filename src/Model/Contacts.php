<?php

namespace App\model;
use PDO;

class Contacts
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getContactsList()
    {
        if (!is_null($this->pdo)) {
            $stmt = $this->pdo->query(
                'SELECT Contact.id_contact, firstname, lastname, birthdate, nationality, id_mission
                FROM Contact
                INNER JOIN MissionContact ON Contact.id_contact = MissionContact.id_contact'
            );
        }
        $contacts = [];
        while ($contact = $stmt->fetchObject(Contact::class)) {
            $contacts[] = $contact;
        }
        return $contacts;
    }

    public function hydrateMissions(array $missions, array $contacts): void
    {
        foreach($missions as $mission) {
            foreach($contacts as $contact) {
                if ($mission->getId_mission() === $contact->getId_mission()) {
                    $mission->addContacts($contact);
                }
            }
        }
    }

    public function getNames()
    {
        $names = [];
        foreach($this->getContactsList() as $contact) {
            if (!in_array($contact->getfirstname() . ' ' . $contact->getlastname(), $names)) {
                $names[] = $contact->getfirstname() . ' ' . $contact->getlastname();
            }
        }

        usort($names, function ($a, $b)
        {
            if ($a == $b) {
                return 0;
            } else {
                return ($a < $b) ? -1 : 1;
            }
        });

        return $names;
    }
}