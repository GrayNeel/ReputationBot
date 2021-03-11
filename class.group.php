<?php

class Group {
    public $chatid;
    public $title;
    public $type;

    function __construct($input){
        $this->chatid = $input->chatid;
        $this->title = $input->title;
        $this->type = $input->type;
    }
}

?>