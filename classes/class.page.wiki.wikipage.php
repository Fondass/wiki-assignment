<?php
	
	//this sample attempts to generate a wiki page based upon data from the page table in the database

        //
        require_once("class.page.php");
        require_once("class.page.wiki.php");
        require_once("class.db.php");
        //include('classes/class.page.php');
        require_once("class.login.php");
        //require_once("class.pdo.php");
        //require_once("class.db.php");
        //$this->db = new database();
        
        //define("_LOGPATH_", "logs/");

        //define("PDOdriver", "mysql");
        //define("PDOhost", "localhost");
        //define("PDOuser", "root");
        //define("PDOpass", "");
        //define("PDOdatabase", "wiki");

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
                
                echo "Article name: ".$this->wikipage['name'];
                echo "<br />Page content: ".$this->wikipage['content'];
                echo "<br />Creator id: ".$this->wikipage['users_id'];
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
