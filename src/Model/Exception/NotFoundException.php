<?php
namespace App\Model\Exception;

use Exception;

class NotFoundException extends Exception
{
    public function __construct(string $table, $id)
    {
        $this->message = "Aucun enregistrement ne correspond à l'id #$id dans la table '$table'";
    }
}