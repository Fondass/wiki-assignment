<?php

require_once ("class.page.wiki.wikipage.php");
require_once ("class.debug.php");


class FonEditorPage extends Wikipage
{
    
    /*
     * function to pressent the edit pages form. To add tags, simply copy/paste a input type
     * checkbox line, give it a new vallue (in the form of the highest existing number+1)
     * and put a name to it.
     */
    
    
    protected function fonCreatePageForm()
    {
        echo '<div><form method="POST">
            <fieldset>
            <legend>Edit wiki page</legend>
            <input style="width:30%; heigth:50px; font-size:30px" type="text" name="wikititle" placeholder="Wiki Page Tittle"><br>
            Page editor<br>
            <textarea style="width:70%; height:500px;" name="pageeditor"></textarea>
            <fieldset style="display:inline-block; float:right; margin-right:15%; margin-top:-0.3%;">
            <legend>Search tags</legend>
            <input type="checkbox" name="tag[]" value="1"> Magic<br>
            <input type="checkbox" name="tag[]" value="2"> Swords<br>
            <input type="checkbox" name="tag[]" value="3"> Monsters<br>
            <input type="checkbox" name="tag[]" value="4"> Siege Engines<br>
            <input type="checkbox" name="tag[]" value="5"> Kingdoms<br>
            </fieldset>
            <input type="submit" name="submitnewpage" value="Commit">
            </form></div>'; 
    }
    
    /*
     * bodycontent is a function that simply checks if a form needs to be filled or 
     * a form has yet to be filled in.
     */
    
    
    public function bodyContent()
    {
        if (isset($this->pagenamenj))
        {
            if ($this->user->fonLoggedUser() === true && $this->db->fonGetPermission() === 2)
            {
                if (!isset($_POST["submitexistingpage"]))
                {
                    $this->fonEditPageForm($this->pagename);
                }
                else
                {
                    $this->fonEditPageFormFilled();
                }
            }
            else
            {
                echo 'You do not have abab up up down left right sufficient permission to edit this page';
            }
        }
        else
        {
           // if ($this->user->fonLoggedUser() === true && $this->db->fonGetPermission() !== 0)
            if (1 == 1)
            {
                if (!isset($_POST["submitnewpage"]))
                {
                    $this->fonCreatePageForm();
                }
                else
                {
                    $this->fonCreatePageFormFilled();
                }
            }
            else
            {
                echo 'You do not have sufficient permission to edit this page';
            }
        } 
    }


    /*
     * function to save the page filled in by the user in the database.
     * 
     * makes use of:
     * 
     * fonArrayScrambler.
     * and internal function to loop through the checkbox array and give
     * every value a htmlspecialchars treatment.
     * 
     * $this->db->fonSavePageToDatabase
     * function in (class.db.php) that saves al values into the database
     * 
     */
    
    protected function foncreatePageFormFilled()
    {
        echo "Your page edit has succsesfully evaded the content police and is now
            being updated on the wiki"; 
        
        $tags = $_POST["tag"];
        $title = htmlspecialchars($_POST["wikititle"], ENT_QUOTES, "UTF-8"); 
        $content = htmlspecialchars($_POST["pageeditor"], ENT_QUOTES, "UTF-8");
        
        function fonArrayScrambler(&$tags)
        {
            foreach ($tags as &$value)
            { 
                $value = htmlspecialchars($value, ENT_QUOTES, "UTF-8"); 
            }
        }
        
        fonArrayScrambler($tags);

       $this->db->fonSavePageToDatabase($title, $content, $tags);
    }
}

$pager = new FonEditorPage("editor");

$pager->show();