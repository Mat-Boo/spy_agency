<?php
$title = 'Spy Agency - Page introuvable';
$styleFolder = $isAdmin ? '../../../assets/styles/': 'assets/styles/';
$styleSubFolder = 'e404/';
http_response_code(404);
?>
<h1>Page introuvable</h1>
<a href="<?= $router->url('home') ?>" class="backHomeBtnFrom404">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="previousChevron" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
        <path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
    </svg>
    <span>Retour à l'accueil</span>
</a>