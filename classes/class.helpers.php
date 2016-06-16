<?php

/* 
 * this helper class contains usefull functions
 */

class Helpers
{
    static function arrayChecker($keyname, $defaultreturn = false)
    {
        if ($_SERVER["REQUEST_METHOD"]==="POST")
        {
            if (isset($_POST[$keyname]))
            {
                return $_POST[$keyname];
            }
            else
            {
                echo "notset";
                return $defaultreturn;
            }
        }
        if ($_SERVER["REQUEST_METHOD"]==="GET")
        {
            if (isset($_GET[$keyname]))
            {
                return $_GET[$keyname];
            }
            else
            {
                return $defaultreturn;
            }
        }
        return $defaultreturn;
    }
}
