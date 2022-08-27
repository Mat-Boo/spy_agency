<?php
namespace App\Class;

class Auth
{
    public static function check()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}