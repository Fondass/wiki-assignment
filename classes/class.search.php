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
            //var_dump($tagarray);
            if ($tagarray !== '')
            {
                $sql = 'SELECT * FROM pages JOIN pages_tags ON pages.id = pages_tags.pages_id WHERE name LIKE "%'.$name.'%" AND (';

                //what happens if the array is empty

                foreach ($tagarray as $key => $value)
                {
                    $sql .= 'pages_tags.tags_id = '.$value.' OR ';
                }        
                $sql .= 'false)';
                //var_dump($sql);
            }
            else
            {
                $sql = 'SELECT * FROM pages JOIN pages_tags ON pages.id = pages_tags.pages_id WHERE name LIKE "%'.$name.'%"';
            }
           
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
                
        //$newpages = array_merge(array_flip(array_flip($pages))); //looks complicated, it makes the array only have unique values
        
        //var_dump($_SERVER);
        if (isset($_SESSION["searchcache"]))
        {
            unset($_SESSION["searchcache"]);
        }
            
        $_SESSION["searchcache"] = array_merge(array_flip(array_flip($pages)));
        
        //var_dump($_SESSION);
        
        // cache mechanism
        //ob_start();   // start the output buffer
        //$cachefile ="cache/searchcachefile.html";
        //if (file_exists($cachefile)) 
        //{
        //    // the page has been cached from an earlier request
        //    include($cachefile); // include the cache file
        //    exit; // exit the script, so that the rest isn't executed
        //}
        echo '<div class="more">';
        
               for($i = 0; $i < 5; $i++)
               {
                   echo '* <a href="?page=wikipage&id='.$_SESSION['searchcache'][$i].'">'.$_SESSION['searchcache'][$i]."</a><br />";
               
                   if (($i + 1) == count($_SESSION['searchcache']))
                        {
                            break;
                        }
               }
               
               if (count($_SESSION['searchcache']) >= 5)
               {
                    echo '<br /><button id="more">Next</button></div>';
               }
               $_SESSION['searchresults'] = 0;
        
        echo '</div>';       
        
        

        //$fp = fopen($cachefile, 'w'); // open the cache file for writing
        //fwrite($fp, ob_get_contents()); // save the contents of output buffer to the file
        //fclose($fp); // close the file
        //ob_end_flush(); // Send the output to the browser 
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
    
public function showLess()
{
    $_SESSION['searchresults'] -= 5;
               if ($_SESSION['searchresults'] < count($_SESSION['searchcache']))
               {
                    for($i = 0; $i < 5; $i++)
                    {
                        $a = $i + $_SESSION['searchresults'];
                        echo '* <a href="?page=wikipage&id='.$_SESSION['searchcache'][$a].'">'.$_SESSION['searchcache'][$a]."</a><br />";
                    }

                    echo '<br />';
                    if ($_SESSION['searchresults'] >= 1)
                    {
                        echo '<button id="less">Previous</button></div>';
                    }
                    
                    
                        echo '<button id="more">Next</button></div>';
                    
               }
               else
               {
                   echo 'whoah whoah out of bounds!!!';
               }

               //$jsonarray = json_encode($_SESSION['searchcache']);
               //var_dump ($jsonarray);
}
    
//================================================

public function showMore()
{
    $_SESSION['searchresults'] += 5;
               if (($_SESSION['searchresults'] + 5) < count($_SESSION['searchcache']))
               {
                    for($i = 0; $i < 5; $i++)
                    {
                        $a = $i + $_SESSION['searchresults'];
                        echo '* <a href="?page=wikipage&id='.$_SESSION['searchcache'][$a].'">'.$_SESSION['searchcache'][$a]."</a><br />";
                    }
                    
                    echo '<br /><button id="less">Previous</button></div>';
                    if ($_SESSION['searchresults'] >= 5)
                    {
                        echo '<button id="more">Next</button></div>';
                    }
                    
               }
               else
               {
                    for($i = 0; $i < 5; $i++)
                    {
                        $a = $i + $_SESSION['searchresults'];
                        echo '* <a href="?page=wikipage&id='.$_SESSION['searchcache'][$a].'">'.$_SESSION['searchcache'][$a]."</a><br />";
                                                
                        if (($a + 1) == count($_SESSION['searchcache']))
                        {
                            break;
                        }
                    }
                    echo '<br /><button id="less">Previous</button></div>';
    }
}
    
//================================================         
    //prints a little searchbox, the $title and $tags parameters can be used to request a certain kind of box
    public function searchBox($db, $title = false, $tags = false)
    {
        
       $this->tags = $db->getTags();
        echo '<div id="menusearch"><form method="GET">
            <fieldset>
            <legend>Search box</legend>
            <input type="hidden" name="page" value="searchresult">';
            
        if ($title == true)
        {
            echo'<legend>Title</legend>
                <input type="text" name="title" placeholder="page title"><br /><br />';
        }
        
        if ($tags == true)
        {
            echo '<legend>Tags</legend>';
            foreach ($this->tags as $value)
            {
                echo '<input type="checkbox" name="tagid[]" value="'.$value["id"].'">'.$value["name"].'</input><br>';
            }
        }

        echo '</fieldset>
            <input type="submit" name="submit" value="Commit">
            </form>';
        
        if(!($title == true && $tags == true))
        {
            echo '<button id="advanced">Advanced Search</button></div>';
        }
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
