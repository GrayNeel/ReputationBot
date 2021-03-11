<?php

$user->messages++;
$user->totmessagestoday++;
$db->updateMessages($user);

/**
 * Check for commands sent in group chats
 */
if (substr($input->text, 0, 1) === '/') {
    $textarraylw = explode(' ',strtolower($input->text));
    $cmd = $textarraylw[0];

    switch ($cmd) {
        case "/toprep":
        case "/toprep@reputationlistbot":
            if(isset($textarraylw[1]) && is_numeric($textarraylw[1])) {
                $n = $textarraylw[1];
                if($n > 25 || $n <= 0)
                    $n = 25;
            } else {
                $n = 10;
            }
            //TODO
            //topRep($chatid,$n);
        break;
        case "/myrep":
        case "/myrep@reputationlistbot":
            //TODO
            //myRep($chatid,$userid);
        break;
        case "/topmess":
        case "/topmess@reputationlistbot":
            if(isset($textarraylw[1]) && is_numeric($textarraylw[1])) {
                $n = $textarraylw[1];
                if($n > 25 || $n <= 0)
                    $n = 25;
            } else {
                $n = 10;
            }
            //TODO
            //topMess($chatid,$n);
        break;
        case "/mymess":
        case "/mymess@reputationlistbot":
            //TODO
            //myMess($chatid, $userid, $nmess);
        break;
    }
}

?>