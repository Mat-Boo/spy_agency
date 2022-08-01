<?php
$isAdmin = strpos($_SERVER['REQUEST_URI'], 'admin') !== false;
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
        <form action="<?= $router->url('logout') ?>" method="POST">
            <button type="submit" class="navLink" style="background: transparent; border: none" >Se déconnecter</button>
        </form>
    </nav>
    <main>
        <?= $content ?>
    </main>
    <footer class="footer">
        <p>Créé par Mathieu Bouthors</p>
    </footer>
    <?php if ($isEdit): ?>
        <script src="../../../scripts/admin/mission/script.js"></script>
    <?php else: ?>
        <script src="../scripts/mission/script.js"></script>
    <?php endif ?>
</body>
</html>