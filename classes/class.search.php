<?php

class Search
{
    var $tags = array();
    var $pages;
    
//================================================
    //returns an array of pages corresponding to one tag. I am using way too many functions to do this, may need to be reduced

    protected function searchPagesOnTags($db, $tag) 
    {
        $tag = (int)$tag;
        $sql = 'SELECT * FROM pages JOIN pages_tags ON pages.id = pages_tags.pages_id WHERE pages_tags.tags_id = '.$tag;
        $this->pages = $db->selectPagesOnTag($sql);
        return $this->pages;
    }
    
//================================================
    //searchfunction searches pages that MUST have multiple tags
    
    protected function searchPagesOnManyTags($db, $tagarray) 
    {        
        $sql = 'SELECT * FROM pages JOIN pages_tags ON pages.id = pages_tags.pages_id WHERE ';
        
        foreach ($tagarray as $key => $value)
        {
            $sql .= 'pages_tags.tags_id = '.$key.' AND ';
        }        
        $sql .= 'true';
        
        $this->pages = $db->selectPagesOnTag($sql);
        return $this->pages;
    }
    
//================================================
    //searchfunction searches pages that MUST have multiple tags
    
    protected function searchPagesOnNameAndTags($db, $name, $tagarray) 
    {        
        if (true)//is_string($name))
        {
            $sql = 'SELECT * FROM pages JOIN pages_tags ON pages.id = pages_tags.pages_id WHERE name LIKE "%'.$name.'%" AND (';
            
            //what happens if the array is empty
            
            foreach ($tagarray as $key => $value)
            {
                $sql .= 'pages_tags.tags_id = '.$value.' OR ';
            }        
            $sql .= 'false)';
            var_dump($sql);
           
            $this->pages = $db->selectPagesOnTag($sql);
            return $this->pages;
        }
        else
        {
            return false;
        }
    }
    
//================================================
//searches on name

    protected function searchPagesOnName($db, $name)
    {
        if (is_string($name))
        {
            $sql = 'SELECT * FROM pages WHERE name LIKE "%'.$name.'%"';
            $this->pages = $db->selectPagesOnTag($sql);
            return $this->pages;
        }
        else
        {
            return false;
        }
    }

//================================================    
    //prints list of pages corresponding for each tag for each tag in the tag array
    
    public function seekTitleTag($db, $tags, $title)
    {
        $pages = array();
        
        $this->searchPagesOnNameAndTags($db, $title, $tags);
                    
            foreach($this->pages as $key => $value)
            {
                $pages[] = $value["name"];
            }
                
        $newpages = array_merge(array_flip(array_flip($pages))); //looks complicated, it makes the array only have unique values

        foreach ($newpages as $key => $value)
        {
            echo '* <a href="?page=wikipage&id='.$value.'">'.$value."</a><br />";
        }
    }
    
//================================================    
    //prints list of pages corresponding for each tag for each tag in the tag array
    
    public function testContent($tags, $db)
    {
        $pages = array();
        
        foreach($tags as $foo => $bar)
        {
            $bar = strip_tags(htmlspecialchars($bar, ENT_QUOTES, "UTF-8"));
            $this->searchPagesOnTags($db, $bar);
            
            foreach($this->pages as $key => $value)
            {
                $pages[] = $value["name"];
            }
        }
        
        $newpages = array_merge(array_flip(array_flip($pages))); //looks complicated, it makes the array only have unique values

        foreach ($newpages as $key => $value)
        {
            echo '* <a href="?page=wikipage&id='.$value.'">'.$value."</a><br />";
        }
    }
    
//================================================         
    //prints a little searchbox, the $mode parameter can be used to request a certain kind of box. Just a tag search is standard now
    public function searchBox($db, $mode = false)
    {
        
        $this->tags = $db->getTags();
        echo '<div id="menusearch"><form method="POST">
            <fieldset>
            <legend>Search page</legend>
            <input type="hidden" name="page" value="searchresult">';
            
        if ($mode = 'title')
        {
            echo'<legend>Title</legend>
                <input type="text" name="title" placeholder="page title"><br /><br />';
        }
        
        echo '<legend>Tags</legend>';
        
        foreach ($this->tags as $value)
        {
            echo '<input type="checkbox" name="tagid[]" value="'.$value["id"].'">'.$value["name"].'</input><br>';
        }   

        echo '</fieldset>
            <input type="submit" name="submit" value="Commit">
            </form></div>'; 
    }   
    
    //================================================         
    //prints a little searchbox with namefield. I am making this function redundant
    public function searchBoxNameTag($db)
    {
        
        $this->tags = $db->getTags();
        echo '<div id="menusearch"><form method="POST">
            <fieldset>
            <legend>Search page</legend>
            <input type="hidden" name="page" value="searchresult">
            <legend>Title</legend>
            <input type="text" name="title" placeholder="page title"><br /><br />
            <legend>Tags</legend>';
        
        foreach ($this->tags as $value)
        {
            echo '<input type="checkbox" name="tagid[]" value="'.$value["id"].'">'.$value["name"].'</input><br>';
        }   

        echo '</fieldset>
            <input type="submit" name="submit" value="Commit">
            </form></div>'; 
    } 
}
