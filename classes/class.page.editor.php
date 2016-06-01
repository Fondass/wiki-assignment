<?php

/* 
 * 
 * 
 * 
 */
require_once ("class.page.php");


class FonEditorPage extends Page
{
    
    public function __construct($page)
    
    
    
    
    protected function fonEditPageForm()
    {
        echo '<div><form method="POST">
            <fieldset>
            <legend>Edit wiki page</legend>
            Page editor<br>
            <textarea style="width:70%; height:500px;" name="pageEditor"></textarea>
            <fieldset style="display:inline-block; float:right; margin-right:15%; margin-top:-0.3%;">
            <legend>Search tags</legend>
            <input type="checkbox" name="tag" value="random"> Random<br>
            <input type="checkbox" name="tag" value="swords"> Swords<br>
            <input type="checkbox" name="tag" value="Sworcery"> Sworcery<br>
            </fieldset>
            <input type="submit" name="7fgt36t" value="Commit">
            </form></div>'; 
    }
    
    
    public function bodyContent()
    {
        if (!isset($_REQUEST["7fgt36t"]))
        {
            $this->fonEditPageForm();
        }
        else
        {
            $this->fonEditPageFormFilled();
        }
    }
    
    protected function fonEditPageFormFilled()
    {
        echo "Your page edit has succsesfully evaded the content police and is now
            being updated on the wiki";
        
        $this->fonSavePageToDatabase();
    }
    
    
    
      
    
    
    
    
    
}

$pager = new FonEditorPage();

$pager->show();
