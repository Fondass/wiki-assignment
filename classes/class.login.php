<?php

class FonLogin
{
    

    public function __construct($db)
    {
        $this->db = $db;
    }
    
    
    protected $username;
    protected $password;
    protected $db;


    /*
     * fonUserCheck is a function that initially runs to see if the entered vallues
     * on the login page (class.page.wiki.login.php) are correct.
     * It returns true when a user has succsesfully logged in, and false when a 
     * user entered the wrong username / password.
     */
    
    
    public function fonUserCheck()
    {
        if (isset ($_POST["usernamefield"]))
        {
            $username = $_POST["usernamefield"];
        }
        
        else
        {
            $username = "";
        }
        
        if (isset ($_POST["passwordfield"]))
        {
            $password = htmlspecialchars($_POST["passwordfield"],ENT_QUOTES, "UTF-8");
            $password .= $this->db->getSalt($username);
            //var_dump($password);
            $password = hash("sha256", $password);
            //var_dump($password);
        }
        
        else
        {
            $password = "";
        }
        
        
        $username = htmlspecialchars($username, ENT_QUOTES, "UTF-8");
        
        $pass = $this->db->fonCheckUserCredentials($username);
        
        if (htmlspecialchars($password, ENT_QUOTES, "UTF-8") === $pass)
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
     * fonLoggedUser is a small function that one might call upppon whenever one sees
     * fit to check if the user is really logged in. 
     * 
     * This is the function to use to close of certain parts of the website:
     * 
     * (returns true if the user is correctly logged in, and false if not)
     */
    

    public function fonLoggedUser()
    {
        return (isset($_SESSION["username"]) != "");
    }
    
   /*
    * function to call uppon to log the user out. (alternatively, one can simply 
    * enter session_destroy() whenever.
    */
    
    
    public function fonUserLogout()
    {
        session_destroy();
    }
    
}
