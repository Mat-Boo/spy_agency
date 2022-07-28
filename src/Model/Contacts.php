<?php

namespace App\model;

use App\Model\Contact;
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

    public function getContacts()
    {
        if (!is_null($this->pdo)) {
            $stmt = $this->pdo->query("SELECT id_contact, firstname, lastname, birthdate, nationality FROM Contact ORDER BY lastname");
            $contacts = [];
            while ($contact = $stmt->fetchObject(Contact::class)) {
                $contacts[] = $contact;
            }
        }
        return $contacts;
    }

    public function filterContacts(array $filterOptions): array
    {
        if (!is_null($this->pdo)) {
            $contactFilter = isset($filterOptions['contactFilter']) ? " WHERE id_contact IN (" . implode(",", $filterOptions['contactFilter']) . ")" : '';

            $stmt = $this->pdo->query(
                "SELECT id_mission
                FROM MissionContact"
                .$contactFilter
            );
            $missionIdsFromContacts = [];
            while ($missionIdFromContact = $stmt->fetchColumn()) {
                $missionIdsFromContacts[] = $missionIdFromContact;
            }
        }
        return $missionIdsFromContacts;
    }
}