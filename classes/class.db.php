<?php

//this file contains handy functions that perform database queries, please only do this by referencing the functions in the pdo-
//class (not on github) by using the Paamayim Nekudotayim (::) operator

class database
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
//=============================================
		
        public function fonSavePageToDatabase($title, $content, $tags)
        {
            
            /*
             * this function get's data from the (class.page.editor.php)
             * to save a created page into the database.
             * 2 sql statements and a looped sql statement save data into
             * the pages and pages_tags table.
             */
            
            
            $user_id = "";
            
            $sql= 'INSERT INTO pages (name, content, users_id) VALUES
                 ("'.$title.'", "'.$content.'", "'.$user_id.'");';
            PDODAO::doInsertQuery($sql);
            
            $sql= 'SELECT id FROM pages WHERE name="'.$title.'"';
            $statement = PDODAO::prepareStatement($sql);
            $result = PDODAO::getArray($statement);
            
            foreach ($tags as $value)
            {
                $sql= 'INSERT INTO pages_tags (pages_id, tags_id) VALUES ("'.$result[0].'", "'.$value.'")';
                PDODAO::doInsertQuery($sql);
            }
        }
//=============================================

    public function selectPagesOnTag($tag)
    {
        #####this is if you want to accept a tagname instead of a tagid#####
        #$sql = 'SELECT id FROM tags WHERE name = "'.$tag.'"';
        #$statement = PDODAO::prepareStatement($sql);
        #$tagids PDODAO::getArray($statement);
        ####################################################################
        
        $sql = 'SELECT * FROM pages JOIN pages_tags ON pages.id = pages_tags.pages_id WHERE pages_tags.tags_id = '.$tag;
        //$statement = PDODAO::prepareStatement($sql);
        return PDODAO::getDataArrays($sql);
    }

//=============================================    
    
    public function getTags()
	{
            $sql = 'SELECT * FROM tags';
            return PDODAO::getDataArrays($sql);
	}

//=============================================
    
    // a function that selects an article in the database based upon it's name.
    // there may be a better pdodao:: function to do this than getArrays (replaced with getArray)
    public function selectPagesName($name)
    {
        $sql = 'SELECT * FROM pages JOIN pages_tags ON pages.id = pages_tags.pages_id WHERE pages.name = "'.$name.'"';
        return PDODAO::getDataArrays($sql);
    }
        
//=============================================
    
    // a test function that selects an article in the database based upon id.
    public function selectTest($id)
	{
            $sql = "SELECT * FROM pages WHERE id = ".$id;
            $statement = PDODAO::prepareStatement($sql);
            return PDODAO::getArrays($statement);
	}

//=============================================

        public function fonSaveExistingPageToDatabase($title, $content, $tags, $id)
        {
            $sql= 'UPDATE pages SET name="'.$title.'", content="'.$content.'" 
                WHERE id='.$id.';';
            PDODAO::doUpdateQuery($sql);
            
            foreach ($tags as $value)
            {
                $sql2= 'UPDATE pages_tags SET pages_id='.$id.', tags_id='.$value.'
                    WHERE pages_id='.$id.';';
                PDODAO::doUpdateQuery($sql2);
            }
        }
 //=============================================
 
        /*
         * function that get's data from (class.login.php) in the form of a username.
         * the function returns the password that is coupled to the filled in username.
         */
        
        public function fonCheckUserCredentials($username)
        {
            $sql = 'SELECT password FROM users WHERE name="'.$username.'"';
            $statement = PDODAO::prepareStatement($sql);
            $result = PDODAO::getArray($statement);
            
            return $result[0];            
        }
        
//=============================================

	    public function getRegularUsers()
	    {
	        $sql = 'SELECT * FROM users WHERE permission = 1';
	        return PDODAO::getDataArrays($sql);
	    }
	
//=============================================
	
	    public function getAdminUsers()
	    {
	        $sql = 'SELECT * FROM users WHERE permission = 2';
	        return PDODAO::getDataArrays($sql);
	    }

 //=============================================
        
        /*
         * function that returns the permission INT that is coupled with the
         * currently logged in user. (user has to be logged in to use this function
         */
        
        public function fonGetPermission()
        {
            $username = $_SESSION["username"];
            
            if (isset($username) && $username !== "")
            {
                $sql = 'SELECT permission FROM users WHERE name="'.$username.'"';
                $statement = PDODAO::prepareStatement($sql);
                $result = PDODAO::getArray($statement);

                return $result[0];
            }
            else 
            {
                return 0;
            }
        }
//=============================================        
        public function fonGetActiveUserId()
        {
            $username = $_SESSION["username"];
            
            if (isset($username) && $username !== "")
            {
                $sql = 'SELECT id FROM users WHERE name="'.$username.'"';
                $statement = PDODAO::prepareStatement($sql);
                $result = PDODAO::getArray($statement);

                return $result[0];
            }
        }
        
//=============================================
        
        public function fonPageOwnerIsAdmin($pagename)
        {
            $sql = 'SELECT users_id FROM pages WHERE name = "'.$pagename.'"';
            $statement = PDODAO::prepareStatement($sql);
            $result = PDODAO::getArray($statement);
            
            $sql2 = 'SELECT permission FROM users WHERE id ='.$result[0].'';
            $statement2 = PDODAO::prepareStatement($sql2);
            $permission = PDODAO::getArray($statement2);
            
            if ($permission === 2)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
//=============================================        
        
        public function fonGetTagsOnPage($pageid)
        {
            $sql = 'SELECT tags_id FROM pages_tags WHERE pages_id='.$pageid.'';
            $statement = PDODAO::prepareStatement($sql);
            
            $result = PDODAO::getArrays($statement);
            
            foreach ($result as $value)
            {
                $arrays[]=$value[0];
            }
            
            return $arrays;    
        }        
}
