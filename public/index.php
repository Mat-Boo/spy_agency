<?php
use App\Router\Router;

require '../vendor/autoload.php';

$router = new Router(dirname(__DIR__) . '/views');
$router
    ->get('/', 'home/index', 'home')
    ->get('/mission', 'mission/index', 'mission')
    ->match('/login', 'auth/login', 'login')
    ->match('/logout', 'auth/logout', 'logout')
//ADMIN
    ->get('/admin', 'admin/index', 'admin')
    // Gestion des missions
    ->match('/admin/mission', 'mission/index', 'admin_mission')
    /* ->match('/admin/mission/[i:id]', 'admin/mission/index', 'admin_mission') */
    ->match('/admin/mission/[i:id]/edit', 'admin/mission/edit', 'admin_mission_edit')
    ->post('/admin/mission/[i:id]/delete', 'admin/mission/delete', 'admin_mission_delete')
    ->match('/admin/mission/new', 'admin/mission/new', 'admin_mission_new')
    // Gestion des agents
    ->match('/admin/agent', 'admin/person/index', 'admin_agent')
    /* ->match('/admin/agent/[i:id]', 'admin/agent/index', 'admin_agent') */
    ->match('/admin/agent/[i:id]/edit', 'admin/person/edit', 'admin_agent_edit')
    ->post('/admin/agent/[i:id]/delete', 'admin/agent/delete', 'admin_agent_delete')
    ->match('/admin/agent/new', 'admin/agent/new', 'admin_agent_new')
    // Gestion des contacts
    ->match('/admin/contact', 'admin/person/index', 'admin_contact')
    /* ->match('/admin/contact/[i:id]', 'admin/contact/index', 'admin_contact') */
    ->match('/admin/contact/[i:id]/edit', 'admin/person/edit', 'admin_contact_edit')
    ->post('/admin/contact/[i:id]/delete', 'admin/contact/delete', 'admin_contact_delete')
    ->match('/admin/contact/new', 'admin/contact/new', 'admin_contact_new')
    // Gestion des cibles
    ->match('/admin/target', 'admin/person/index', 'admin_target')
    /* ->match('/admin/target/[i:id]', 'admin/target/index', 'admin_target') */
    ->match('/admin/target/[i:id]/edit', 'admin/person/edit', 'admin_target_edit')
    ->post('/admin/target/[i:id]/delete', 'admin/target/delete', 'admin_target_delete')
    ->match('/admin/target/new', 'admin/target/new', 'admin_target_new')
    // Gestion des planques
    ->match('/admin/stash', 'admin/stash/index', 'admin_stash')
    /* ->match('/admin/stash/[i:id]', 'admin/stash/index', 'admin_stash') */
    ->match('/admin/stash/[i:id]/edit', 'admin/stash/edit', 'admin_stash_edit')
    ->post('/admin/stash/[i:id]/delete', 'admin/stash/delete', 'admin_stash_delete')
    ->match('/admin/stash/new', 'admin/stash/new', 'admin_stash_new')
    // Gestion des spécialités
    ->match('/admin/speciality', 'admin/speciality/index', 'admin_speciality')
    /* ->match('/admin/speciality/[i:id]', 'admin/speciality/index', 'admin_speciality') */
    ->match('/admin/speciality/[i:id]/edit', 'admin/speciality/edit', 'admin_speciality_edit')
    ->post('/admin/speciality/[i:id]/delete', 'admin/speciality/delete', 'admin_speciality_delete')
    ->match('/admin/speciality/new', 'admin/speciality/new', 'admin_speciality_new')
    ->run();
?>