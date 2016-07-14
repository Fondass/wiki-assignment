<?php

/*
 * the editor page pressents the visitor with a form (with content or without)
 * that he/she can fill out to create a new wikipage or edit a corrent page.
 * works closely with the database that stores these pages.
 * 
 * usage: use this as a standard .page
 * require this script, create new FonEditorPage, new FonEditorPage->show()
 * 
 * author: Sybren Bos
 */

class FonEditorPage extends Wikipage
{
    
   protected $pagename;
   protected $db;
   protected $user;
   protected $converter;
   protected $buttons;
   protected $rating;
                                     
//================================================
//               Content Controller
//================================================
/*
* Is the editor creating a new page or an existing page?
* ----New page
* ---------
* ----existing page
* ---------
* Is the user logged in and / or an admin?
* ----User is admin (2)
* ----User is logged in (1)
* ----User is Guest (0)
*/    
//================================================
    
    public function bodyContent()
    {
        if (isset($_GET["id"]))
        {
            $getpage = htmlspecialchars($_GET["id"], ENT_QUOTES, "UTF-8");
            if ($this->user->checkLogged())
            {

                $opUser = $this->db->getPagesOnName($getpage);

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
                
                elseif ($this->db->getUserPermission() == 2)
                {
                    if ($this->db->checkPageOwnerIsAdmin($getpage) === false)
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
            if ($this->user->checkLogged())
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
        
//================================================
//               create page form
//================================================
/*
 * Editor view for a new page
 * 
 * displays multiple fields that an user can
 * interact with to create a new wiki page.
 * 
 * displays fields for:
 * 
 * entering a title
 * entering main wikipage content
 * field for adding tags to such a page
 * field for buttons that enter costom syntax used to display html
 */
//================================================	
  
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
            <input class="commitbutton" id="reeditbuttonjs" 
            type="submit" name="submitnewpage" value="Commit">
            </fieldset></form></div>'; 
    }
    
//================================================
//               edit page form
//================================================
/*
 * Editor view for an existing page
 * 
 * displays multiple fields that an user can
 * interact with to edit an existing wiki page.
 * 
 * displays fields for:
 * 
 * entering a title
 * entering main wikipage content
 * field for adding tags to such a page
 * field for buttons that enter costom syntax used to display html
 */
//================================================
    
    protected function editPageForm($pagename)
    {
        
        $page = $this->db->getPagesOnName(htmlspecialchars($pagename, ENT_QUOTES, "UTF-8"));
        
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
                echo '<input type="checkbox" name="tag[]" 
                    value='.$value[0].' checked> '.$value[1].'<br>';
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
    
//================================================
//           create page form filled
//================================================
/*
 * Called function when a new page is submitted.
 * 
 * Takes all the entered content saved in a post array,
 * aplies first line injection protection, then hands over
 * the information to the database class.
 */
//================================================
    
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

        $this->db->saveNewPageToDatabase($title, $content, $tags);
    }
    
//================================================
//             edit page form filled
//================================================
/*
 * Called function when an existing page is submitted.
 * 
 * Takes all the entered content saved in a post array,
 * aplies first line enjection protection, then hands over
 * the information to the database class.
 */
//================================================  
    
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
    
//================================================
//               array scrambler
//================================================
/*
 * function to aply htmlspecialchars to an array
 *
 * TODO: place function in helper class
 */
//================================================
    
    protected function arrayScrambler(&$tags)
    {
    foreach ($tags as &$value)
    { 
        $value = htmlspecialchars($value, ENT_QUOTES, "UTF-8"); 
    }

    return $tags;
    }
}

