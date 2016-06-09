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
     * fonShowLogin is a function that displays the form for logging in.
     * the register button is currently out of order.
     */

    
    public function fonShowLogin() 
    {
        echo '<form method="POST">
            <fieldset><legend>User Login</legend>
            <input type="text" name="usernamefield" placeholder="Username">
            <br>
            <input type="text" name="passwordfield" placeholder="Password">
            <br>
            <input type="submit" name="loginsubmit" value="Login">
            <input type="button" name="registerbutton" value="Register">
            </fieldset></form>';
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
        if ($_SERVER["REQUEST_METHOD"] === "GET" && $this->user->fonLoggedUser() === true)
        {
            echo '<p> Welcome Back pall<p>';
        }
        
        elseif ($_SERVER["REQUEST_METHOD"] === "POST" && $this->user->fonUserCheck() === true)
        {
            echo 'Welcome Back bud';
        }
        
        elseif ($_SERVER["REQUEST_METHOD"] === "POST" && $this->user->fonUserCheck() !== true)
        {
            echo 'The princess is in another castle';
        }
        
        else
        {
            $this-> fonShowLogin();
        }
    }
}
