<?php

namespace App\Controllers;

use App\Connection;
use App\model\Stashs;

class StashsController
{
    public function getStashsLists(): array
    {
        $stashs = new Stashs((new Connection)->getPdo());
        return $stashs->getStashsList();
    }
}