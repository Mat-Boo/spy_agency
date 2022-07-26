<?php
$title = 'Spy Agency - Missions';
$styleFolder = 'mission/';

use App\Connection;
use App\Model\Missions;
use App\model\Agents;
use App\model\Contacts;
use App\model\Targets;
use App\model\Stashs;

$pdo = (new Connection)->getPdo();
$missions = new Missions($pdo);
$missionsList = $missions->getMissionsList();

$agents = new Agents($pdo);
$agentsList = $agents->getAgentsList();
$agents->hydrateMissions($missionsList, $agentsList);

$contacts = new Contacts($pdo);
$contactsList = $contacts->getContactsList();
$contacts->hydrateMissions($missionsList, $contactsList);

$targets = new Targets($pdo);
$targetsList = $targets->getTargetsList();
$targets->hydrateMissions($missionsList, $targetsList);

$stashs = new Stashs($pdo);
$stashsList = $stashs->getStashsList();
$stashs->hydrateMissions($missionsList, $stashsList);

?>

<h1 class="missionTitle">Missions</h1>
<ul class="missionsList">
    <?php foreach($missionsList as $mission): ?>
        <li
            class="mission"
            style="background:<?= $mission->getStatus()['background'] ?>">
                <div class="headerMission">
                    <p class="missionItem"><?= $mission->getTitle() ?></p>
                    <p class="missionItem"><?= $mission->getStatus()['status'] ?></p>
                </div>
                <div class="infosMission">

                    <div class="missionItems">
                        <p class="missionItem"><b>Code Name: </b><?= $mission->getId_code_mission() ?></p>
                        <p class="missionItem"><b>Pays: </b><?= $mission->getCountry() ?></p>
                        <p class="missionItem"><b>Type: </b><?= $mission->getType() ?></p>
                        <p class="missionItem"><b>Du </b><?= $mission->getStart_date() ?></p>
                        <p class="missionItem"><b>Au </b><?= $mission->getEnd_date() ?></p>
                    </div>
                </div>
                <div class="details">
                    <div class="detailsBtn">
                        <span>Détails</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="chevron-down" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                        </svg>
                    </div>
                    <div class="detailsInfos">
                        <div class="infosItem description">
                            <span><b>Description :</b></span>
                            <p><?= $mission->getDescription() ?></p>
                        </div>
                        <div class="infosItem speciality">
                            <span><b>Spécialité :</b></span>
                            <p><?= $mission->getSpeciality() ?></p>
                        </div>
                        <div class="infosItem agents">
                            <span><b>Agent(s) :</b></span>
                            <ul>
                            <?php foreach($mission->getAgents() as $agent): ?>
                                <li>
                                    <?= $agent->getFirstname() . ' ' . $agent->getLastname() ?>
                                </li>
                            <?php endforeach ?>
                            </ul>
                        </div>
                        <div class="infosItem contacts">
                            <span><b>Contact(s) :</b></span>
                            <ul>
                            <?php foreach($mission->getContacts() as $contact): ?>
                                <li>
                                    <?= $contact->getFirstname() . ' ' . $contact->getLastname() ?>
                                </li>
                            <?php endforeach ?>
                            </ul>
                        </div>
                        <div class="infosItem targets">
                            <span><b>Target(s) :</b></span>
                            <ul>
                            <?php foreach($mission->getTargets() as $target): ?>
                                <li>
                                <?= $target->getFirstname() . ' ' . $target->getLastname() ?>
                                </li>
                            <?php endforeach ?>
                            </ul>
                        </div>
                        <div class="infosItem stashs">
                            <span><b>Stash(s) :</b></span>
                            <ul>
                            <?php foreach($mission->getStashs() as $stash): ?>
                                <li>
                                    <p><?= $stash->getType() ?></p>
                                    <p><?= $stash->getAddress() ?></p>
                                </li>
                            <?php endforeach ?>
                            </ul>
                        </div>
                    </div>
                </div>
        </li>
    <?php endforeach ?>
</ul>