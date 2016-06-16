<?php

require_once("class.page.wiki.wikipage.php");
include_once("class.login.php");
require_once("class.debug.php");

class FonLoginPage extends Wiki
{
    /*
     * $this->user means the active user trying to log in or is already logged in
     * for the duration of the session. $this-user is used in any scripts that need
     * to validate if the user is a valid user.
     */
    
    /*
     * showLogin is a function that displays the form for logging in.
     * the register button is currently out of order.
     */

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
      
    /*
     * bodyContent decides what to pressent to the user uppon visiting
     * the login page and displays either:
     * 
     * if: a message or whatever if the user was already logged in and revisiting the page.
     * 
     * elseif: a message or whatever if the user just logged in.
     * 
     * 2cnd elseif: a message or thing if the user failed to log in.
     * 
     * else: a function that runs when the user first arives at this page without having logged in,
     * in this case the ShowLogin funciton that displays a login form.
     */
    
    public function bodyContent()
    {
        if ($_SERVER["REQUEST_METHOD"] === "GET" && $this->user->loggedUser() === true)
        {
            // activates when a user visist the login page when already logged in
            
            echo '<p>Welcome Back pall<p>';
        }
        
        elseif ($_SERVER["REQUEST_METHOD"] === "POST" && $this->user->userCheck() === true)
        {
            // Activates when a user logs in from logged out state.
            
            echo "<meta http-equiv='refresh' content='0'>"; 
        }
        
        elseif ($_SERVER["REQUEST_METHOD"] === "POST" && $this->user->userCheck() !== true)
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
