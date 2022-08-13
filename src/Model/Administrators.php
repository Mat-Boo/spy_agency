<?php

namespace App\model;

use App\Model\Administrator;
use App\Model\Exception\NotFoundException;
use PDO;

class Administrators
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function login(array $loginOptions)
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

        return $foundAdmin;
    }

    public function findAdministrator(int $idAdministrator): Administrator
    {
        $query = $this->pdo->prepare(
            "SELECT *
            FROM Administrator
            WHERE id_admin = :id_admin");
        $query->execute(['id_admin' => $idAdministrator]);
        $foundAdmin = $query->fetchObject(Administrator::class);
        if ($foundAdmin === false) {
            throw new NotFoundException('Admin', $idAdministrator);
        }
        return $foundAdmin;
    }
}