<?php

/** This section of the code defines all required variables
 * by getting information from Telegram Bot's update.
 */

/** These variables are just to identify the type of request that will be used in the index.php switch. */
define("IS_CBQUERY", 10);
define("IS_MESSAGE", 11);
define("IS_ILQUERY", 12);

if (!$update) exit;

$text = isset($update['message']['text']) ? trim($update['message']['text']) : "";
$cbdata = $update['callback_query']['data']; 
$msgid = $update['callback_query']['message']['message_id'];
$cbid = $update['callback_query']['id'];
$ilqid = $update["inline_query"]["id"];
$ilquery = $update["inline_query"]["query"];
$type = isset($update["message"]["chat"]["type"]) ? $update["message"]["chat"]["type"] : "";
$chatid = isset($update["message"]["chat"]["id"]) ? $update["message"]["chat"]["id"] : "";


//TARGET
$tchatid = $update["message"]["reply_to_message"]["chat"]["id"];
$tuserid = $update["message"]["reply_to_message"]["from"]["id"];
$tfirstname =$update["message"]["reply_to_message"]["from"]["first_name"];
$tlastname = $update["message"]["reply_to_message"]["from"]["last_name"];
$tusername = $update["message"]["reply_to_message"]["from"]["username"];
$tisbot = $update["message"]["reply_to_message"]["from"]["is_bot"];

if (isset($update['callback_query'])) {
	$userid = $update['callback_query']['from']['id'];
	$firstname = $update['callback_query']['from']['first_name'];
	$lastname = isset($update['callback_query']['from']['last_name']) ? $update['callback_query']['from']['last_name'] : "";
	$username = isset($update['callback_query']['from']['username']) ? $update['callback_query']['from']['username'] : "";
	$lang = isset($update['callback_query']['from']['language_code']) ? $update['callback_query']['from']['language_code'] : "";
	$tor = IS_CBQUERY;
}
else if (isset($update['inline_query'])) {
	$userid = $update['inline_query']['from']['id'];
	$firstname = $update['inline_query']['from']['first_name'];
	$lastname = isset($update['inline_query']['from']['last_name']) ? $update['inline_query']['from']['last_name'] : "";
	$username = isset($update['inline_query']['from']['username']) ? $update['inline_query']['from']['username'] : "";
	$lang = isset($update['inline_query']['from']['language_code']) ? $update['inline_query']['from']['language_code'] : "";
	$tor = IS_ILQUERY;
}
else if (isset($update['message'])) {
	$userid = $update['message']['from']['id'];
	$firstname = $update['message']['from']['first_name'];
	$lastname = isset($update['message']['from']['last_name']) ? $update['message']['from']['last_name'] : "";
	$username = isset($update['message']['from']['username']) ? $update['message']['from']['username'] : "";
	$lang = isset($update['message']['from']['language_code']) ? $update['message']['from']['language_code'] : "";
	$tor = IS_MESSAGE;
}
$nametext = $firstname . " " . $lastname;

?>