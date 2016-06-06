<?php
	
require_once("class.page.php");
require_once("class.db.php");
        
//TODO: this page is only for users that are logged in
        
class Userpanel extends Wiki
{

    var $users = array();
    var $admins = array();
    
    //=====================================================
    
    
    
    //=====================================================

    protected function displayUsers()
    {
        echo "<b>Users:</b><br />";
        echo "<br />";
        
        $this->users = $this->db->getRegularUsers();
        foreach ($this->users as $key => $value)
        {
            echo $value['name'];
            //TODO: add a little make admin checkbox to edit the permissions of users, but only if the loggedin user is admin
            echo "<br />";
        }
        
        echo "<br />";
        echo "<b>Administrators:</b><br />";
        echo "<br />";
        
        $this->admins = $this->db->getAdminUsers();
        foreach ($this->admins as $key => $value)
        {
            echo $value['name'];
            echo "<br />";
        }
    }
    
    //=====================================================

    public function bodyContent() 
    { 

        $this->displayUsers();
    }
}
