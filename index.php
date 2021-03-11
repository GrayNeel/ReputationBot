<?php

ini_set('display_errors',true);
define('NOT_TARGET',0);
define('TARGET',1);

require_once "pvt.php";
require_once "JSONObject.php";
require_once "class.db.php";
require_once "class.user.php";
require_once "class.group.php";
require_once "telegramAPI.php";

define('token', $token);
define('api', 'https://api.telegram.org/bot' . token . '/');

$jsonRaw = file_get_contents("php://input");
if($jsonRaw=="")
    exit;

$json = json_decode($jsonRaw, true); 

$input = new JSONObject($json);
$db = new Database();
$user = new User($input,$db,NOT_TARGET);

/**
 * Update user's info in DB
 */
$db->checkInfoUser($user);

/**
 * Check if there's the need of a target user object
 * It will be created if: 
 *  - There is a reply to a message (in order to check if reputation should be added or not)
 *  - User left (to delete infos)
 *  - User joined (to add infos)
 */
if(isset($input->ttype)) {
    $tuser = new User($input,$db,TARGET);
    switch($input->ttype){
        case "reply_to_message":
            include "manageReputation.php";
            break;
        case "left_chat_member":
            include "deletemember.php";
            break;
        case "new_chat_member":
            break;
    }
}else{
    /**
     * ttype is not defined it could be callback_query or inline_query
     */
    switch($input->typeofreq){
        case "message":
            include "handlemessages.php";
            break;
        case "callback_query":
            include "handlecbquery.php";
            break;
        case "inline_query":
            /**
             * Actually not needed. Future updates may include it.
             */
            break;
    }
}

//require_once "class.bot.php";

require_once "log.php";

sendDebugRes("prova", $json);

// CLASSE BOT, UTENTE E DATABASE



?>