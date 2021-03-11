<?php

define("DEBUGID", $channelid); 
define("DEBUG", true);


function sendDebugRes($method, $res) {
	if(DEBUG == true)
		return sendMess(DEBUGID,"<b>$method</b>:\n\n" . json_encode($res,JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT));
}

?>