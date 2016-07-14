<?php

/*
 * class that is pressents the user with a form, with which the visitor
 * can login (if he enters the correct information). works in lcose
 * cohesion with class.login.php
 * 
 * usage: use this as a standard .page
 * require this script, create new Login,
 * call new login->show()
 * 
 * author: Sybren Bos
 */

class FonLoginPage extends Wiki
{
    
    protected $db;
    protected $user;
    
//================================================
//                    show Login
//================================================
/*
 * showLogin displays the form for logging in.
 */  
//================================================
    public function showLogin() 
    {
        echo '
            <div id="menulogindiv"><form method="POST">
            <input type="hidden" name="page" value="login">
            <fieldset><legend>User Login</legend>
            
            <input type="text" name="usernamefield" placeholder="Username" required>
            <br>
            <input type="password" name="passwordfield" placeholder="Password" required>
            <br>
            <input type="submit" name="loginsubmit" value="Login">
            <a href=index.php?page=register>
            <div id="registerbutton"> register </div></a>
            </fieldset></form></div>';
    }

//================================================
//                    show Login
//================================================
/*
 * bodyContent decides what to pressent to the
 * user uppon visiting the login page and 
 * displays either a login form (showlogin) or
 * now the home page.
 */
//================================================
    
    public function bodyContent()
    {
        if ($_SERVER["REQUEST_METHOD"] === "GET" && $this->user->checkLogged() === true)
        {
            // activates when a user visist the login page when already logged in
            
            echo '<p>Welcome Back pall<p>';
        }
        
        elseif ($_SERVER["REQUEST_METHOD"] === "POST" && $this->user->checkCredentials() === true)
        {
            // Activates when a user logs in from logged out state.
            
            echo "<meta http-equiv='refresh' content='0'>"; 
        }
        
        elseif ($_SERVER["REQUEST_METHOD"] === "POST" && $this->user->checkCredentials() !== true)
        {
            // activates when a user tries to log in from a logged out state but fails the
            // userCheck(), and thus, provided wrong login credentials.
            
            echo 'The princess is in another castle';
        }
        
        else
        {
            $this-> showLogin();
        }
    }
}
