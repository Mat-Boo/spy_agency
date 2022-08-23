<?php

use App\Controllers\StashsController;
use App\Controllers\MissionsStashsController;

$stashsController = new StashsController;
$missionsStashsController = new MissionsStashsController;

$codenameStash = $stashsController->findStash($params['id'])->getCode_name();

$missionsStashsController->deleteMissionStashFromStash($params['id']);
$stashsController->deleteStash($params['id']);
header('Location: ' . $router->url('admin_stash') . '?deleted=' . htmlspecialchars($codenameStash));
?>