<?php

// PARAMETRI DA MODIFICARE
$WEBHOOK_URL = "https://provasitopragma.altervista.org/public_html/d4fk1fpZ3Fu1o/344da1A1dDe/index.php"; // URL main BOT (https://xyz.altervista.org/index.php)
$BOT_TOKEN = "1352236052:AAGSGl4Kf2n4AdjvHRQmENjxiKPnNfm79Xc"; // Token

// NON APPORTARE MODIFICHE NEL CODICE SEGUENTE
$parameters = array('url' => $WEBHOOK_URL);
$url = \sprintf('https://api.telegram.org/bot%s/setWebhook?%s', $BOT_TOKEN, \http_build_query($parameters));
$handle = \curl_init($url);
\curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
\curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
\curl_setopt($handle, CURLOPT_TIMEOUT, 60);
$result = \curl_exec($handle);
\curl_close($handle);
\print_r($result);
