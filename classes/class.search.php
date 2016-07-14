<?php

/* class: main search class, responsible for handling most (if not all)
 * search quiries performed on the wiki.
 * 
 * usage: 
 * 
 * author: Ian de Jong
 */

class Search
{
    protected $tags = array();
    protected $pages;
    
//================================================
//           search pages on name and tags
//================================================
/*
 * searchfunction searches pages that MUST 
 * have multiple tags.
 */
//================================================
    
    protected function searchPagesOnNameAndTags($db, $name, $tagarray) 
    {        
        if (true)//is_string($name))
        {
            if ($tagarray !== '')
            {
                $sql = 'SELECT * FROM pages JOIN pages_tags 
                    ON pages.id = pages_tags.pages_id WHERE name LIKE "%'.$name.'%" AND (';

                //what happens if the array is empty

                foreach ($tagarray as $key => $value)
                {
                    $sql .= 'pages_tags.tags_id = '.$value.' OR ';
                }        
                $sql .= 'false)';
            }
            else
            {
                $sql = 'SELECT * FROM pages JOIN pages_tags 
                    ON pages.id = pages_tags.pages_id WHERE name LIKE "%'.$name.'%"';
            }
           
            $this->pages = $db->getPagesOnTag($sql);
            return $this->pages;
        }
        else
        {
            return false;
        }
    }
    
//================================================
//               seek title tag
//================================================
/*
 * prints list of pages corresponding for each tag for 
 * each tag in the tag array
 * 
 * array_merge(array_flip(array_flip($pages)))
 * looks complicated, it makes the array only have unique values.
 */
//================================================    
    
    public function seekTitleTag($db, $tags, $title)
    {
        $pages = array();
        
        $this->searchPagesOnNameAndTags($db, $title, $tags);
                    
        foreach($this->pages as $key => $value)
        {
            $pages[] = $value["name"];
        }
                
        if (isset($_SESSION["searchcache"]))
        {
            unset($_SESSION["searchcache"]);
        }
        
        $_SESSION["searchcache"] = array_merge(array_flip(array_flip($pages)));
        
        echo '<div class="more">';
        
        if(isset($_SESSION['searchcache'][0]))
        {
            for($i = 0; $i < 5; $i++)
            {
                echo '* <a href="?page=wikipage&id='.$_SESSION['searchcache'][$i].'">
                    '.$_SESSION['searchcache'][$i]."</a><br>";

                if (($i + 1) == count($_SESSION['searchcache']))
                {
                    break;
                }
            }
        }
        else
        {
            echo 'The search has come up empty, try using the tag search instead';
        }

        if (count($_SESSION['searchcache']) >= 5)
        {
             echo '<br><button id="more">Next</button></div>';
        }
        $_SESSION['searchresults'] = 0;
        
        echo '</div>';
    }

//================================================
//                 show less
//================================================
/*
 * if the search function produces equal to or less
 * than 5 results, this function is called to produce
 * the html for that page.
 */
//================================================

public function showLess()
{
    $_SESSION['searchresults'] -= 5;
    if ($_SESSION['searchresults'] < count($_SESSION['searchcache']))
    {
        for($i = 0; $i < 5; $i++)
        {
            $a = $i + $_SESSION['searchresults'];
            echo '* <a href="?page=wikipage&id='.$_SESSION['searchcache'][$a].'">
                '.$_SESSION['searchcache'][$a]."</a><br>";
        }

        echo '<br>';
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
}

//================================================
//                 show more
//================================================
/*
 * if the search function produces more than 5 
 * results, this function is called to produce
 * the html for that page.
 */
//================================================

public function showMore()
{
    $_SESSION['searchresults'] += 5;
    if (($_SESSION['searchresults'] + 5) < count($_SESSION['searchcache']))
    {
        for($i = 0; $i < 5; $i++)
        {
            $a = $i + $_SESSION['searchresults'];
            
            echo '* <a href="?page=wikipage&id='.$_SESSION['searchcache'][$a].'">
                '.$_SESSION['searchcache'][$a]."</a><br>";
        }

        echo '<br><button id="less">Previous</button></div>';
        
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
            
            echo '* <a href="?page=wikipage&id='.$_SESSION['searchcache'][$a].'">
                '.$_SESSION['searchcache'][$a]."</a><br>";

            if (($a + 1) == count($_SESSION['searchcache']))
            {
                break;
            }
        }
        echo '<br><button id="less">Previous</button></div>';
    }
}
    
//================================================
//                 search box
//================================================
/*
 * prints a little searchbox, the $title and $tags 
 * parameters can be used to request a certain 
 * kind of box
 */
//================================================        

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
                <input type="text" name="title" placeholder="page title"><br><br>';
        }
        
        if ($tags == true)
        {
            echo '<legend>Tags</legend>';
            foreach ($this->tags as $value)
            {
                echo '<input type="checkbox" name="tagid[]" value="'.$value["id"].'">
                    '.$value["name"].'</input><br>';
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
}