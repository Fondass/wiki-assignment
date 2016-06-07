<?php
/* Sybren Bos.... wished al rights were reserved, but they weren't :( 
   Use at own risk (i am not liable for any mistakes and/or errors, yours and mine) */




class FonController 
{
    // constructs an instance of the controller class and also creates a database object. (is this the best practice?)    
    public function __construct()
    {
           require_once("classes/class.login.php");
           require_once("classes/class.db.php");
           require_once("classes/class.debug.php");
           $this->db = new database();
           $this->user = new FonLogin($this->db);
    }
    
//===============================================================
    
    //checks for ajax request (not really used atm)
    public function fonRequestCheck()
    {
        if (isset($_POST["ajaxaction"]) || isset($_GET["ajaxaction"]))
        {
            $this->fonHandleAjaxRequest();
        }
        else
        {
            $this->fonHandleRequest();
        }  
    }
    
//===============================================================    
    
    //this call the show function on the page object created with fonPageController()
    public function fonHandleRequest() 
    {
        $pagevar =  $this->fonGetPage();
        $page = $this->fonPageController(htmlspecialchars($pagevar, ENT_QUOTES, "UTF-8"));
        if ($page)
        {
            $page->show();
        }
        else
        {
            echo "Gnomes have stolen the webpage, we apologize for their natural behaviour";
        }
    }
    
//==============================================================
    
    //this returns the accurate parameter depending on what page is requested
    public function fonGetPage () 
    {
        if (isset($_POST["page"])) 
        {
            return $_POST["page"];
        }
        elseif (isset($_GET["page"]))
        {        
            return $_GET["page"];   
        }
        else
        {
            return "home";
        }
    }
  

//==============================================================
    
    //more ajax stuff    
    public function fonHandleAjaxRequest()
    {
        $ajaxaction = htmlspecialchars($this->fonGetAjaxPage(), ENT_QUOTES, "UTF-8");
        
        switch($ajaxaction)
        {
           case '' : $this->test();break;
            
        }      
    }

//==============================================================
    
    //more ajax stuff
    public function fonGetAjaxPage()
    {
        if (isset($_POST["ajaxaction"]))
        {
            return $_POST["ajaxaction"];
        }
        elseif  (isset($_GET["ajaxaction"]))
        {
            return $_GET["ajaxaction"];
        }
    }
    
//==============================================================
    
    public function fonPageController($pagevar) 
    {
        //the actual switch that will return a page object depending on the $pagevar
        $page = null;
        session_start();

        require_once("classes/class.page.php");
        require_once("classes/class.page.wiki.php");
        require_once("classes/class.page.search.php");
        switch ($pagevar) 
        {
            ########MODEL CODE#######
            # case "":   /* page name of page */
            #    require_once(""); /* file name of page  */
            #    $page = new ""();  /* class name of page */
            #    break;
            #########################
            

            case "wikipage":
                require_once("classes/class.page.wiki.wikipage.php");
                $id = strip_tags(htmlspecialchars($_GET["id"], ENT_QUOTES, "UTF-8"));
                $page = new Wikipage($id, $this->db, $this->user);  
                break;
            
            case "promote":
                require_once("classes/class.page.userpanel.php");
                $newadmin = strip_tags(htmlspecialchars($_POST["id"], ENT_QUOTES, "UTF-8"));
                $page = new Userpanel($this->db, $this->user, $newadmin);
                break;
            
            case "searchresult":
                require_once("classes/class.page.searchresult.php");
                if (isset($_POST["tagid"]))
                {
                    $array = htmlspecialchars($_POST["tagid"], ENT_QUOTES, "UTF-8"); 
                }
                else
                {
                    $array = "";
                }
                $page = new Searchresult($array, $this->db, $this->user);  
                break;
                
            case "search":
                require_once("classes/class.page.search.php");
                $page = new SearchPage($this->db, $this->user);
                break;
            
            case "userpanel":
                require_once("classes/class.page.userpanel.php");
                $page = new Userpanel($this->db, $this->user);
                break;
            
            case "login":
                require_once("classes/class.page.wiki.login.php");
                $page = new FonLoginPage($this->db, $this->user);
                break;
            
            case "editor":
                require_once("classes/class.page.editor.php");
                $page = new FonEditorPage("editor", $this->db, $this->user);
                break;
            
            case "register":
                require_once("classes/class.page.wiki.register.php");
                $page = new Register($this->db, $this->user);
                break;
            
            
            case "logout":
                $this->user->fonUserLogout();
                
            
            case "home":
                
            default:
                include_once("classes/class.page.wiki.home.php");
                $page = new Home($this->db, $this->user);
        }
        return $page;
    }
}
