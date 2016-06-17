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
    
    
    protected function createPageForm()
    {
        echo '<script type="text/javascript" src="javascript/popup.js"></script>
            <div><form method="POST">
            <fieldset class="editorgenfield">
            <legend>Edit wiki page</legend>
            <input type="hidden" name="page" value="editor">
            <input class="titlefield" type="text" name="wikititle" placeholder="Page Title" required>
            <br>Page editor<br>
            <textarea name="pageeditor" id="editorfield" required ></textarea>
            <fieldset class="searchtagsfield">
            <legend>Search tags</legend>';
        
        $this->tags = $this->db->getTags();
             
         foreach ($this->tags as $value)
         {
             echo '<input type="checkbox" name="tag[]" 
                 value="'.$value["id"].'">'.$value["name"].'</input><br>';
         } 

         echo '</fieldset>
             '.$this->buttons->inputButtonMenu().'
            <input class="commitbutton" type="submit" name="submitnewpage" value="Commit">
            </fieldset></form></div>'; 
    }
    
    /*
     * bodycontent is a function that simply checks if a form needs to be filled or 
     * a form has yet to be filled in.
     */
    
    
    public function bodyContent()
    {
        if (isset($_GET["id"]))
        {
            $getpage = htmlspecialchars($_GET["id"], ENT_QUOTES, "UTF-8");
            if ($this->user->loggedUser())
            {

                $opUser = $this->db->selectPagesOnName($getpage);

                if ($opUser[3] === $this->db->getActiveUserId())
                {
                    if (!isset($_POST["submitexistingpage"]))
                    {
                        $this->editPageForm($getpage);
                    }
                    else
                    {
                        $this->editPageFormFilled();
                    } 
                }
                
                elseif ($this->db->getPermission() == 2)
                {
                    if ($this->db->pageOwnerIsAdmin($getpage) === false)
                    {
                        if (!isset($_POST["submitexistingpage"]))
                        {
                            $this->editPageForm($getpage);
                        }
                        else
                        {
                            $this->editPageFormFilled();
                        }    
                    }
                    else
                    {
                        echo 'This page is controlled by another Admin';
                    }
                }
                else
                {
                    echo 'You can only edit your own pages';
                }
            }
            else
            {
                echo 'You need to be logged in to edit pages you scrub';
            }
        }
        else
        {
            if ($this->user->loggedUser())
            {
                if (!isset($_POST["submitnewpage"]))
                {
                    $this->createPageForm();
                }
                else
                {
                    $this->createPageFormFilled();
                }
            }
            else
            {
                echo 'You do not have sufficient permission to create a new page';
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
    
    protected function createPageFormFilled()
    {
        echo "Your page edit has succsesfully evaded the content police and is now
            being updated on the wiki"; 
        
        if (isset($_POST["tag"]))
        {
            $tags = $_POST["tag"];
        }
        else
        {
            $tags[0] = 1;
        }
        
        $title = htmlspecialchars($_POST["wikititle"], ENT_QUOTES, "UTF-8"); 
        $content = htmlspecialchars($_POST["pageeditor"], ENT_QUOTES, "UTF-8");
        
        $this->arrayScrambler($tags);

        $this->db->savePageToDatabase($title, $content, $tags);
    }
    
    protected function arrayScrambler(&$tags)
    {
        foreach ($tags as &$value)
        { 
            $value = htmlspecialchars($value, ENT_QUOTES, "UTF-8"); 
        }
        
        return $tags;
    }
    
    protected function editPageForm($pagename)
    {
        
        $page = $this->db->selectPagesOnName(htmlspecialchars($pagename, ENT_QUOTES, "UTF-8"));
        
        $title = $page[1];
        $content = $page[2];
        $id = $page[0];
        
        $tags = $this->db->getTags();
        $validtags = $this->db->getTagsOnPage($id);
        
            
        echo '
            <script type="text/javascript" src="javascript/popup.js"></script>
            <div><form method="POST">
            <fieldset class="editorgenfield">
            <legend>Edit wiki page</legend>
            <input class="titlefield" type="text" name="wikititle" value="'.$title.'" required>
            <br>Page editor<br>
            <textarea id="editorfield" name="pageeditor">'.$content.'</textarea>
            <fieldset class="searchtagsfield">
            <legend>Search tags</legend>';
            

        foreach ($tags as $value)
        {
            
            if (in_array($value[0], $validtags))
            {
                echo '<input type="checkbox" name="tag[]" value='.$value[0].' checked> '.$value[1].'<br>';
            }
            else
            {
                echo '<input type="checkbox" name="tag[]" value='.$value[0].'>'.$value[1].'<br>';
            }
        }
     
        echo '</fieldset>
            '.$this->buttons->inputButtonMenu().'
            <input type="hidden" name="pageid" value='.$id.'>
                <input type="hidden" name="page" value="editor">
                <input id="reeditbuttonjs" type="submit" name="submitexistingpage" value="Commit">
            </fieldset></form></div>';
    }
    
    protected function editPageFormFilled()
    {
        echo "Your page edit has succsesfully evaded the content police and is now
            being updated on the wiki"; 
        
        if (isset($_POST["tag"]))
        {
            $tags = $_POST["tag"];
        }
        else
        {
            $tags[0] = 1;
        }
        
        $title = htmlspecialchars($_POST["wikititle"], ENT_QUOTES, "UTF-8"); 
        $content = htmlspecialchars($_POST["pageeditor"], ENT_QUOTES, "UTF-8");
        $id = htmlspecialchars($_POST["pageid"], ENT_QUOTES, "UTF-8");

        $this->arrayScrambler($tags);

        $this->db->saveExistingPageToDatabase($title, $content, $tags, $id);
    }  
}

