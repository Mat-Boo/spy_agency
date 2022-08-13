<?php

namespace App\Model;

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