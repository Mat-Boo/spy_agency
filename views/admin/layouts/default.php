<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlentities($title) : 'Mon site' ?></title>
    <link rel="stylesheet" href="style.scss">
</head>
<body>
    <nav class="navbar">
        <h1>Spy Agency</h1>
        <form action="<?= $router->url('logout') ?>" method="POST">
            <button type="submit" class="navLink" style="background: transparent; border: none" >Se déconnecter</button>
        </form>
    </nav>
    <main>
        <ul class="navbar">
            <li class="navItem">
                <a href="<?= $router->url('admin_missions') ?>" class="navLink">Missions</a>
            </li>
            <li class="navItem">
                <a href="<?= $router->url('admin_agents') ?>" class="navLink">Agents</a>
            </li>
            <li class="navItem">
                <a href="<?= $router->url('admin_contacts') ?>" class="navLink">Contacts</a>
            </li>
            <li class="navItem">
                <a href="<?= $router->url('admin_targets') ?>" class="navLink">Cibles</a>
            </li>
            <li class="navItem">
                <a href="<?= $router->url('admin_stashs') ?>" class="navLink">Planques</a>
            </li>
            <li class="navItem">
                <a href="<?= $router->url('admin_specialities') ?>" class="navLink">Spécialités</a>
            </li>
        </ul>
        <?= $content ?>
    </main>
    <footer class="footer">
        <p>Créé par Mathieu Bouthors</p>
    </footer>
</body>
</html>