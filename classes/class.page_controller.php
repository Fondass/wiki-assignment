<?php
/* Sybren Bos.... wished al rights were reserved, but they weren't :( 
   Use at own risk (i am not liable for any mistakes and/or errors, yours and mine) */




class FonController 
{
    // constructs an instance of the controller class and also creates a database object. (is this the best practice?)    
    public function __construct()
    {
//	require_once("classes/class.pdo.php");
//        require_once("classes/class.db.php");
//        $this->db = new database();
    }
    
//===============================================================
    
    //checks for ajax request (not really used atm)
    public function fonRequestCheck()
    {
        if (isset($_POST["page"]) || isset($_GET["page"]))
        {
            $this->fonHandleRequest();
        }
        
        elseif (isset($_POST["ajaxaction"]) || isset($_GET["ajaxaction"]))
        {
            $this->fonHandleAjaxRequest();
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
            return "";
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
        require_once("classes/class.page.php");
        require_once("classes/class.page.wiki.php");
        switch ($pagevar) 
        {
            ########MODEL CODE#######
            # case "":   /* page name of page */
            #    require_once(""); /* file name of page  */
            #    $page = new ""();  /* class name of page */
            #    break;
            #########################
            
        
        //  case "editor":
        //  case "search":
        //  case "login":
            
            case "wikipage":
                require_once("classes/class.page.wiki.wikipage.php");
                $page = new Wikipage($_GET["id"]);  // this needs to be changed for more security
                break;
            
            case "searchresult":
                require_once("classes/class.page.searchresult.php");
                $int = (int)$_POST["tagid"]; //this needs to be changed for security
                $page = new Searchresult($int);  
                break;
                
            case "search":
                require_once("classes/class.page.search.php");
                $page = new SearchPage();
                break;
            
            case "userpanel":
                require_once("classes/class.page.userpanel.php");
                $page = new Userpanel();
                break;
                
            case "test":                
                //query the database for an article based upon id
                require_once("classes/class.page.wiki.test.php"); 
                $temp = $this->db->selectTest(1);
                
                $page = new Test($temp);
                break;
                            
            case "home":
                
            default:
                include_once("classes/class.page.wiki.home.php");
                $page = new Home();
        }
        return $page;
    }
}
