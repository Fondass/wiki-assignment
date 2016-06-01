<?php

//this file contains handy functions that perform database queries, please only do this by referencing the functions in the pdo-
//class (not on github) by using the Paamayim Nekudotayim (::) operator

class databases 
{
	public function __construct()
	{
		if (PDODAO::connect() == true)
		{
			
		}
		else
		{
			die("NO DATABASE CONNECTION");
		}
	}
	
//=============================================
	
	//TODO: add more functions here
	
        public function fonSavePageToDatabase($title, $content, $tags)
        {
            
            $user_id = "";
            
            
            
            $sql= 'INSERT INTO pages (name, content, users_id) VALUES
                 ("'.$title.'", "'.$content.'", "'.$user_id.'");';
            PDODAO::doInsertQuery($sql);
            
            $sql= 'SELECT id FROM pages WHERE name="'.$title.'"';
            $statement = PDODAO::prepareStatement($sql);
            $result = PDODAO::getArray($statement);
            

            foreach ($tags as $value)
            {
                $sql= 'INSERT INTO pages_tags (pages_id, tags_id) VALUES ("'.$result.'", "'.$value.'")';
                PDODAO::doInsertQuery($sql);
            }
            
            
            
        }
        
//=============================================
    
    // a function that selects an article in the database based upon it's name.
    // there may be a better pdodao:: function to do this than getArrays
    function selectPagesName($name)
	{
		$sql = 'SELECT * FROM pages WHERE name = "'.$name.'"';
		$statement = PDODAO::prepareStatement($sql);
		return PDODAO::getArrays($statement);
	}
        
//=============================================
    
    // a test function that selects an article in the database based upon id.
    function selectTest($id)
	{
		$sql = "SELECT * FROM pages WHERE id = ".$id;
		$statement = PDODAO::prepareStatement($sql);
		return PDODAO::getArrays($statement);
	}

        
        
?>
