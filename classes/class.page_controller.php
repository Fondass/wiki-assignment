<?php
/* Sybren Bos.... wished al rights were reserved, but they weren't :( 
   Use at own risk (i am not liable for any mistakes and/or errors, yours and mine) */




class FonController 
{
        
    public function __construct()
    {
	
    }
    
    
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
    
    public function fonHandleRequest() 
    {
        $pagevar =  $this->fonGetPage();
        $page = $this->fonPageController(htmlspecialchars($pagevar, ENT_QUOTES, "UTF-8"));
        if ($page)
        {
            $page->ShowPage();
        }
        else
        {
            echo "Gnomes have stolen the webpage, we apoligise for their natural behavior";
        }
    }
    
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
    
    public function fonHandleAjaxRequest()
    {
        $ajaxaction = htmlspecialchars($this->fonGetAjaxPage(), ENT_QUOTES, "UTF-8");
        
        switch($ajaxaction)
        {
           case '' : $this->test();break;
            
        }      
    }
    
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
    
    
    public function fonPageController($pagevar) 
    {
        $page = null;
        require_once("classes/class.page.php");
        require_once("classes/class.page.wiki.php");
        switch ($pagevar) 
        {
            case "":   /* page name of page */
                require_once(""); /* file name of page  */
                $page = new ("");  /* class name of page */
                break;
                            
            case "home":
                
            default:
                include_once("classes/class.page.wiki.home.php");
                $page = new FonHomePage();
        }
        return $page;
    }
}


