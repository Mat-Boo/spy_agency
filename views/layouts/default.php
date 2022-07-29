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
        <a href="<?= $router->url('mission') ?>" class="navLink">Missions</a>
        <form action="<?= $router->url('login') ?>" method="POST">
            <button type="submit" class="navLink" style="background: transparent; border: none" >Se connecter</button>
        </form>
    </nav>
    <main>
        <?= $content ?>
    </main>
    <footer>
        <p>Créé par Mathieu Bouthors</p>
    </footer>
    <script src="script.js"></script>
</body>
</html>