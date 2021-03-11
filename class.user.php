<?php

Class User {
    public $userid;
    public $chatid;
    public $firstname;
    public $lastname;
    public $username;
    public $language;
    public $joindate;
    public $lastdate;
    public $cbdata;
    public $isbot;
    public $beastmode;

    /**
     * Reputation variables
     */
    public $reputation;
    public $totmessages;
    public $totmessagestoday;
    public $reputationtoday;
    public $upavailable;
    public $downavailable;

    function __construct($input,$db,$istarget) {

        if($istarget==0){
            $this->userid = $input->userid;
            $this->chatid = $input->chatid;
            $this->firstname = $input->firstname;
            $this->lastname = $input->lastname;
            $this->username = $input->username;
            $this->isbot = $input->isbot;
        }else{
            $this->userid = $input->tuserid;
            $this->chatid = $input->tchatid;
            $this->firstname = $input->tfirstname;
            $this->lastname = $input->tlastname;
            $this->username = $input->tusername;
            $this->isbot = $input->tisbot;
        }

        $this->language = $db->getUserLang($this);
        $this->joindate = $db->getJoinDate($this);
        $this->lastdate = $db->getLastDate($this);
        $this->cbdata = $db->getCbData($this);

        $this->reputation = $db->getReputation($this);
        $this->totmessages = $db->getTotMessages($this);
        $this->totmessagestoday = $db->getTotMessagesToday($this);
        $this->reputationtoday = $db->getReputationToday($this);
        $this->upavailable = $db->getUpAvailable($this);
        $this->downavailable = $db->getDownAvailable($this);
        $this->beastmode = $db->getBeastStatus($this, $input->chatid);
    }

}

?>