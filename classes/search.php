<?php

/* 
 * 
 * 
 * 
 */

require_once ("class.page.php");
require_once ("class.debug.php");
require_once ("class.db.php");
//require_once ("class.pdo.php");


class SearchPage extends Page
{
    var $tags = array();    
    
    public function __construct() 
    {
        $this->db = new database();
    }
    
//================================================         
//takes a pagename as a parameter
    
    protected function searchBox()
    {
        
        $this->tags = $this->db->getTags();
        echo '<div><form method="POST">
            <fieldset>
            <legend>Search page</legend>
            <legend>Tags</legend>
            <input type="hidden" name="page" value="searchresult">';
        
        foreach ($this->tags as $key => $value)
        {
            echo '<input type="radio" name="tagid" value="'.$value["id"].'">'.$value["name"].'</input><br>';
        }   

            //<input type="hidden" name="page" value="searchresult">
            //<input type="radio" name="tagid" value="1">java<br>
            //<input type="radio" name="tagid" value="2">chip<br>
            //<input type="radio" name="tagid" value="3">scombridae<br>
            //<input type="radio" name="tagid" value="4">mammal<br>
            //<input type="radio" name="tagid" value="5">nerd<br>
            //<input type="radio" name="tagid" value="6">error
        echo '</fieldset>
            <input type="submit" name="submit" value="Commit">
            </form></div>'; 
    }
    
    public function bodyContent()
    {
        $this->searchBox();
    }
}
