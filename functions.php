<?php
include "messages.php";

function topRep($chatid,$n) {
    $usrtab = getUsersRep($chatid);
    $response = "Ecco la lista dei migliori utenti del gruppo:\n\n";

    $i = 1;
    foreach($usrtab as $usr) {
        if(!isset($usr[2]))
            continue;
        if($i == ($n+1))
            break;
        if(isset($usr[1]))
            $response = $response . "$i. " . "<a href=\"https://t.me/" . $usr[1] . "\">" . $usr[1] . "</a> (" . $usr[2] . ") \n";
        else
            $response = $response . "$i. " . $usr[0] . " (" . $usr[2] . ") \n";
        $i++;
    }

    sendMess($chatid,$response);
    return;
}

function myRep($chatid, $userid) {
    $rep = getUserRep($chatid,$userid);
        $username = $GLOBALS['username'];
        $firstname = $GLOBALS['firstname'];
            if(isset($username))
                sendMess($chatid,"La reputazione di <a href=\"https://t.me/$username\">$username</a> è <b>$rep</b>.");
            else
                sendMess($chatid,"La reputazione di $firstname è $rep.");
    return;
}

function incrementReputation($userid, $chatid) {
    $tuserid = $GLOBALS['tuserid'];
    $tisbot = $GLOBALS['tisbot'];

    if($userid == $tuserid || $tisbot == "true")
        return;

    $now = date("Y-m-d H:i:s");
    $tchatid = $GLOBALS['tchatid'];
    $tfirstname = $GLOBALS['tfirstname'];
    $tlastname = $GLOBALS['tlastname'];
    $tusername = $GLOBALS['tusername'];

    $oldrep = getReputation($tuserid,$tchatid);
    if(!isset($oldrep))
        $oldrep=0;
    $newrep = $oldrep+1;
    addReputation($tuserid,$tchatid,$newrep,$tfirstname, $tlastname, $tusername);
    if(isset($tusername))
        sendMess($chatid,"Hai incrementato la reputazione di <a href=\"https://t.me/$tusername\">$tusername</a>! ($newrep)");
    else
        sendMess($chatid,"Hai decrementato la reputazione di $tfirstname! ($newrep)");
    return;
}

function decrementReputation($userid, $chatid) {
    $tuserid = $GLOBALS['tuserid'];
    $tisbot = $GLOBALS['tisbot'];

    if($userid == $tuserid || $tisbot == "true")
        return;
    
    $now = date("Y-m-d H:i:s");
    $tchatid = $GLOBALS['tchatid'];
    $tfirstname = $GLOBALS['tfirstname'];
    $tlastname = $GLOBALS['tlastname'];
    $tusername = $GLOBALS['tusername'];

    $oldrep = getReputation($GLOBALS['tuserid'],$GLOBALS['tchatid']);
    if(!isset($oldrep))
        $oldrep=0;
    $newrep = $oldrep-1;
    
    addReputation($tuserid,$tchatid,$newrep,$tfirstname, $tlastname, $tusername);
    if(isset($tusername))
        sendMess($chatid,"Hai decrementato la reputazione di <a href=\"https://t.me/$tusername\">$tusername</a>! ($newrep)");
    else
        sendMess($chatid,"Hai decrementato la reputazione di $tfirstname! ($newrep)");
    return;
}

function handleGroupUpdate($userid, $chatid, $tor, $text, $update) {
    sendDebugRes("MESSAGE", $update);
    if (substr($text, 0, 1) === '+') {
        if(isset($GLOBALS['tchatid']) && isset($GLOBALS['tuserid'])) {
            incrementReputation($userid, $chatid);
        }
    }

    /*if (substr($text, 0, 1) === '-') {
        if(isset($GLOBALS['tchatid']) && isset($GLOBALS['tuserid']))
            decrementReputation($userid, $chatid);
    }*/

    if (substr($text, 0, 1) === '/') {
        $textarraylw = explode(' ',strtolower($text));
        $cmd = $textarraylw[0];

        switch ($cmd) {
            case "/toprep":
                if(isset($textarraylw[1]) && is_numeric($textarraylw[1])) {
                    $n = $textarraylw[1];
                    if($n > 25 || $n <= 0)
                        $n = 25;
                } else {
                    $n = 10;
                }
                topRep($chatid,$n);
            break;
            case "/toprep@reputationlistbot":
                topRep($chatid,$n);
            break;
            case "/myrep":
                myRep($chatid,$userid);
            break;
            case "/myrep@reputationlistbot":
                myRep($chatid,$userid);
            break;
        }
    }
    return;
}

function handlePrivateUpdate($userid, $chatid, $tor, $text, $update) {
    sendDebugRes("MESSAGE", $update);

    if (substr($text, 0, 1) === '/') {
        $textarraylw = explode(' ',strtolower($text));
        $cmd = $textarraylw[0];

        switch ($cmd) {
            case "/start":
                updateLocation("kb/start", $userid);
                inlinekeyboard([
                    [["text" => "🔎 PRESTO DISPONIBILE!", "callback_data" => "kb/start/0"]] //setto cddata del pulsante a kb/0 e controllerò cbdata dopo per scegliere cosa fare
                  ], $userid, $GLOBALS['start_response']);
            break;
        }
    }
    return;
}

?>