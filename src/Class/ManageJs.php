<?php

namespace App\Class;

class ManageJs
{
    public function manageJs(string $urlName): array
    {
        $jsScripts = [];
        switch ($urlName) {
            case 'home':
                $jsScripts[] = 'assets\scripts\miniMenu.js';
                $jsScripts[] = 'assets\scripts\infoMessage.js';
            break;
            case 'mission':
                $jsScripts[] = 'assets\scripts\miniMenu.js';
                $jsScripts[] = 'assets\scripts\filtersMission.js';
                $jsScripts[] = 'assets\scripts\detailsItem.js';
            break;
            case 'mission_view':
                $jsScripts[] = '..\assets\scripts\miniMenu.js';
            break;
            case 'admin':
                $jsScripts[] = 'assets\scripts\miniMenu.js';
                $jsScripts[] = 'assets\scripts\infoMessage.js';
            break;
            case 'login':
                $jsScripts[] = 'assets\scripts\miniMenu.js';
                $jsScripts[] = 'assets\scripts\alertMessage.js';
            break;
            case 'admin_mission':
                $jsScripts[] = '..\assets\scripts\miniMenu.js';
                $jsScripts[] = '..\assets\scripts\filtersMission.js';
                $jsScripts[] = '..\assets\scripts\detailsItem.js';
                $jsScripts[] = '..\assets\scripts\confirmMessage.js';
            break;
            case 'admin_mission_view':
                $jsScripts[] = '..\..\assets\scripts\miniMenu.js';
            break;
            case 'admin_agent':
                $jsScripts[] = '..\assets\scripts\miniMenu.js';
                $jsScripts[] = '..\assets\scripts\filtersPerson.js';
                $jsScripts[] = '..\assets\scripts\detailsItem.js';
                $jsScripts[] = '..\assets\scripts\confirmMessage.js';
            break;
            case 'admin_contact':
                $jsScripts[] = '..\assets\scripts\miniMenu.js';
                $jsScripts[] = '..\assets\scripts\filtersPerson.js';
                $jsScripts[] = '..\assets\scripts\detailsItem.js';
                $jsScripts[] = '..\assets\scripts\confirmMessage.js';
            break;
            case 'admin_target':
                $jsScripts[] = '..\assets\scripts\miniMenu.js';
                $jsScripts[] = '..\assets\scripts\filtersPerson.js';
                $jsScripts[] = '..\assets\scripts\detailsItem.js';
                $jsScripts[] = '..\assets\scripts\confirmMessage.js';
            break;
            case 'admin_stash':
                $jsScripts[] = '..\assets\scripts\miniMenu.js';
                $jsScripts[] = '..\assets\scripts\filtersStash.js';
                $jsScripts[] = '..\assets\scripts\detailsItem.js';
                $jsScripts[] = '..\assets\scripts\confirmMessage.js';
            break;
            case 'admin_speciality':
                $jsScripts[] = '..\assets\scripts\miniMenu.js';
                $jsScripts[] = '..\assets\scripts\filtersSpeciality.js';
                $jsScripts[] = '..\assets\scripts\detailsItem.js';
                $jsScripts[] = '..\assets\scripts\confirmMessage.js';
            break;
            case 'admin_mission_edit':
                $jsScripts[] = '..\..\..\assets\scripts\miniMenu.js';
                $jsScripts[] = '..\..\..\assets\scripts\alertMessage.js';
                $jsScripts[] = '..\..\..\assets\scripts\specialitiesHover.js';
            break;
            case 'admin_mission_new':
                $jsScripts[] = '..\..\assets\scripts\miniMenu.js';
                $jsScripts[] = '..\..\assets\scripts\alertMessage.js';
                $jsScripts[] = '..\..\..\assets\scripts\specialitiesHover.js';
            break;
            case 'admin_agent_edit':
                $jsScripts[] = '..\..\..\assets\scripts\miniMenu.js';
                $jsScripts[] = '..\..\..\assets\scripts\alertMessage.js';
            break;
            case 'admin_agent_new':
                $jsScripts[] = '..\..\assets\scripts\miniMenu.js';
                $jsScripts[] = '..\..\assets\scripts\alertMessage.js';
            break;
            case 'admin_contact_edit':
                $jsScripts[] = '..\..\..\assets\scripts\miniMenu.js';
                $jsScripts[] = '..\..\..\assets\scripts\alertMessage.js';
            break;
            case 'admin_contact_new':
                $jsScripts[] = '..\..\assets\scripts\miniMenu.js';
                $jsScripts[] = '..\..\assets\scripts\alertMessage.js';
            break;
            case 'admin_target_edit':
                $jsScripts[] = '..\..\..\assets\scripts\miniMenu.js';
                $jsScripts[] = '..\..\..\assets\scripts\alertMessage.js';
            break;
            case 'admin_target_new':
                $jsScripts[] = '..\..\assets\scripts\miniMenu.js';
                $jsScripts[] = '..\..\assets\scripts\alertMessage.js';
            break;
            case 'admin_stash_edit':
                $jsScripts[] = '..\..\..\assets\scripts\miniMenu.js';
                $jsScripts[] = '..\..\..\assets\scripts\alertMessage.js';
            break;
            case 'admin_stash_new':
                $jsScripts[] = '..\..\assets\scripts\miniMenu.js';
                $jsScripts[] = '..\..\assets\scripts\alertMessage.js';
            break;
            case 'admin_speciality_edit':
                $jsScripts[] = '..\..\..\assets\scripts\miniMenu.js';
                $jsScripts[] = '..\..\..\assets\scripts\alertMessage.js';
            break;
            case 'admin_speciality_new':
                $jsScripts[] = '..\..\assets\scripts\miniMenu.js';
                $jsScripts[] = '..\..\assets\scripts\alertMessage.js';
            break;
            case 'e404':
                $jsScripts[] = '..\assets\scripts\miniMenu.js';
            break;
        }
        return $jsScripts;
    }
}