<?php
$isAdmin = strpos($_SERVER['REQUEST_URI'], 'admin') !== false;

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlentities($title) : 'Spy Agency' ?></title>
    <link rel="stylesheet" href="<?= $styleFolder . 'settings.css' ?>">
    <link rel="stylesheet" href="<?= $styleFolder . $styleSubFolder . 'style.css' ?>">
</head>
<body>
    <nav>
        <a href="<?= $router->url('home') ?>" class="navLink"><h1>Spy Agency</h1></a>
        <div>
            <a href="<?= $router->url('home') ?>" class="navLink homeLink">Accueil</a>
            <a href="<?= $router->url('mission') ?>" class="navLink">Missions</a>
        </div>
        <a href="<?= $router->url('login') ?>" class="navLink loginBtn">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="loginSvg" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z"/>
                <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
            </svg>
            Se connecter
        </a>
    </nav>
    <main>
        <?= $content ?>
    </main>
    <footer>
        <p>Créé par Mathieu Bouthors</p>
    </footer>
    <script src="scripts\script.js"></script>
</body>
</html>