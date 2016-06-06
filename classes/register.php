<?php

require_once("class.page.php");

class Register extends Page
{
    function bodyContent() 
    { 
        $reg = '<h1>Register</h1>';

        $reg .= '<form name="register" action="" method="POST">';

        $reg .= '<input type="hidden" name="page" value="registered">
                Username: 
                <input type="text" name="username" value="'.isset($_POST['username']).'" /><br />
                ';
        //if( isset($gegevens['error_pass']) ):
        //	$regels .= $gegevens['error_pass'].'<br />';
        //endif;
        $reg .= '
                Wachtwoord: 
                <input type="password" name="pw" value="" /><br /><br />
                <input type="submit" name="register" value="Register Now" /><br />
                ';
        $reg .= '</form>';
        echo $reg;
    }
}
