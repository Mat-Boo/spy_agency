<?php

namespace App\Controllers;

class ManageJsController
{
    public function ManageJs(string $urlName): array
    {
        $jsScripts = [];
        switch ($urlName) {
            case 'mission':
                $jsScripts[] = 'filters';
                $jsScripts[] = 'detailsItem';
            break;
            case 'login':
                $jsScripts[] = 'alertMessage';
            break;
            case 'admin_mission':
                $jsScripts[] = 'filters';
                $jsScripts[] = 'detailsItem';
                $jsScripts[] = 'confirmMessage';
            break;
            case 'admin_agent':
                $jsScripts[] = 'filters';
                $jsScripts[] = 'detailsItem';
                $jsScripts[] = 'confirmMessage';
            break;
            case 'admin_contact':
                $jsScripts[] = 'filters';
                $jsScripts[] = 'detailsItem';
                $jsScripts[] = 'confirmMessage';
            break;
            case 'admin_target':
                $jsScripts[] = 'filters';
                $jsScripts[] = 'detailsItem';
                $jsScripts[] = 'confirmMessage';
            break;
            case 'admin_stash':
                $jsScripts[] = 'filters';
                $jsScripts[] = 'detailsItem';
                $jsScripts[] = 'confirmMessage';
            break;
            case 'admin_speciality':
                $jsScripts[] = 'filters';
                $jsScripts[] = 'detailsItem';
                $jsScripts[] = 'confirmMessage';
            break;
        }
        return $jsScripts;
    }
}