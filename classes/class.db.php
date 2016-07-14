<?php

/*
 * class that works in conjunction with PDO to setup SQL Queries.
 * 
 * usage: Include database in every script that uses database functions and refer those here.
 * 
 * author: Sybren Bos, Ian de Jong.
 */

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

//================================================
/*
 * The below functions should speak for themselves
 * by the naming of them, if this is not the case,
 * more documented comments should be pressent or 
 * otherwise a name revision is required.
 * 
 * database functions come in 3 variants:
 * 
 *      get: used to get information from the database
 *      save: used to save information to the database
 *      check: used to check information provided against the database
 *      
 */   
//================================================
//            save New Page To Database
//================================================
/*
 * Takes content entered by an user through the
 * editor and saves it into the database.
*/    
//================================================	
	
    public function saveNewPageToDatabase($title, $content, $tags)
    {
        $sql= 'SELECT id FROM users WHERE name = "'.$_SESSION["username"].'"';
        $result= PDODAO::getDataArray($sql);

        $user_id = $result[0];

        $sql= 'INSERT INTO pages (name, content, users_id) VALUES
             ("'.$title.'", "'.$content.'", "'.$user_id.'");';
        PDODAO::doInsertQuery($sql);

        $sql= 'SELECT id FROM pages WHERE name="'.$title.'"';
        $statement = PDODAO::prepareStatement($sql);
        $result2 = PDODAO::getArray($statement);

        foreach ($tags as $value)
        {
            $sql= 'INSERT INTO pages_tags (pages_id, tags_id) VALUES ('.$result2[0].', '.$value.')';
            PDODAO::doInsertQuery($sql);
        }
    } 
        
//================================================
//          save existing page To Database
//================================================
/*
 * Takes content entered by an user through the
 * editor and updates content from an existing
 * entry in the database. 
*/    
//================================================

    public function saveExistingPageToDatabase($title, $content, $tags, $id)
    {
        $sql= 'UPDATE pages 
            SET name="'.$title.'", content="'.$content.'", lastedit="'.date('Y-m-d G:i:s').'" 
            WHERE id='.$id.';';
        PDODAO::doUpdateQuery($sql);

        $sql2= 'DELETE FROM pages_tags WHERE pages_id='.$id.'';
        PDODAO::doDeleteQuery($sql2);

        foreach ($tags as $value)
        {
             $sql3= 'INSERT INTO pages_tags (pages_id, tags_id) VALUES ('.$id.', '.$value.')';
            PDODAO::doInsertQuery($sql3);
        }
    }
         
//================================================
//           get password on username
//================================================
/*
 * Looks up the password that is coupled with an
 * entered username provided by a user. username
 * need to be a valid entry in the databse for 
 * this function to return something. 
*/    
//================================================
  
    public function getPasswordOnUsername($username)
    {
        $sql = 'SELECT password FROM users WHERE name="'.$username.'"';
        $statement = PDODAO::prepareStatement($sql);
        $result = PDODAO::getArray($statement);

        return $result[0]; // returns the valid password 
    }
        
//================================================
//              get user permission
//================================================
/*
 * looks up the user permission data for the user
 * activating this function (called by trying to
 * acces a certain part of the site).
 * 
 * Returns:
 *  0 : not logged in (guest)
 *  1 : regular user
 *  2 : administrative user
 * 
*/    
//================================================
        
    public function getUserPermission()
    {
        $username = $_SESSION["username"];

        if (isset($username) && $username !== "")
        {
            $sql = 'SELECT permission FROM users WHERE name="'.$username.'"';
            $result = PDODAO::getDataArray($sql);

            return $result['permission'];  // returns 0, 1 or 2 for permission
        }
        else
        {
            return 0;
        }
    }

//================================================
//              get active user id
//================================================
/*
 * Looks up and returns the unique user id that 
 * is coupled with the currently logged in user.
*/    
//================================================     

    public function getActiveUserId()
    {
        $username = $_SESSION["username"];

        if (isset($username) && $username !== "")
        {
            $sql = 'SELECT id FROM users WHERE name="'.$username.'"';
            $statement = PDODAO::prepareStatement($sql);
            $result = PDODAO::getArray($statement);

            return $result[0];  // returns the id of the user
        }
    }

//================================================
//           get pages and tags on name
//================================================
/*
 * Returns a 2 dimensional array consisting of 
 * page details [0]
 * and tags [1] that correspond with the page
 */   
//================================================

    public function getPagesAndTagsOnName($name)
    {
        $sql = 'SELECT * FROM pages JOIN pages_tags 
            ON pages.id = pages_tags.pages_id 
            JOIN tags ON pages_tags.tags_id = tags.id 
            WHERE pages.name = "'.$name.'"';
        return PDODAO::getDataArrays($sql);
    }

//================================================
//              get active user id
//================================================
/*
 * Looks up and returns the unique user id that 
 * is coupled with the currently logged in user.
*/    
//================================================      

    public function getPagesOnName($name)
    {
       $sql = 'SELECT * FROM pages WHERE name="'.$name.'"';
        return PDODAO::getDataArray($sql); // returns page content on name
    }

//================================================
//           check page owner is admin
//================================================
/*
 * checks to see if the current user is the owner of
 * the page he/she is trying to edit.
 */   
//================================================

    public function checkPageOwnerIsAdmin($pagename)
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

//================================================
//                  get tags
//================================================
/*
 * function that simply looks up al tags and 
 * passes them in an array.
 */   
//================================================    

    public function getTags()
    {
        $sql = 'SELECT * FROM tags';
        return PDODAO::getDataArrays($sql); // returns all tags
    }

//================================================
//               get tags on page
//================================================
/*
 * this function looks up all tags that are 
 * coupled with a page ($pageid), and returns them
 * in an array. 
 */   
//================================================     
        
    public function getTagsOnPage($pageid)
    {
        $sql = 'SELECT tags_id FROM pages_tags WHERE pages_id="'.$pageid.'"';
        $statement = PDODAO::prepareStatement($sql);

        $result = PDODAO::getArrays($statement);

        foreach ($result as $value)
        {
            $results[]=$value[0];
        }
        return $results;  // returns all tags that correspond with $pageid
    }
        
//================================================
//               get regular users
//================================================
/*
 * returns al the users that are tagged as a 
 * regular user (permission 1) as an array.
 */   
//================================================ 
    
    public function getRegularUsers()
    {
        $sql = 'SELECT * FROM users WHERE permission = 1';
        return PDODAO::getDataArrays($sql);  
    }
	
//================================================
//                get admin users
//================================================
/*
 * returns al the users that are tagged as an 
 * admin user (permission 1) as an array.
 */   
//================================================
	
    public function getAdminUsers()
    {
        $sql = 'SELECT * FROM users WHERE permission = 2';
        return PDODAO::getDataArrays($sql);
    } 
            
//================================================
//                 save new user
//================================================
/*
 * saves the entries of a new user into the database.
 * 
 * salt refers to a password hashtag defined in script.
 */   
//================================================        
                     
    public function saveNewUser($newuser, $newpass, $salt)
    {
        $sql = 'INSERT INTO users(name, password, permission, salt) 
                VALUES ("'.$newuser.'","'.$newpass.'",1, "'.$salt.'")';
        return PDODAO::doInsertQuery($sql);
    }
//================================================
//                 save new user
//================================================
/*
 * Updates a regular user (permission 1) to 
 * become an admin user (permission 2).
 * 
 * This does not make a new user.
 */   
//================================================    
            
    public function saveNewAdmin($id)
    {
        $sql = 'UPDATE users SET permission = 2 WHERE id = "'.$id.'"';
        return PDODAO::doUpdateQuery($sql);  
    }
            
//================================================
//                  get salt
//================================================
/*
 * looks up the added password salt in the database
 * (which is a column in the users table).
 * 
 * salt refers to a password hashtag defined in script.
 */   
//================================================  
    public function getSalt($name)
    {
       $sql = 'SELECT salt FROM users WHERE name = "'.$name.'"';
       $result = PDODAO::getDataArray($sql);
       //echo $result['salt'];
       return $result['salt'];
    }
            
//================================================
//                get page rating
//================================================
/*
 * Looks up al ratings given for a page. This 
 * returns an array of different ratings.
 * 
 * further proccessed in script to calculate 
 * an avarage rating.
 */   
//================================================  

    public function getPageRating($pageid)
    {
        $sql = 'SELECT rating FROM rating WHERE pages_id ="'.$pageid.'"';
        $result = PDODAO::getDataArrays($sql);

        foreach ($result as $value)
        {
            $rating[] = $value[0];
        }

        if (isset($rating))
        {
            return $rating;
        }
        else
        {
            $rating = array(5,5);
            return $rating;
        }
    }
      
//================================================
//          function needed for search
//================================================
//               get pages on tag
//================================================
/*
 * function that takes SQL statements from
 * the search class.
 */   
//================================================   
    
    public function getPagesOnTag($sql)
    {
        return PDODAO::getDataArrays($sql);
    }
    
//================================================
//                save page rating
//================================================
/*
 * saves a new entry in the rating table.
 */   
//================================================  
    
    public function savePageRating($pageid, $rating, $userid)
    {

        $sql = 'INSERT INTO rating (pages_id, rating, users_id) 
            VALUES ("'.$pageid.'","'.$rating.'","'.$userid.'")';
        PDODAO::doInsertQuery($sql);
    }
            
//================================================
//                 check page rated
//================================================
/*
 * function that returns which users (id)
 * have rated the current page in an array.
 */   
//================================================  

    public function checkPageRated($pageid)
    { 
        $sql = 'SELECT users_id FROM rating WHERE pages_id ="'.$pageid.'"';
        $result = PDODAO::getDataArray($sql);
        return $result;
    }
}