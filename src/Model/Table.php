<?php

namespace App\model;

class Table
{
    public function keysClassInArray(): array
    {
        $keys = [];
        foreach($this as $key => $value) {
            $keys[] = $key;
        }

        return $keys;
    }
}