<?php

require_once("class.page.php");
require_once("class.db.php");

class Registered extends Page
{
    var $user;
    var $pass;
    var $db;
    
    //=========================================
    
    function __construct($user,$pass)
    {
        $this->db = new database();
        $this->user = $user;
        $this->pass = $pass;        
    }
    
    //=========================================
    
    function saveUserData()
    {
        $result = $this->db->saveNewUser($this->user, $this->pass);
    }
    
    //=========================================
    
    public function bodyContent() 
    { 
        $this->saveUserData();
        echo 'thank you so much for registering';
    }
}
