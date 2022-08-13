<?php
use App\Auth;
use App\Controllers\AdministratorsController;
use App\Controllers\ManageJsController;

Auth::check();

if ($isAdmin && !isset($_SESSION['auth'])) {
    header('Location: ' . $this->url('login') . '?forbidden=1');
}

$administrators = new AdministratorsController;

if (isset($_SESSION['auth'])) {
    $foundAdmin = $administrators->findAdministrator(isset($_SESSION['auth']));
}



$manageJsController = new ManageJsController;
$jsScripts = $manageJsController->ManageJs($match['name']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/favicon.ico" />
    <title><?= isset($title) ? htmlentities($title) : 'Mon site' ?></title>
    <link rel="stylesheet" href="<?= $styleFolder . 'settings.css' ?>">
    <link rel="stylesheet" href="<?= $styleFolder . $styleSubFolder . 'style.css' ?>">
</head>
<body>
    <nav class="navbar">
        <a href="<?= $router->url('home') ?>" class="logo"><h1>Spy Agency</h1></a>
        <?php if (isset($_SESSION['auth'])): ?>
            <span class="infoMessage">Bienvenue <strong><?= $foundAdmin->getFirstname() ?></strong>,<br/> Vous êtes connecté en tant qu'<strong>Administrateur</strong>.</span>
        <?php endif ?>
        <div class="menu">
            <ul class="menuList">
                <li class="navItem">
                    <a href="<?= $router->url('home') ?>" class="navLink homeLink">
                        Accueil
                    </a>
                </li>
                <?php if (isset($_SESSION['auth'])): ?>
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
                <?php else: ?>
                    <li class="navItem">
                        <a href="<?= $router->url('mission') ?>" class="navLink">
                            Missions
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
        <?php if (isset($_SESSION['auth'])): ?>
            <form action="<?= $router->url('logout') ?>" method="POST" class="logoutBtn" >
                <button type="submit" style="background: transparent; border: none" >
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="logoutSvg" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z"/>
                        <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
                    </svg>
                    Se déconnecter
                </button>
            </form>
        <?php else: ?>
            <a href="<?= $router->url('login') ?>" class="loginBtn">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="loginSvg" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z"/>
                    <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                </svg>
                Se connecter
            </a>
        <?php endif ?>
        <div class="miniMenuBtns">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="displayMiniMenuBtn" viewBox="0 0 16 16">
                <path fillRule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="closeMiniMenuBtn" viewBox="0 0 16 16">
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
            </svg>
        </div>
    </nav>
    <main>
        <?= $content ?>
    </main>
    <footer class="footer">
        <p>Créé par Mathieu Bouthors</p>
    </footer>
    <?php foreach($jsScripts as $jsScript): ?>
        <script src="<?= $jsScript ?>"></script>
    <?php endforeach ?>
</body>
</html>