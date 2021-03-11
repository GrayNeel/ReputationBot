<?php

class Database {
    public $conn;

    function __construct() {
        $this->conn = mysqli_connect($GLOBALS["where"], $GLOBALS["name"], $GLOBALS["pass"], $GLOBALS["dbname"]);
        if (mysqli_connect_errno($this->conn)) {
            $this->conn=-1;
        }
        mysqli_set_charset($this->conn, "utf8mb4");
    }

    function checkInfoUser($user) {
        $stmt = mysqli_prepare($this->conn,"
        INSERT INTO users (userid, chatid, firstname, lastname, username, language, lastdate) 
        VALUES (?, ?, ?, ?, ?, ?, ?) 
        ON DUPLICATE KEY UPDATE firstname=?, lastname=?, username=?, lastdate=?");
        $now=date("Y-m-d H:i:s");
        mysqli_stmt_bind_param($stmt, "sssssssssss", $user->userid, $user->chatid, $user->firstname, $user->lastname, $user->username, $user->lang, $now, $user->firstname, $user->lastname, $user->username, $now);
        mysqli_stmt_execute($stmt);
    }

    function getUserLang($user) {
        $stmt = mysqli_prepare($this->conn,"
        SELECT language
        FROM users
        WHERE userid=? AND chatid=?");
        mysqli_stmt_bind_param($stmt, "ss",$user->userid,$user->chatid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $res);
    	mysqli_stmt_fetch($stmt);
        
        return $res;
    }

    function getJoinDate($user) {
        $stmt = mysqli_prepare($this->conn,"
        SELECT joindate
        FROM users
        WHERE userid=? AND chatid=?");
        mysqli_stmt_bind_param($stmt, "ss",$user->userid,$user->chatid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $res);
    	mysqli_stmt_fetch($stmt);
        
        return $res;
    }

    function getLastDate($user) {
        $stmt = mysqli_prepare($this->conn,"
        SELECT lastdate
        FROM users
        WHERE userid=? AND chatid=?");
        mysqli_stmt_bind_param($stmt, "ss",$user->userid,$user->chatid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $res);
    	mysqli_stmt_fetch($stmt);
        
        return $res;
    }

    function getCbData($user) {
        $stmt = mysqli_prepare($this->conn,"
        SELECT cbdata
        FROM users
        WHERE userid=? AND chatid=?");
        mysqli_stmt_bind_param($stmt, "ss",$user->userid,$user->chatid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $res);
    	mysqli_stmt_fetch($stmt);
        
        return $res;
    }

    function getReputation($user) {
        $stmt = mysqli_prepare($this->conn,"
        SELECT reputation
        FROM users
        WHERE userid=? AND chatid=?");
        mysqli_stmt_bind_param($stmt, "ss",$user->userid,$user->chatid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $res);
    	mysqli_stmt_fetch($stmt);
        
        return $res;
    }

    function getTotMessages($user) {
        $stmt = mysqli_prepare($this->conn,"
        SELECT messages
        FROM users
        WHERE userid=? AND chatid=?");
        mysqli_stmt_bind_param($stmt, "ss",$user->userid,$user->chatid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $res);
    	mysqli_stmt_fetch($stmt);
        
        return $res;
    }

    function getTotMessagesToday($user) {
        $stmt = mysqli_prepare($this->conn,"
        SELECT messages_today
        FROM users
        WHERE userid=? AND chatid=?");
        mysqli_stmt_bind_param($stmt, "ss",$user->userid,$user->chatid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $res);
    	mysqli_stmt_fetch($stmt);
        
        return $res;
    }

    function getReputationToday($user) {
        $stmt = mysqli_prepare($this->conn,"
        SELECT reputation_today
        FROM users
        WHERE userid=? AND chatid=?");
        mysqli_stmt_bind_param($stmt, "ss",$user->userid,$user->chatid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $res);
    	mysqli_stmt_fetch($stmt);
        
        return $res;
    }

    function getUpAvailable($user) {
        $stmt = mysqli_prepare($this->conn,"
        SELECT up_available
        FROM users
        WHERE userid=? AND chatid=?");
        mysqli_stmt_bind_param($stmt, "ss",$user->userid,$user->chatid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $res);
    	mysqli_stmt_fetch($stmt);
        
        return $res;
    }

    function getDownAvailable($user) {
        $stmt = mysqli_prepare($this->conn,"
        SELECT down_available
        FROM users
        WHERE userid=? AND chatid=?");
        mysqli_stmt_bind_param($stmt, "ss",$user->userid,$user->chatid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $res);
    	mysqli_stmt_fetch($stmt);
        
        return $res;
    }

    function getBeastStatus($user, $chatid) {
        $stmt = mysqli_prepare($this->conn,"
        SELECT beast_mode
        FROM users
        WHERE userid=? AND chatid=?");
        mysqli_stmt_bind_param($stmt, "ss",$user->userid,$chatid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $res);
    	mysqli_stmt_fetch($stmt);
        
        return $res;
    }

    function activateBeastMode($user,$chatid) {
        $stmt = mysqli_prepare($this->conn,"
        UPDATE users 
        SET beast_mode=true
        WHERE userid=? AND chatid=? 
        ");
        mysqli_stmt_bind_param($stmt, "ss",$user->userid,$chatid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $res);
    	mysqli_stmt_fetch($stmt);
        
        return $res;
    }

    function deactivateBeastMode($user,$chatid) {
        $stmt = mysqli_prepare($this->conn,"
        UPDATE users
        SET beast_mode=false
        WHERE userid=? AND chatid=? 
        ");
        mysqli_stmt_bind_param($stmt, "ss",$user->userid,$chatid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $res);
    	mysqli_stmt_fetch($stmt);
        
        return $res;
    }

    function updateUser($user) {
        $stmt = mysqli_prepare($this->conn,"
        UPDATE users 
        SET reputation=?, reputation_today=?, messages=?, messages_today=?, up_available=?, down_available=?
        WHERE userid=? AND chatid=?");
        mysqli_stmt_bind_param($stmt, "ssssssss",$user->reputation,
        $user->reputationtoday,$user->totmessages,$user->totmessagestoday,$user->upavailable,$user->downavailable,$user->userid,$user->chatid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $res);
    	mysqli_stmt_fetch($stmt);
        
        return $res;
    }

    function updateMessages($user) {
        $stmt = mysqli_prepare($this->conn,"
        UPDATE users 
        SET messages=?, messages_today=?
        WHERE userid=? AND chatid=? 
        ");
        mysqli_stmt_bind_param($stmt, "ssss",$user->totmessages,$user->totmessagestoday,$user->userid,$user->chatid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $res);
    	mysqli_stmt_fetch($stmt);
        
        return $res;
    }

    function updateLocation($user,$cbdata) {
        $stmt = mysqli_prepare($this->conn,"
        UPDATE users 
        SET cbdata=?
        WHERE userid=? AND chatid=? 
        ");
        mysqli_stmt_bind_param($stmt, "sss",$cbdata,$user->userid,$user->chatid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $res);
    	mysqli_stmt_fetch($stmt);
        
        return $res;
    }

    function getUserGroups($user) {
        $result = mysqli_query($this->conn, "
        SELECT DISTINCT chatid
        FROM users 
        WHERE userid='$user->userid'");
        $rows = [];
        
        while($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }

        return $rows;
    }

    function checkInfoGroup($group) {
        $stmt = mysqli_prepare($this->conn,"
        INSERT INTO groups (chatid, title, type) 
        VALUES (?, ?, ?) 
        ON DUPLICATE KEY UPDATE title=?, type=?");
        mysqli_stmt_bind_param($stmt, "sssss",$group->chatid,$group->title,$group->type,$group->title,$group->type);
        mysqli_stmt_execute($stmt);
    }

    function searchGroupName($chatid) {
        $stmt = mysqli_prepare($this->conn,"
        SELECT title 
        FROM groups
        WHERE chatid=? 
        ");
        mysqli_stmt_bind_param($stmt,"s",$chatid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $res);
    	mysqli_stmt_fetch($stmt);
        
        return $res;
    }

    function resetCounters() {
        $stmt = mysqli_prepare($this->conn,"
        UPDATE users 
        SET up_available=?, down_available=?, reputation_today=?, messages_today=?");
        $up=10;
        $down=2;
        $mess=0;
        mysqli_stmt_bind_param($stmt,"ssss",$up,$down,$mess,$mess);
        mysqli_stmt_execute($stmt);
        return;
    }

    function getGroups() {
        $result = mysqli_query($this->conn, "
        SELECT DISTINCT chatid
        FROM users
        WHERE chatid<0");
        $rows = [];
           
        while($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
    
        return $rows;
    }

    function topMessUsers($chatid) {
        $result = mysqli_query($this->conn, "
        SELECT firstname, lastname, username, messages_today
        FROM users
        WHERE chatid='$chatid'
        ORDER BY DESC
        LIMIT 5");
        $rows = [];
           
        while($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
    
        return $rows;
    }
    
    function topRepUsers($chatid) {
        $result = mysqli_query($this->conn, "
        SELECT firstname, lastname, username, reputation_today
        FROM users
        WHERE chatid='$chatid'
        ORDER BY DESC
        LIMIT 5");
        $rows = [];
           
        while($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
    
        return $rows;
    }

    function getUserStatistics($user,$chatid) {
        $result = mysqli_query($this->conn, "
        SELECT reputation, reputation_today, messages, messages_today, up_available, down_available
        FROM users
        WHERE chatid='$chatid' AND userid='$user->userid'");
           
        $row = mysqli_fetch_array($result);
        
        return $row;
    }
    
    function deleteUser($user) {
        $stmt = mysqli_prepare($this->conn,"
        DELETE FROM users
        WHERE chatid=? AND userid=?
        ");
        mysqli_stmt_bind_param($stmt,"ss",$user->chatid,$user->userid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $res);
    	mysqli_stmt_fetch($stmt);
        
        return $res;
    }
}

?>