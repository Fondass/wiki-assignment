<?php
	
	//this is a simple search result page. It searches a page based upon an inserted tag and then it returns something.
        //it also does the HTML, but we could put all search functionality into it's own class one day

        require_once("class.page.php");
        require_once("class.db.php");
        //require_once("class.pdo.php");

//================================================

    class Searchresult extends Page
    {
        var $tag = "";
        var $pages = array();
        var $db;
            
        
//================================================         
    //takes a pagename as a parameter

    public function __construct($tag) 
    {
        if(is_int($tag))
        {
            $this->tag = $tag;
            $this->db = new database();
        }
        else
        {
            throw new Exception('Page not found.');
        }
    }

//================================================         
    //returns an array of pages

    protected function searchPagesOnTags() 
    {
        $this->pages = $this->db->selectPagesOnTag($this->tag);
        return $this->pages;
    }
    
//================================================    
    protected function testContent()
    {
        $this->searchPagesOnTags();
        
        foreach($this->pages as $key => $value)
        {
            echo '* <a href="?page=wikipage&id='.$value["name"].'">'.$value["name"]."</a><br />";
        }
    }
//================================================         
//returns some pages
    
    function bodyContent()
    {
        $this->testContent();
    }
    
}
