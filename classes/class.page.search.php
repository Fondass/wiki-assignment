<?php

/* 
 * 
 * 
 * 
 */

class SearchPage extends Wiki
{
    var $tags = array();    
    
   
    
//================================================         
//takes a pagename as a parameter
    
    protected function searchBox()
    {
        
        $this->tags = $this->db->getTags();
        echo '<div id="menusearch"><form method="POST">
            <fieldset>
            <legend>Search page</legend>
            <legend>Tags</legend>
            <input type="hidden" name="page" value="searchresult">';
        
        foreach ($this->tags as $value)
        {
            echo '<input type="checkbox" name="tagid[]" value="'.$value["id"].'">'.$value["name"].'</input><br>';
        }   

        echo '</fieldset>
            <input type="submit" name="submit" value="Commit">
            </form></div>'; 
    }
    
    public function bodyContent()
    {
        $this->searchBox();
    }
}



        