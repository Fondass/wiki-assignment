<?php
	
require_once("class.search.php");

//================================================

class Searchresult extends Wiki
{
    var $tag = array();
    var $db;
    var $search;
    var $user;
    var $title;
        
//================================================         
    //takes a pagename as a parameter
    public function __construct($tag, $db, $user, $title = false) 
    {
        if (true)//(is_array($tag))
        {
            $this->tag = $tag;
            $this->title = $title;
            $this->db = $db;
            $this->user = $user;
            $this->search = new Search();
        }
        else
        {
            throw new Exception('Page not found.');
        }
    }

//================================================         
    //returns some pages    
    function bodyContent()
    {
        $this->search->seekTitleTag($this->db, $this->tag, $this->title);
    }
}

