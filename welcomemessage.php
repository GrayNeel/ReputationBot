<?php

$response = "Ciao <b>" . $user->firstname . "</b>! 👋" . "\n\nBenvenuto nella tua <b>Area Personale!</b>👤\n\n";
             
$rawgrouplist=$db->getUserGroups($user);
$grouplist= [];
$row = [];
$array = [];
foreach($rawgrouplist as $group) {
    if($group[0] != $user->chatid) {
        $groupname = $db->searchGroupName($group[0]);
        if(isset($groupname)) {
            array_push($grouplist,[$group[0],$groupname]); 
        }
    }
}

if(count($grouplist)>0) {
    $response = $response . 
    "☢️ I miei radar rilevano che sei presente in alcuni gruppi in cui sono presente anch'io! Da qui potrai gestirne le informazioni.\n\n" . 
    "📑 Ecco una lista dei gruppi in cui ti ho rilevato:\n\n";
                
    $i=0;
    foreach($grouplist as $group) {
        $i++;
        $response = $response . $i . ". <b><i>" . $group[1] . "</i></b>\n";
        if($i%10 != 0)
            array_push($row,["text" => "$i", "callback_data" => "kb/start/$group[0]"]);
        else{
            array_push($array,$row);
            $row=[];
            array_push($row,["text" => "$i", "callback_data" => "kb/start/$group[0]"]);
        }
    }
            

    array_push($array,$row);
    $response = $response . "\nSeleziona uno dei gruppi cliccando sul numero corrispondente qui in basso.";
    $cbdata="kb/start";
    $db->updateLocation($user,$cbdata);
}else{
    $cbdata="kb/start";
    $db->updateLocation($user,$cbdata);
    $response = $response . "\n\nPurtroppo non sei presente in alcun gruppo in cui ci sono anche io! Inizia ad aggiungermi ai gruppi e poi torna qui per controllare le statistiche!\n\n";
}

?>