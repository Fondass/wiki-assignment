<?php



class Register extends Wiki
{
    
    public function bodyContent()
    {
        if (isset($_POST["registerbutt"]))
        {
            $this->showRegFormFilled();
        }
        else
        {
            $this->showRegisterForm();
        }
    }

    protected function showRegisterForm() 
    { 
        $reg = '<h1>Register</h1>';

        $reg .= '<form name="register" action="" method="POST">';

        $reg .= '
                Username: 
                <input type="text" name="regusername" value="" required /><br />
                ';

        $reg .= '
                Wachtwoord: 
                <input type="password" name="regpw" value=""  required /><br /><br />
                <input type="submit" name="registerbutt" value="Register Now" /><br />
                ';
        $reg .= '</form>';
        echo $reg;
    }
    
    
    protected function saveUserData()
    {
        
        $usern = htmlspecialchars($_POST["regusername"], ENT_QUOTES, "UTF-8");
        $pasw = htmlspecialchars($_POST["regpw"], ENT_QUOTES, "UTF-8");
        
        $this->db->saveNewUser($usern, $pasw);
    }
    
    //=========================================
    
    protected function showRegFormFilled() 
    { 
        $this->saveUserData();
        echo 'thank you so much for registering';
    }
}
