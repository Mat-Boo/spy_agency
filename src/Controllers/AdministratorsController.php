<?php

namespace App\Controllers;

use App\Class\Connection;
use App\Model\Administrator;
use App\Model\Administrators;

class AdministratorsController
{
    public function login(array $loginOptions): bool
    {
        $found = false;
        $administrators = new Administrators((new Connection)->getPdo());
        $foundAdmin = $administrators->login($loginOptions);
        if ($foundAdmin) {
            if (password_verify($loginOptions['password'], $foundAdmin->getPassword()) === true) {
                session_start();
                $_SESSION['auth'] = $foundAdmin->getId_admin();
                $found = true;
            } else {
                $found = false;
            }
        }
        return $found;
    }

    public function findAdministrator(int $idAdministrator): Administrator
    {
        $administrators = new Administrators((new Connection)->getPdo());
        return $administrators->findAdministrator($idAdministrator);
    }
}