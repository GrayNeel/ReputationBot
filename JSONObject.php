<?php

/**
 * This is a JSON Object which gets all user variables from the JSON decoded string.
 */

Class JSONObject {
    /**
     * Global variables
     */
    public $userid;
    public $firstname;
    public $lastname;
    public $username;
    public $lang;
    public $typeofreq;

    /** 
     * Variables for type MESSAGE 
    */
    public $text;
    public $typeofmsg;
    public $chatid;

    /**
     * Variables for type CALLBACK_QUERY
     */
    public $cbdata;
    public $msgid;
    public $cbid;

    /**
     * Variables for type INLINE_QUERY
     */
    public $ilqid;
    public $ilquery;

    /**
     * Variables for target user (of Reputation)
     */
    public $tchatid;
    public $tuserid;
    public $tfirstname;
    public $tlastname;
    public $tusername;
    public $tisbot;
    /**
     * ttype can be: NULL, new_chat_member, left_chat_member, reply_to_message
     */
    public $ttype;

    /**
     * Group variables
     */
    public $type;
    public $title;
    
    /**
     * JSONObject constructor 
     * @param $json decoded file
     */
    public function __construct($json){
        /**
         * The JSON file contains a message case
         */
        if (isset($json['message'])) {
            $this->text = trim($json['message']['text']);
            $this->userid = $json['message']['from']['id'];
            $this->firstname = $json['message']['from']['first_name'];
            $this->lastname = isset($json['message']['from']['last_name']) ? $json['message']['from']['last_name'] : "";
            $this->username = isset($json['message']['from']['username']) ? $json['message']['from']['username'] : "";
            $this->lang = isset($json['message']['from']['language_code']) ? $json['message']['from']['language_code'] : "";
            $this->typeofmsg = isset($json["message"]["chat"]["type"]) ? $json["message"]["chat"]["type"] : "";
            $this->chatid = isset($json["message"]["chat"]["id"]) ? $json["message"]["chat"]["id"] : "";
            $this->typeofreq = "message";

            /**
             * Checks if the message is from a group or not
             */
            if($this->typeofmsg!="private") {
                $this->title = $json['message']['chat']['title'];
                $this->type = $json['message']['chat']['type'];
            }

            /**
             * Checks if the user is targeting someone for reputation
             */
            if(isset($json['message']['reply_to_message'])) {
                /**
                 * Get target user's informations
                 */
                $this->tchatid = $json["message"]["reply_to_message"]["chat"]["id"];
                $this->tuserid = $json["message"]["reply_to_message"]["from"]["id"];
                $this->tfirstname = isset($json["message"]["reply_to_message"]["from"]["first_name"]) ? $json["message"]["reply_to_message"]["from"]["first_name"] : "";
                $this->tlastname = isset($json["message"]["reply_to_message"]["from"]["last_name"]) ? $json["message"]["reply_to_message"]["from"]["last_name"] : "";
                $this->tusername = $json["message"]["reply_to_message"]["from"]["username"];
                $this->tisbot = $json["message"]["reply_to_message"]["from"]["is_bot"];
                $this->ttype = "reply_to_message";
            }

            /**
             * Checks if a user joined
             */
            if(isset($json['message']['new_chat_member'])) {
                /**
                 * Get target user's informations
                 */
                $this->tchatid = $json["message"]["chat"]["id"];
                $this->tuserid = $json["message"]["new_chat_member"]["id"];
                $this->tfirstname = isset($json["message"]["new_chat_member"]["first_name"]) ? $json["message"]["new_chat_member"]["first_name"] : "";
                $this->tlastname = isset($json["message"]["left_chat_member"]["last_name"]) ? $json["message"]["new_chat_member"]["last_name"] : "";
                $this->tusername = $json["message"]["new_chat_member"]["username"];
                $this->tisbot = $json["message"]["new_chat_member"]["is_bot"];
                $this->ttype = "new_chat_member";
            }

            /**
             * Checks if a user left
             */
            if(isset($json['message']['left_chat_member'])) {
                /**
                 * Get target user's informations
                 */
                $this->tchatid = $json["message"]["chat"]["id"];
                $this->tuserid = $json["message"]["left_chat_member"]["id"];
                $this->tfirstname = isset($json["message"]["left_chat_member"]["first_name"]) ? $json["message"]["left_chat_member"]["first_name"] : "";
                $this->tlastname = isset($json["message"]["left_chat_member"]["last_name"]) ? $json["message"]["left_chat_member"]["last_name"] : "";
                $this->tusername = $json["message"]["left_chat_member"]["username"];
                $this->tisbot = $json["message"]["left_chat_member"]["is_bot"];
                $this->ttype = "left_chat_member";
            }

        }else {
            $this->text = "";
        }

        /**
         * The JSON file contains a callback_query case
         */
        if (isset($json['callback_query'])) {
            $this->userid = $json['callback_query']['from']['id'];
            $this->firstname = $json['callback_query']['from']['first_name'];
            $this->lastname = isset($json['callback_query']['from']['last_name']) ? $json['callback_query']['from']['last_name'] : "";
            $this->username = isset($json['callback_query']['from']['username']) ? $json['callback_query']['from']['username'] : "";
            $this->lang = isset($json['callback_query']['from']['language_code']) ? $json['callback_query']['from']['language_code'] : "";
            $this->typeofreq = 'callback_query';

            $this->cbdata = $json['callback_query']['data']; 
            $this->msgid = $json['callback_query']['message']['message_id'];
            $this->cbid = $json['callback_query']['id'];
        }
        
        /**
         * The JSON file contains an inline_query case
         */
        if (isset($json['inline_query'])) {
            $this->userid = $json['inline_query']['from']['id'];
            $this->firstname = $json['inline_query']['from']['first_name'];
            $this->lastname = isset($json['inline_query']['from']['last_name']) ? $json['inline_query']['from']['last_name'] : "";
            $this->username = isset($json['inline_query']['from']['username']) ? $json['inline_query']['from']['username'] : "";
            $this->lang = isset($json['inline_query']['from']['language_code']) ? $json['inline_query']['from']['language_code'] : "";
            $this->typeofreq = 'inline_query';

            $this->ilqid = $json["inline_query"]["id"];
            $this->ilquery = $json["inline_query"]["query"];
        }
    }
}

?>