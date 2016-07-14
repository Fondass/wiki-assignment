<?php

/* Register page, shows a form and contains the functions 
 * for the register proces to work. * 
 * 
 * usage: use this as a standard .page
 * require this script, create new register,
 * call new register->show()
 * 
 * author: Ian de Jong
 */

// TODO: move the functions from the view to a model class.

class Register extends Wiki
{
    
    protected $db;
    protected $user;
    
//================================================
//              register controller
//================================================
/*
 * mini controller to control what html will be
 * echo out to the user.
 */  
//================================================
    
    
    public function bodyContent()
    {
        if ((isset($_POST["registerbutt"])) && $_SESSION['register'] === true)
        {

            $_SESSION['register'] = false;
            if(isset($_POST["captcha"]) && $_POST["captcha"]!="" && $_SESSION["code"]==$_POST["captcha"])
            {
                echo 'captcha correct!';
                $this->showRegFormFilled();
            }
            else
            {
                echo 'captcha invalid';
            }
        }
        else
        {
            //this boolean limits the a
            $_SESSION['register'] = true;
            $this->showRegisterForm();
        }
    }

//================================================
//              show register form
//================================================
/*
 * html that shows the form for registerin,
 * as well as making a new captcha object. 
 */  
//================================================  
    
    protected function showRegisterForm() 
    { 
        echo '<b>Register</b>
                <form name="register" action="" method="POST">
                <input type="hidden" name="page" value="register">
                Username: 
                <input type="text" name="regusername" value="" required />
                <br>
                Wachtwoord: 
                <input type="password" name="regpw" value=""  required />
                <br><br>
                CaptCha:
                <input name="captcha" type="text">';
        
        //TODO: you want to change this into a call to index.php GETS ROUTED in the controller
        //
        //require_once('classes/class.captcha.php'); //please fix this
        $captcha = new Captcha;
        echo '<img src="captcha.png"/><br>';
        
        //$this->captcha->image;
        
        //$reg .= '<img src="helpers/captcha.php" /><br>';
        
        echo '<input type="submit" name="registerbutt" value="Register Now" />
            <br></form>'; 
    }
    
//================================================
//                  make salt
//================================================
/*
 * create's a random assortment of characters
 * to add to the users password.
 */  
//================================================
    
    protected function makeSalt()
    {
        $salt = mcrypt_create_iv(32);
        if ($salt == true)
        {
            return $salt;
        }
        else
        {
            return null;
        }
    }
    
//================================================
//              save user data
//================================================
/*
 * aplies salt to the password en sends the
 * data (username, password, and salt) to the
 * database class for further storage.
 */  
//================================================
    
    protected function saveUserData()
    {
        $salt = $this->makeSalt();
                 
        if (is_string($salt))
        {
            $usern = htmlspecialchars($_POST["regusername"], ENT_QUOTES, "UTF-8");
            $pasw = htmlspecialchars($_POST["regpw"], ENT_QUOTES, "UTF-8");
            $pasw .= $salt;
            $pasw = hash("sha256",$pasw);
            $result = $this->db->saveNewUser($usern, $pasw, $salt);
            return $result;
        }
        else
        {
            return false;
        }
    }
    
//================================================
//              show reg form filled
//================================================
/*
 * checks to see if the registration was a 
 * succes and lets it know to the user.
 */  
//================================================
    
    protected function showRegFormFilled() 
    { 
        $success = $this->saveUserData();
        if ($success == true)
        {
            echo ' thank you so much for registering!';
        }
        else
        {
            echo ' but registration failed!';
        }
    }
}
