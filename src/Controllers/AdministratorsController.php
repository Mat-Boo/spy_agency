<?php

namespace App\Controllers;

use App\Connection;
use App\model\Administrators;

class AdministratorsController
{
    public function login(array $loginOptions): void
    {
        $administrators = new Administrators((new Connection)->getPdo());
        $foundAdmin = $administrators->login($loginOptions);
        if (password_verify($loginOptions['password'], $foundAdmin->getPassword()) === true) {
            session_start();
            $_SESSION['auth'] = $foundAdmin->getId_admin();
        }
    }
}