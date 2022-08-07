<?php

namespace App\Controllers;

class ManageJsController
{
    public function ManageJs(string $urlName): array
    {
        $jsScripts = [];
        switch ($urlName) {
            case 'mission':
                $jsScripts[] = 'scripts\filters.js';
                $jsScripts[] = 'scripts\detailsItem.js';
            break;
            case 'login':
                $jsScripts[] = 'scripts\alertMessage.js';
            break;
            case 'admin_mission':
                $jsScripts[] = '..\scripts\filters.js';
                $jsScripts[] = '..\scripts\detailsItem.js';
                $jsScripts[] = '..\scripts\confirmMessage.js';
            break;
            case 'admin_agent':
                $jsScripts[] = '..\scripts\filters.js';
                $jsScripts[] = '..\scripts\detailsItem.js';
                $jsScripts[] = '..\scripts\confirmMessage.js';
            break;
            case 'admin_contact':
                $jsScripts[] = '..\scripts\filters.js';
                $jsScripts[] = '..\scripts\detailsItem.js';
                $jsScripts[] = '..\scripts\confirmMessage.js';
            break;
            case 'admin_target':
                $jsScripts[] = '..\scripts\filters.js';
                $jsScripts[] = '..\scripts\detailsItem.js';
                $jsScripts[] = '..\scripts\confirmMessage.js';
            break;
            case 'admin_stash':
                $jsScripts[] = '..\scripts\filters.js';
                $jsScripts[] = '..\scripts\detailsItem.js';
                $jsScripts[] = '..\scripts\confirmMessage.js';
            break;
            case 'admin_speciality':
                $jsScripts[] = '..\scripts\filters.js';
                $jsScripts[] = '..\scripts\detailsItem.js';
                $jsScripts[] = '..\scripts\confirmMessage.js';
            break;
            case 'admin_mission_edit':
                $jsScripts[] = '..\..\..\scripts\alertMessage.js';
                $jsScripts[] = '..\..\..\scripts\specialitiesHover.js';
            break;
            case 'admin_mission_new':
                $jsScripts[] = '..\..\scripts\alertMessage.js';
                $jsScripts[] = '..\..\..\scripts\specialitiesHover.js';
            break;
            case 'admin_agent_edit':
                $jsScripts[] = '..\..\..\scripts\alertMessage.js';
            break;
            case 'admin_agent_new':
                $jsScripts[] = '..\..\scripts\alertMessage.js';
            break;
            case 'admin_contact_edit':
                $jsScripts[] = '..\..\..\scripts\alertMessage.js';
            break;
            case 'admin_contact_new':
                $jsScripts[] = '..\..\scripts\alertMessage.js';
            break;
            case 'admin_target_edit':
                $jsScripts[] = '..\..\..\scripts\alertMessage.js';
            break;
            case 'admin_target_new':
                $jsScripts[] = '..\..\scripts\alertMessage.js';
            break;
            case 'admin_stash_edit':
                $jsScripts[] = '..\..\..\scripts\alertMessage.js';
            break;
            case 'admin_stash_new':
                $jsScripts[] = '..\..\scripts\alertMessage.js';
            break;
            case 'admin_speciality_edit':
                $jsScripts[] = '..\..\..\scripts\alertMessage.js';
            break;
            case 'admin_speciality_new':
                $jsScripts[] = '..\..\scripts\alertMessage.js';
            break;
        }
        return $jsScripts;
    }
}