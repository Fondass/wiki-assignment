
<?php
	
/* this is an almost empty homepage.
 * 
 * usage: use this as a standard .page
 * require this script, create new Home,
 * call new Home->show()
 * 
 * author: Ian de Jong
 */	

class Home extends Wiki
{
    public function bodyContent() 
    { 
        echo "This is the home page"; 
    }
}
		
