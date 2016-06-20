<?php

class FonLogin
{

    public function __construct($db, $helper)
    {
        $this->db = $db;
        $this->helper = $helper;
    }
    
    protected $username;
    protected $password;
    protected $db;
    protected $helper;

    /*
     * userCheck is a function that initially runs to see if the entered vallues
     * on the login page (class.page.wiki.login.php) are correct.
     * It returns true when a user has succsesfully logged in, and false when a 
     * user entered the wrong username / password.
     */
     
    public function userCheck()
    {
        $username = $this->helper->specChars($_POST["usernamefield"]);
        
        if (isset ($_POST["passwordfield"]))
        {
            $password = $this->helper->specChars($_POST["passwordfield"]);
            $password .= $this->db->getSalt($username);

            $password = hash("sha256", $password);
        }
        
        else
        {
            $password = "";
        }
        
        $pass = $this->db->checkUserCredentials($username);
        
        if ($this->helper->specChars($password) === $pass)
        {
            $_SESSION["username"] = $username;
            return true;
        }
        else
        {
            return false;
        }
    }
    
    /*
     * loggedUser is a small function that one might call upppon whenever one sees
     * fit to check if the user is really logged in. 
     * 
     * This is the function to use to close of certain parts of the website:
     * 
     * (returns true if the user is correctly logged in, and false if not)
     */
    

    public function loggedUser()
    {
        return (isset($_SESSION["username"]) != "");
    }
    
   /*
    * function to call uppon to log the user out. (alternatively, one can simply 
    * enter session_destroy() whenever.
    */
    
    
    public function userLogout()
    {
        session_destroy();
        header("location: index.php?page=home");
    }
    
}
