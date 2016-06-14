<?php
	
	//this generate a wiki page based upon data from the page and pages_tags tables in the database

        require_once("class.page.php");
        require_once("class.page.wiki.php");
        require_once("class.db.php");
        require_once("class.login.php");
        require_once("class.editor.strconverter.php");
        require_once("class.editor.inputbuttons.php");
        require_once("class.rating.php");


//================================================

	class Wikipage extends Wiki
        {
            var $pagename = "";
            var $wikipage = array();
            var $db;

//===================================================            
            //takes a pagename as a parameter
            
            public function __construct($pagename, $db, $user) 
            {
                if(is_string($pagename))
                {
                    $this->pagename = htmlspecialchars($pagename, ENT_QUOTES, "UTF-8");
                    $this->db = $db;
                    $this->user = $user;
                    $this->converter = new FonStrConverter();
                    $this->buttons = new FonInputButtons();
                    $this->rating = new FonRatingSystem($db);
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
                
                
                $content = $this->converter->fonConverterScrambledToShow($this->wikipage[0]["content"]);
                
                
                echo '<fieldset id="wikigenfield"><legend>
                    <h3 id="wikigentitle">'.$this->wikipage[0][1].'</h3></legend>
                    <p id="wikigencontent">'.$content.'
                    </p>
                    <form method="POST" action="index.php?page=editor&id='.$this->pagename.'">
                    <input type="submit" name="editbutton" value="Edit">
                    </form></fieldset> 
                    <p id="wikigentags"></p>';
                

                
               /* 
                echo "Article name: ".$this->wikipage[0]['name'];
                echo "<br />Article id: ".$this->wikipage[0]['id'];
                echo "<br />Page content: ".$this->wikipage[0]['content'];
                echo "<br />Creator id: ".$this->wikipage[0]['users_id'];
                echo "<br />Tag id's: ";
                
                
                */
                foreach ($this->wikipage as $value)
                {
                    echo $value[10]." - ";
                }
                
                $pageid = $this->wikipage[0][0];
                
                echo '<div id="ratingshow"><p id=ratingshowref>'.$this->rating->fonRatingShow($pageid).'</p>/10</div>';
                echo $this->rating->ratingFormShow($pageid);
                
            }

//===================================================
            
            //TODO: add variables and functions unique to the home page

            function bodyContent() 
                { 
                    $this->wikiContent();
                }
        }
        
