<?php

$cbdata = explode('/',strtolower($input->cbdata));

$groupname = $db->searchGroupName($cbdata[2]);
$response = "Hai selezionato il seguente gruppo: \n\n👥 <b><i>" . $groupname . "</i></b> 👥\n\n";

    /**
    * Section for user' statistics
    */
    $stats = $db->getUserStatistics($user,$cbdata[2]);
    $statmess = "<b>Reputazione totale</b>: <i>" . $stats[0] . "</i>\n" .
    "<b>Reputazione oggi</b>: <i>" . $stats[1] . "</i>\n" .
    "<b>Totale messaggi inviati</b>: <i>" . $stats[2] . "</i>\n" .
    "<b>Messaggi inviati oggi</b>: <i>" . $stats[3] . "</i>\n" .
    "<b>UP disponibili oggi</b>: <i>" . $stats[4] . "</i>\n" .
    "<b>DOWN disponibili oggi</b>: <i>" . $stats[5] . "</i>" .    
    "\n\n";

/**
 * Check if a group has been selected by user
 */
if(is_numeric($cbdata[count($cbdata)-1])) {

    $res = [];

    $response = $response . $statmess;

    /**
     * Section for Beast Status
     */
    switch($db->getBeastStatus($user,$cbdata[2])){
        case false:
            $beastmodestatus = "DISATTIVATA";
            array_push($res,[["text" => "Attiva Beast Mode", "callback_data" => "kb/start/$cbdata[2]/attiva"]]);
        break;
        default:
            $beastmodestatus = "ATTIVATA";
            array_push($res,[["text" => "Disattiva Beast Mode", "callback_data" => "kb/start/$cbdata[2]/disattiva"]]);
    }

    array_push($res,[["text" => "Indietro", "callback_data" => "kb/start"]]);
    include "messages.php";
    $db->updateLocation($user,$cbdata);
    editTextAPI($res, $user->userid, $input->msgid, $response);
    answerCallbackQueryAPI($input->cbid);
}else{
    switch($cbdata[count($cbdata)-1]){
        case 'start':
            include "welcomemessage.php";
            $db->updateLocation($user,$cbdata);
            editTextAPI($array, $user->userid, $input->msgid, $response);
            answerCallbackQueryAPI($input->cbid);
        break;
        case 'attiva':
            $db->activateBeastMode($user,$cbdata[2]);
            $beastmodestatus = "ATTIVATA";
            $res = [];
            array_push($res,[["text" => "Disattiva Beast Mode", "callback_data" => "kb/start/$cbdata[2]/disattiva"]]);
            array_push($res,[["text" => "Indietro", "callback_data" => "kb/start"]]);
            $response = $response . $statmess;
            include "messages.php";
            editTextAPI($res, $user->userid, $input->msgid, $response);
            answerCallbackQueryAPI($input->cbid);
        break;
        case 'disattiva':
            $db->deactivateBeastMode($user,$cbdata[2]);
            $beastmodestatus = "DISATTIVATA";
            $res = [];
            array_push($res,[["text" => "Attiva Beast Mode", "callback_data" => "kb/start/$cbdata[2]/attiva"]]);
            array_push($res,[["text" => "Indietro", "callback_data" => "kb/start"]]);
            $response = $response . $statmess;
            include "messages.php";
            editTextAPI($res, $user->userid, $input->msgid, $response);
            answerCallbackQueryAPI($input->cbid);
        break;
    }
}




?>