<?php

namespace App\Controllers;

use App\Connection;
use App\model\Specialities;

class SpecialitiesController
{
    public function getSpecialitiesList(): array
    {
        $specialities = new Specialities((new Connection)->getPdo());
        return $specialities->getSpecialitiesList();
    }
}