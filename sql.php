<?php

$dbconn = mysqli_connect($where, $name, $pass, $dbname);
if (mysqli_connect_errno($dbconn)) {
	sendMess($userid,"Errore connessione DB.");
	exit;
}

$now = date("Y-m-d H:i:s");

$stmt = mysqli_prepare($dbconn,"INSERT INTO users (userid, chatid, firstname, lastname, username, language, lastdate) VALUES (?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE firstname=?, lastname=?, username=?, lastdate=?");
mysqli_stmt_bind_param($stmt, "sssssssssss", $userid, $chatid, $firstname, $lastname, $username, $lang, $now, $firstname, $lastname, $username, $now);
mysqli_stmt_execute($stmt);

mysqli_set_charset($dbconn, "utf8mb4");

function getReputation($userid, $chatid) {
	$stmt = mysqli_prepare($GLOBALS["dbconn"],"SELECT reputation FROM users WHERE chatid=? AND userid=?");
	mysqli_stmt_bind_param($stmt,"ss",$chatid,$userid);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $res);
	mysqli_stmt_fetch($stmt);

	return $res;
}

function addReputation($userid, $chatid, $rep, $tfirstname, $tlastname, $tusername) {
	$stmt = mysqli_prepare($GLOBALS["dbconn"],"INSERT INTO users (userid, chatid, firstname, lastname, username) VALUES (?,?,?,?,?) ON DUPLICATE KEY UPDATE reputation=?, firstname=?, lastname=?, username=?");
	mysqli_stmt_bind_param($stmt,"sssssssss",$userid, $chatid,$tfirstname, $tlastname, $tusername, $rep, $tfirstname, $tlastname, $tusername);
	mysqli_stmt_execute($stmt);

	return;
}

function getUsersRep($chatid) {
	$result = mysqli_query($GLOBALS["dbconn"], "SELECT firstname,username,reputation FROM users WHERE chatid='$chatid' ORDER BY reputation DESC");
	$rows = [];
	
	while($row = mysqli_fetch_array($result)) {
    	$rows[] = $row;
	}
	
	return $rows;
}

function getUserRep($chatid, $userid) {
	$stmt = mysqli_prepare($GLOBALS["dbconn"],"SELECT reputation FROM users WHERE chatid=? AND userid=?");
	mysqli_stmt_bind_param($stmt,"ss",$chatid,$userid);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $res);
	mysqli_stmt_fetch($stmt);

	return $res;
}

function updateLocation($cbdata, $userid) {
	$stmt = mysqli_prepare($GLOBALS['dbconn'],"UPDATE users SET cbdata=? WHERE userid=?");
	mysqli_stmt_bind_param($stmt,"ss",$cbdata,$userid);
	mysqli_stmt_execute($stmt);
	return;
}

?>