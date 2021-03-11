<?php

if (substr($input->text, 0, 1) === '/') {
    $textarraylw = explode(' ',strtolower($input->text));
    $cmd = $textarraylw[0];

    switch ($cmd) {
        case "/start":
            include "welcomemessage.php";
            inlineKeyboardAPI($array, $user->userid, $response);
        break;
    }
}

?>