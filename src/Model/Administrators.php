<?php

namespace App\model;

use App\Model\Exception\NotFoundException;
use PDO;

class Administrators
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function login(array $loginOptions): Administrator
    {
        $query = $this->pdo->prepare(
            "SELECT * FROM Administrator
            WHERE email = :email"
        );
        $query->execute(
            [
                'email' => $loginOptions['email']
            ]
        );
        $foundAdmin = $query->fetchObject(Administrator::class);
        if ($foundAdmin ===false) {
            throw new NotFoundException('Administrator', $loginOptions['email']);
        }
        return $foundAdmin;
    }
}