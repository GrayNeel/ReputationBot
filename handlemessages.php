<?php

switch($input->typeofmsg){
    case "group":
    case "supergroup":
        $group = new Group($input);
        $db->checkInfoGroup($group);
        include "groupmessages.php";
    break;
    case "private":
        include "privatemessages.php";
}

?>