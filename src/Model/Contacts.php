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
                'SELECT Contact.code_name_contact, firstname, lastname, birthdate, nationality, id_code_mission
                FROM Contact
                INNER JOIN MissionContact ON Contact.code_name_contact = MissionContact.code_name_contact'
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
                if ($mission->getId_code_mission() === $contact->getId_code_mission()) {
                    $mission->addContacts($contact);
                }
            }
        }
    }
}