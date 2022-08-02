<?php

namespace App\Controllers;

use App\Connection;
use App\model\Stashs;

class StashsController
{
    public function getStashsList(): array
    {
        $stashs = new Stashs((new Connection)->getPdo());
        return $stashs->getStashsList();
    }
}