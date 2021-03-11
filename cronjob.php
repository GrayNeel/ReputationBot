<?php

require_once "pvt.php";
require_once "class.db.php";
define('token', $token);
define('api', 'https://api.telegram.org/bot' . token . '/');
require_once "telegramAPI.php";

$db = new Database();

$grouplist = $db->getGroups();

foreach($grouplist as $group){
    //PER OGNI GRUPPO
    //INVIO MESSAGGIO CON TOP 5 REP E TOP 5 MESS
    $response = "Un altro giorno è passato! Ecco la lista dei migliori utenti del giorno.\n";

    $topmessusers = $db->topMessUsers($group);
    $toprepusers = $db->topRepUsers($group);

    $response = $response . "<b>TOP MESSAGGI</b>\n";
    $i=0;
    foreach($topmessusers as $user) {
        $i++;
        $response = $response . $i . ". " . $user[0] . " (" . $user[3] . ")\n";
    }

    $response = $response . "<b>TOP REPUTAZIONE</b>\n";
    $i=0;
    foreach($toprepusers as $user) {
        $i++;
        $response = $response . $i . ". " . $user[0] . " (" . $user[3] . ")\n";
    }

    sendMessageAPI($group,$response);
}

$db->resetCounters();

?>