<?php

class Register extends Wiki
{
    public function bodyContent()
    {
        if ((isset($_POST["registerbutt"])) && $_SESSION['register'] === true)
        {
            //var_dump($_SESSION['register']);
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
            //var_dump($_SESSION['register']);
        }
        else
        {
            //this boolean limits the a
            $_SESSION['register'] = true;
            $this->showRegisterForm();
        }
    }

    protected function showRegisterForm() 
    { 
        $reg = '<b>Register</b>';

        $reg .= '<form name="register" action="" method="POST">'
                . '<input type="hidden" name="page" value="register">';

        $reg .= '
                Username: 
                <input type="text" name="regusername" value="" required /><br />
                ';

        $reg .= '
                Wachtwoord: 
                <input type="password" name="regpw" value=""  required /><br /><br />
                CaptCha:
                <input name="captcha" type="text">';
        
        
        
        //TODO: you want to change this into a call to index.php GETS ROUTED in the controller
        //
        //require_once('classes/class.captcha.php'); //please fix this
        $captcha = new Captcha;
        $reg .= '<img src="captcha.png"/><br>';
        
        //$this->captcha->image;
        
        //$reg .= '<img src="helpers/captcha.php" /><br>';
        
        
        
        $reg .= '<input type="submit" name="registerbutt" value="Register Now" /><br />
                ';
        $reg .= '</form>';
        echo $reg;
    }
    
//    protected function saveUserData()
//    {
//        
//        $usern = htmlspecialchars($_POST["regusername"], ENT_QUOTES, "UTF-8");
//        $pasw = htmlspecialchars($_POST["regpw"], ENT_QUOTES, "UTF-8");
//        
//        $this->db->saveNewUser($usern, $pasw);
//    }
    
    //=========================================
    
    function makeSalt()
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
    
    //=========================================
    
    function saveUserData()
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
    
    //=========================================
    
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
