<?php
	
/* 
 * usage: searchresult page that creates a search class and hands it 
 * paramters, then calls to it.
 * 
 * author: Ian de Jong
 */

//================================================

class Searchresult extends Wiki
{
    protected $tag = array();
    protected $db;
    public $search;
    protected $user;
    protected $title;
        
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
    public function bodyContent()
    {
        $this->search->seekTitleTag($this->db, $this->tag, $this->title);
    }
}

