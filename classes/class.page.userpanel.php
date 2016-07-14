<?php

/* class that pressents the visitor with a list of registered users.
 * neatly sorts them into regular users and admin users.
 * admin can also apoint new admins from this screen.
 * 
 * usage: use this as a standard .page
 * require this script, create new Userpanel,
 * call new Userpanel->show()
 * 
 * author: Ian de Jong
 */
        
class Userpanel extends Wiki
{

    protected $users = array();
    protected $admins = array();
    protected $newadmin;
    
//=====================================================
    
    public function __construct($db, $user, $newadmin = false) 
    {
        $this->db = $db;
        $this->user = $user;
        $this->newadmin = $newadmin;
    }

//================================================
//           userpannel mini controller
//================================================
/*
 * checks to see if the visitor is allowed to 
 * visit the userpanel page. 
 * (unavalable for guests (permission 0))
 */
//================================================ 

    public function bodyContent() 
    { 
        if ($this->user->checkLogged() === true)
        {
            $this->displayUsers();
        }
        else
        {
            echo 'please log in to make use of this functionality'; 
        }
    }
    
//================================================
//                 display users
//================================================
/*
 * shows the userpanel, (a list of users and admins)
 * alsp checks to see if the currently visiting user
 * is an admin, in which case this function allows
 * him/her to make new admins.
 */
//================================================ 

    protected function displayUsers()
    {
        if ($this->newadmin !== false)
        {
            $this->db->saveNewAdmin($this->newadmin);
        }
        
        echo '<b>Users:</b><br><br>';

        $this->users = $this->db->getRegularUsers();
        foreach ($this->users as $key => $value)
        {
            echo $value['name'];
            
            if ($this->db->getUserPermission() == 2)
            {
                echo   '<form name="promote" action="" method="POST">
                        <input type="hidden" name="page" value="promote">
                        <input type="hidden" name="id" value="'.$value['id'].'">
                        <input type="submit" name="register" value="Make Admin"><br>
                        </form>';
            }
            echo '<br>';
        }
        
        echo '<br><b>Administrators:</b><br><br>';
        
        foreach ($this->db->getAdminUsers() as $key => $value)
        {
            echo $value['name'].'<br>';
        }
    }
}