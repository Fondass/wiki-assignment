<?php

//this file contains handy functions that perform database queries, please only do this by referencing the functions in the pdo-
//class by using the Paamayim Nekudotayim (::) operator

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
	
        function fonSavePageToDatabase()
        {
            $sql= 'INSERT INTO '
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
