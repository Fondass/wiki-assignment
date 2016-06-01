
<?php
	
	//this is a sample home page for now. I will add some links to wiki-pages here so that we can test them.
	
	class Home extends Wiki
		{
		    //TODO: add variables and functions unique to the home page
		    function headerContent() 
			{ 
                            //make sure the local link is correct when testing
                            echo 'Hello world, welcome to the wiki.<br /> <a href="?page=test">Test page.</a>';
			}
		}
		
