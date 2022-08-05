<?php

use App\Auth;

if (strpos($_SERVER['REQUEST_URI'], 'admin')) {
    Auth::check();
    $isAdmin = true;
}
$isEdit = strpos($_SERVER['REQUEST_URI'], 'edit') !== false;

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlentities($title) : 'Mon site' ?></title>
    <link rel="stylesheet" href="<?= $styleFolder . 'settings.css' ?>">
    <link rel="stylesheet" href="<?= $styleFolder . $styleSubFolder . 'style.css' ?>">
</head>
<body>
    <nav class="navbar">
        <a href="<?= $router->url('home') ?>" class="navLink"><h1>Spy Agency</h1></a>
        <ul class="adminMenu">
            <li class="navItem">
                <a href="<?= $router->url('home') ?>" class="navLink homeLink">
                Accueil
                </a>
            </li>
            <li class="navItem">
                <a href="<?= $router->url('admin_mission') ?>" class="navLink">
                    Missions
                </a>
            </li>
            <li class="navItem">
                <a href="<?= $router->url('admin_agent') ?>" class="navLink">
                    Agents
                </a>
            </li>
            <li class="navItem">
                <a href="<?= $router->url('admin_contact') ?>" class="navLink">
                    Contacts
                </a>
            </li>
            <li class="navItem">
                <a href="<?= $router->url('admin_target') ?>" class="navLink">
                    Cibles
                </a>
            </li>
            <li class="navItem">
                <a href="<?= $router->url('admin_stash') ?>" class="navLink">
                    Planques
                </a>
            </li>
            <li class="navItem">
                <a href="<?= $router->url('admin_speciality') ?>" class="navLink">
                    Spécialités
                </a>
            </li>
        </ul>
        <form action="<?= $router->url('logout') ?>" method="POST" class="navLink logoutBtn" >
            <button type="submit" style="background: transparent; border: none" >
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="logoutSvg" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z"/>
                    <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
                </svg>
                Se déconnecter
            </button>
        </form>
    </nav>
    <main>
        <?= $content ?>
    </main>
    <footer class="footer">
        <p>Créé par Mathieu Bouthors</p>
    </footer>
    <script src="../scripts/script.js"></script>
</body>
</html>