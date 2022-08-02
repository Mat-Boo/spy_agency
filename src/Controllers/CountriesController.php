<?php

namespace App\Controllers;

use App\Connection;
use App\model\Countries;

class CountriesController
{
    public function getCountriesList(): array
    {
        $countries = new Countries((new Connection)->getPdo());
        return $countries->getCountriesList();
    }
}