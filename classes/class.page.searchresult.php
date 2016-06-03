<?php
	
	//this is a simple search result page. It searches a page based upon an inserted tag and then it returns something.
        //it also does the HTML, but we could put all search functionality into it's own class one day

        require_once("class.page.php");
        require_once("class.db.php");
        //require_once("class.pdo.php");

//================================================

    class Searchresult extends Page
    {
        var $tag = array();
        var $pages = array();
        var $db;
            
        
//================================================         
    //takes a pagename as a parameter

    public function __construct($tag) 
    {
        if (true)//(is_array($tag))
        {
            $this->tag = $tag;
            $this->db = new database();
            var_dump($this->tag);
        }
        else
        {
            throw new Exception('Page not found.');
        }
    }

//================================================         
    //returns an array of pages corresponding to one tag. I am using way too many functions to do this, may need to be reduced

    protected function searchPagesOnTags($val) 
    {
        $this->pages = $this->db->selectPagesOnTag($val);
        return $this->pages;
    }
    
//================================================    
    //prints list of pages corresponding for each tag for each tag in the tag array
    protected function testContent()
    {
        foreach($this->tag as $key => $value)
        {
            $this->searchPagesOnTags($value);
            foreach($this->pages as $key => $value)
            {
                echo '* <a href="?page=wikipage&id='.$value["name"].'">'.$value["name"]."</a><br />";
            }
        }
    }
//================================================         
//returns some pages
    
    function bodyContent()
    {
        $this->testContent();
    }
    
}
