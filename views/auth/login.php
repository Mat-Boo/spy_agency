<?php

use App\Controllers\AdministratorsController;

$title = 'Spy Agency - Connexion';
$styleFolder = 'styles/';
$styleSubFolder = 'auth/';

$administrators = new AdministratorsController;

$connectionError = false;
if (!empty($_POST)) {
    if ($administrators->login($_POST)) {
        header('Location: ' . $router->url('admin'));
        exit();
    } else {
        $connectionError = true;
    }
}

?>
<script>
    let emptyGet = <?= json_encode(empty($_GET)) ?>;
</script>
<h1 class="loginTitle">Connexion à l'espace Administration</h1>
<?php if ($connectionError): ?>
    <div class="alertMessage">
        Vos identifiants sont incorrects. Veuillez les corriger et réessayer.
    </div>
<?php elseif (isset($_GET['forbidden'])): ?>
    <div class="alertMessage">
        Veuillez vous authentifier pour pouvoir accéder à cette page.
    </div>
<?php endif ?>
<form action="" method="POST" class="loginForm">
    <div class="emailBox">
        <label for="email">Email</label>
        <input type="email" id="email" name="email">
    </div>
    <div class="pwdBox">
        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password">
    </div>
    <button type="submit" class="loginBtn">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="loginSvg" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z"/>
            <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
        </svg>
        Se connecter
    </button>
</form>