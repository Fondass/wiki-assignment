<?php

/*
 * class that houses the different function that involve logging in
 * and checking if the user is logged in.
 * 
 * usage: login checks are stored here. Call functions whenever
 * you wish to log a user in or check if he is correctly logged in.
 * 
 * author: Sybren Bos
 */

class FonLogin
{
    protected $db;
    protected $helper;
    
    public function __construct($db, $helper)
    {
        $this->db = $db;
        $this->helper = $helper;
    }

//================================================
//             check User Credentials
//================================================
/*
 * check's if the entered login credentials are correct.
 * It returns true when a user has succsesfully logged in, and false when a 
 * user entered the wrong username / password.
 */    
//================================================
    
    public function checkCredentials()
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
        
        $pass = $this->db->getPasswordOnUsername($username);
        
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

//================================================
//                  logged user
//================================================
/*
 * loggedUser is a small function that one might call 
 * upppon whenever one sees fit to check if the user 
 * is really logged in. 
 * 
 * This is the function to use to close of certain parts of the website:
 * (returns true if the user is correctly logged in, and false if not)
 */   
//================================================

    public function checkLogged()
    {
        return (isset($_SESSION["username"]) != "");
    }
    
//================================================
//                  user logout
//================================================
/*
 * function to call uppon to log the user out. (alternatively, one can simply 
 * enter session_destroy() whenever.
 */
//================================================
    
    public function logout()
    {
        session_destroy();
        header("location: index.php?page=home");
    }
}
