<?php

namespace App\Controllers;

use App\Connection;
use App\Model\Persons;

class PersonsController
{
    public function getPersonsLists(): array
    {
        $personsLists = [];
        foreach(['agent', 'contact', 'target'] as $person) {
            ${$person . 's'} = new Persons((new Connection)->getPdo(), $person);
            $personsLists[$person . 'sList'] = ${$person . 's'}->getPersonsList();
        }
        return $personsLists;
    }
}