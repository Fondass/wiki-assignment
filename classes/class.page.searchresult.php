<?php
	
	//this is a simple search result page. It searches a page based upon an inserted tag and then it returns something.
        //it also does the HTML, but we could put all search functionality into it's own class one day

        require_once("class.page.php");
        require_once("class.db.php");
        //require_once("class.pdo.php");

//================================================

    class Searchresult extends Wiki
    {
        var $tag = array();
        var $pages = array();
        var $db;
            
        
//================================================         
    //takes a pagename as a parameter

    public function __construct($tag, $db, $user) 
    {
        if (true)//(is_array($tag))
        {
            $this->tag = $tag;
            $this->db = $db;
            $this->user = $user;
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
        $pages = array();
        
        foreach($this->tag as $foo => $bar)
        {
            $bar = strip_tags(htmlspecialchars($bar, ENT_QUOTES, "UTF-8"));
            $this->searchPagesOnTags($bar);
            foreach($this->pages as $key => $value)
            {
                $pages[] = $value["name"];
                //echo '* <a href="?page=wikipage&id='.$value["name"].'">'.$value["name"]."</a><br />";
            }
        }
        
        $newpages = array_merge(array_flip(array_flip($pages)));

        Debug::writeToLogFile("you just preformed a search");
        
        foreach ($newpages as $key => $value)
        {
            echo '* <a href="?page=wikipage&id='.$value.'">'.$value."</a><br />";
        }
    }
//================================================         
//returns some pages
    
    function bodyContent()
    {
        $this->testContent();
    }
    
}
