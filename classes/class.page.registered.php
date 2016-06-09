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
    
    function makeSalt()
    {
        $salt = mcrypt_create_iv(12);
        if ($salt == true)
        {
            return $salt;
        }
        else
        {
            return null;
        }
    }
    
    //=========================================
    
    function saveUserData()
    {
        $salt = $this->makeSalt();
        if ($salt == true)
        {
            $result = $this->db->saveNewUser($this->user, $this->pass, $salt);
        }
        
    }
    
    //=========================================
    
    public function bodyContent() 
    { 
        $this->saveUserData();
        echo 'thank you so much for registering';
    }
}
