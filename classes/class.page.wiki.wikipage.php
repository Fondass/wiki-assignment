<?php
	
	//this generate a wiki page based upon data from the page and pages_tags tables in the database

        require_once("class.page.php");
        require_once("class.page.wiki.php");
        require_once("class.db.php");
        require_once("class.login.php");


//================================================

	class Wikipage extends Wiki
        {
            var $pagename = "";
            var $wikipage = array();
            var $db;

//===================================================            
            //takes a pagename as a parameter
            
            public function __construct($pagename) 
            {
                if(is_string($pagename))
                {
                    $this->pagename = $pagename;
                    $this->db = new database();
                    $this->user = new FonLogin();
                }
                else
                {
                    throw new Exception('Page not found.');
                }
            }
//===================================================
            //
            
            protected function wikiContent()
            {
                $this->wikipage = $this->db->selectPagesName($this->pagename);
                
                echo "Article name: ".$this->wikipage[0]['name'];
                echo "<br />Article id: ".$this->wikipage[0]['id'];
                echo "<br />Page content: ".$this->wikipage[0]['content'];
                echo "<br />Creator id: ".$this->wikipage[0]['users_id'];
                echo "<br />Tag id's: ";
                
                foreach ($this->wikipage as $key => $value)
                {
                    echo $value['tags_id']." ";
                }
                
            }
            
            
//===================================================
            
            //TODO: add variables and functions unique to the home page

            function bodyContent() 
                { 
                    $this->wikiContent();
                }
        }
        
//below is for testing
//$pager = new Wikipage("Doritos");
//$pager->show();
