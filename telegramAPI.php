<?php

function request($url) {
	$url = api . $url;
	$url = str_replace(array(" ", "\n", "'", "#"), array("%20", "%0A%0D", "%27", "%23"), $url);
	$CurlSession = curl_init();
	curl_setopt($CurlSession,CURLOPT_URL,$url);
	curl_setopt($CurlSession,CURLOPT_HEADER, false);
	curl_setopt($CurlSession,CURLOPT_RETURNTRANSFER, true);
	$result=curl_exec($CurlSession);
	curl_close($CurlSession);
	return $result;
}

function sendMessageAPI($id, $urltext) {
	if (strpos($urltext, "\n")) $urltext = urlencode($urltext);
	return request("sendMessage?text=$urltext&parse_mode=HTML&chat_id=$id&disable_web_page_preview=true");
}

function inlineKeyboardAPI($layout, $id, $msgtext) {
	if (strpos($msgtext, "\n")) $msgtext = urlencode($msgtext);
	$keyboard = json_encode(array("inline_keyboard" => $layout));
	return request("sendMessage?text=$msgtext&parse_mode=HTML&chat_id=$id&reply_markup=$keyboard&disable_web_page_preview=true");
}

function editTextAPI($layout, $id, $msgid, $msgtext) {
	$keyboard = json_encode(array("inline_keyboard" => $layout));
	return request("editMessageText?chat_id=$id&message_id=$msgid&reply_markup=$keyboard&text=$msgtext&parse_mode=HTML&disable_web_page_preview=true");
}

function updateKeyboardAPI($layout, $id, $msgid) {
	$keyboard = json_encode(array("inline_keyboard" => $layout));
	return request("editMessageReplyMarkup?chat_id=$id&message_id=$msgid&reply_markup=$keyboard");
}

function answerCallbackQueryAPI($cbid) {
	return request("answerCallbackQuery?callback_query_id=$cbid");
}


function answerQueryAPI($q_id, $ans) {
	$res = json_encode($ans);
	return request("answerInlineQuery?inline_query_id=$q_id&results=$res");
}




function sendMess($id, $urltext) {
	if (strpos($urltext, "\n")) $urltext = urlencode($urltext);
	return request("sendMessage?text=$urltext&parse_mode=HTML&chat_id=$id&disable_web_page_preview=true");
}

function inlinekeyboard($layout, $id, $msgtext) {
	if (strpos($msgtext, "\n")) $msgtext = urlencode($msgtext);
	$keyboard = json_encode(array("inline_keyboard" => $layout));
	return request("sendMessage?text=$msgtext&parse_mode=HTML&chat_id=$id&reply_markup=$keyboard&disable_web_page_preview=true");
}

function updateKeyboard($layout, $id, $msgid) {
	$keyboard = json_encode(array("inline_keyboard" => $layout));
	return request("editMessageReplyMarkup?chat_id=$id&message_id=$msgid&reply_markup=$keyboard");
}

function editText($layout, $id, $msgid, $msgtext) {
	$keyboard = json_encode(array("inline_keyboard" => $layout));
	return request("editMessageText?chat_id=$id&message_id=$msgid&reply_markup=$keyboard&text=$msgtext&parse_mode=HTML&disable_web_page_preview=true");
}

function ansquery($q_id, $ans) {
	$res = json_encode($ans);
	return request("answerInlineQuery?inline_query_id=$q_id&results=$res");
}

function answerCallbackQuery($cbid) {
	return request("answerCallbackQuery?callback_query_id=$cbid");
}

?>