<?php

function getLinkedName($user) {
    if(isset($user->username)) {
        return "@" . $user->username;
    }else{
        if(isset($user->lastname))
            return $user->firstname . " " . $user->lastname;
        else
            return $user->firstname;
    }

    return null;
}

/**
 * Check if message starts with "+", which is the trigger of the incrementation of reputation
 */
if (substr($input->text, 0, 1) === '+') {
    /**
     * Check if user has up available and it the target user is not a bot
     */
    if($user->upavailable>0 && !($tuser->isbot)) {
        $user->upavailable--;
        $tuser->reputation++;
        $tuser->reputationtoday++; 
        
        $db->updateUser($user);
        $db->updateUser($tuser);

        $response = "Hai incrementato la reputazione di " . 
        getLinkedName($tuser) . 
        "! ($tuser->reputation)\n<i>Hai ancora $user->upavailable + a disposizione.</i>";

        sendMessageAPI($user->chatid,$response);
    }else{
        switch($user->beastmode){
            case true:
                /**
                 * UP target but DOWN user
                 */
                $tuser->reputation++;
                $tuser->reputationtoday++; 
                $user->reputation--;
                $user->reputationtoday--;
                
                //sendMessageAPI($user->chatid,$user->reputationtoday);
                $db->updateUser($user);
                $db->updateUser($tuser);

                $response = "Hai incrementato la reputazione di " . 
                getLinkedName($tuser) . 
                "! ($tuser->reputation)\n<i>Stai utilizzando la modalità bestia di satana e quindi ti sono stati sottratti punti reputazione. La tua nuova reputazione è $user->reputation.</i>";
            break;
            case false:
                /**
                 * Don't do antything
                 */
                $response = "<i>Non hai più UP a disposizione. Attiva la modalità bestia di satana in chat privata con me per continuare ad assegnarne.</i>";
            break;
        }
        sendMessageAPI($user->chatid,$response);
    }
}

if (substr($input->text, 0, 1) === '-') {
    /**
     * Check if user has down available and it the target user is not a bot
     */
    if($user->downavailable>0 && !($tuser->isbot)) {
        $user->downavailable--;
        $tuser->reputation--;
        $tuser->reputationtoday--; 
        
        $db->updateUser($user);
        $db->updateUser($tuser);

        $response = "Hai decrementato la reputazione di " . 
        getLinkedName($tuser) . 
        "! ($tuser->reputation)\n<i>Hai ancora $user->downavailable - a disposizione.</i>";

        sendMessageAPI($user->chatid,$response);
    }
}

?>