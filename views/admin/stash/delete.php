<?php

use App\Controllers\StashsController;
use App\Controllers\MissionsStashsController;

$stashsController = new StashsController;
$missionsStashsController = new MissionsStashsController;

/* $missionsStashsController->deleteMissionStash($params['id']);
$stashsController->deleteStash($params['id']); */
header('Location: ' . $router->url('admin_stash') . '?delete=' . $params['id']);
?>