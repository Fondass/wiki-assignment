<?php

/* 
 * 
 * 
 * 
 */
require_once ("class.page.php");
require_once ("class.debug.php");


class FonEditorPage extends Page
{
    
  //  public function __construct($page)
  //  {
  //  }
    
    
    protected function fonEditPageForm()
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
            <input type="submit" name="submit7fgt" value="Commit">
            </form></div>'; 
    }
    
    
    public function bodyContent()
    {
        if (!isset($_POST["submit7fgt"]))
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
       
        Debug::writeToLogFile("content is:".$content);
        Debug::writeToLogFile("title is:".$title);
        
        foreach ($tags as $value)
        {
            Debug::writeToLogFile($value);
        }
        
        

       $this->db->fonSavePageToDatabase($title, $content, $tags);
    }
    
    
    
      
    
    
    
    
    
}

$pager = new FonEditorPage();

$pager->show();
