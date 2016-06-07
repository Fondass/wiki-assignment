<?php
	
require_once("class.page.php");
require_once("class.db.php");
require_once("class.page.wiki.wikipage.php");
include_once("class.login.php");
require_once("class.debug.php");
require_once("class.page.wiki.php");
require_once("class.page_controller.php");
        
//TODO: this page is only for users that are logged in
        
class Userpanel extends Wiki
{

    var $users = array();
    var $admins = array();
    
    //=====================================================
    
    public function __construct($db, $user, $newadmin = false) 
    {
        $this->db = $db;
        $this->user = $user;
        $this->newadmin = $newadmin;
    }
        
    //=====================================================

    protected function displayUsers()
    {
        if ($this->newadmin !== false)
        {
            $this->db->makeAdmin($this->newadmin);
        }
        
        echo "<b>Users:</b><br />";
        echo "<br />";
        
        $this->users = $this->db->getRegularUsers();
        foreach ($this->users as $key => $value)
        {
            echo $value['name'];
            
            if ($this->db->getUserPermission() || 2)
            {
                $reg = '<form name="promote" action="" method="POST">';
                $reg .= '<input type="hidden" name="page" value="promote"><input type="hidden" name="id" value="'.$value['id'].'"><input type="submit" name="register" value="Make Admin" /><br />';
		$reg .= '</form>';
                echo $reg;
            }
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
        if ($this->user->fonLoggedUser() === true)
        {
            $this->displayUsers();
        }
        else
        {
            echo 'please log in to make use of this functionality'; 
        }
    }
}
