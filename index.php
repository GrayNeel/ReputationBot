<?php

include "pvt.php";
define('token', $token);
define('api', 'https://api.telegram.org/bot' . token . '/');

$content = file_get_contents("php://input");
$update = json_decode($content, true); 

include "variables.php";
include "basefunctions.php";
include "sql.php";
include "log.php";
include "functions.php";
//include "admincommands.php"; 

if($type != "") {
	switch ($type) {
		case "group":
			handleGroupUpdate($userid, $chatid, $tor, $text, $update);
		break;
		case "supergroup":
			handleGroupUpdate($userid, $chatid, $tor, $text, $update);
		break;
		case "private":
			handlePrivateUpdate($userid, $chatid, $tor, $text, $update);
		break;
	}
}else{
	switch ($tor) {
		case IS_CBQUERY:
			sendDebugRes("CALLBACK QUERY", $update);
			answerCallbackQuery($cbid);
		break;
		case IS_ILQUERY:
			sendDebugRes("INLINE QUERY", $update);
		break;
	}
}
exit(0);
?>
