<?php
	
	//this sample attempts to generate a html wiki page based upon data from the page table in the database. Later on we may try placing this 
	//kind of functionality in a wikipage class

	class Test extends Wiki
		{
		    var $page = array();
                    
                    function __construct($arr) 
                    {
                            if(is_array($arr))
                            {
                                $this->page = $arr;
                            }
                            else
                            {
                                throw new Exception('Page not found.');
                            }
                    }
                    
            //TODO: add variables and functions unique to the home page
            
                    function bodyContent() 
			{ 
				echo "Article name: ".$this->page[0]['name'];
                                echo "<br />Page content: ".$this->page[0]['content'];
                                echo "<br />Creator id: ".$this->page[0]['users_id'];
			}
		}
