<?php

/* class: main site controller.
 * 
 * usage: use as a primary handler between al pages. 
 * all ?page= requests and ?ajaxaction= requests are
 * handled here.
 * 
 * author: Sybren Bos, Ian de Jong
 */

class FonController 
{
    protected $db;
    protected $user;
    protected $helper;
    
//================================================
//             construct controller
//================================================
/*
 * This controller is where most site-wide features
 * are handled made or included. All files that are
 * required by many or multiple loads of the site are
 * stacked here for convienence.
 * 
 * also site-wide paramaters are instantiated here
 * so that they may be handed over to most 
 * other classes through the controller.
 * 
 * (note: file requires only required by one 
 * particualar area should be shoved in the 
 * controller itself to limit file loading)
 */
//================================================
       
    public function __construct()
    {
        require_once("classes/class.page.php");
        require_once("classes/class.page.wiki.php");
        require_once("classes/class.login.php");
        require_once('classes/class.search.php');
        require_once("classes/class.helpers.php");
        require_once("classes/class.page.wiki.wikipage.php");
        require_once('classes/class.page.search.php');
        require_once("classes/class.editor.strconverter.php");
        require_once("classes/class.editor.inputbuttons.php");
        require_once("classes/class.rating.php");
        require_once("classes/class.page.wiki.login.php");
        
        $this->db = new database();
        $this->helper = new Helpers();
        $this->user = new FonLogin($this->db, $this->helper);    
    }
    
//================================================
//                request check
//================================================
/*
 * Divides all incomming HTTP requests into
 * page requests or ajax requests.
 */
//================================================
    
    public function checkRequest()
    {
        if (isset($_POST["ajaxaction"]) || isset($_GET["ajaxaction"]))
        {
            $this->handleAjaxRequest();
        }
        else
        {
            $this->handleRequest();
        }  
    }
    
//================================================
//                 handle request
//================================================
/*
 * The page found by getPage (if found) is handed
 * on to the controller here after injection
 * validation.
 */
//================================================   
    
    protected function handleRequest() 
    {
        $pagevar =  $this->getPage();
        $page = $this->pageController($this->helper->specChars($pagevar));
        if ($page)
        {
            $page->show();
        }
        else
        {
            echo "Gnomes have stolen the webpage, we apologize for their natural behaviour";
        }
    }
    
//================================================
//                    get page
//================================================
/*
 * small function that asks the helper class
 * CheckRequestMethod to give back the ?page= element
 * and hands it over to handleRequest.
 */
//================================================
    
    protected function getPage () 
    {
        $key = "page";

        $result = $this->helper->checkRequestMethod($key);
        return $result;
    } 
  
//================================================
//               handle Ajax Request
//================================================
/*
 * The Ajax controller. This is responsible for 
 * calling the requested ajax function. Case is retrieved
 * from ?ajaxaction= (url) by getAjaxPage().
 */
//================================================
     
    protected function handleAjaxRequest()
    {
        $pagevar = $this->getAjaxAction();
        $ajaxaction = $this->helper->specChars($pagevar);
        
        switch($ajaxaction)
        {
            case 'rating':
               $rater = new FonRatingSystem($this->db);
               $score = $this->helper->specChars($_POST["number"]);
               $id = $this->helper->specChars($_POST["pageid"]);
               $userid = $this->helper->specChars($_POST["userid"]);
               $rater->showAjax($id, $score, $userid);
               break;
               
            case 'advanced':
               $thing = new SearchPage($this->db, $this->user);
               $thing->search->searchBox($this->db, true, true);
               break;
           
            case 'more':                              
               $search = new Search();
               $search->showMore();
               break;
           
            case 'less':
               $search = new Search();
               $search->showLess();
               break;             
        }      
    }

//================================================
//                get Ajax Action
//================================================
/*
 * small function that asks the helper class
 * CheckRequestMethod to give back the 
 * ?ajaxaction= element and hands it over 
 * to handleAjaxRequest.
 */
//================================================
    
    protected function getAjaxAction()
    {
        $key = "ajaxaction";
        
        $result = $this->helper->checkRequestMethod($key);
        return $result;
    }
    
//================================================
//                page controller
//================================================
/*
 * main controller of the website. Every new page
 * visit, form post, and others go through here
 * before reaching their destination as designed by
 * this controller.
 */
//================================================
    
    protected function pageController($pagevar) 
    {
        switch ($pagevar) 
        {
            case "wikipage":
                $pagename = strip_tags($this->helper->specChars($_GET["id"]));
                $page = new Wikipage($pagename, $this->db, $this->user);  
                break;
            
            case "promote":
                require_once("classes/class.page.userpanel.php");
                $newadmin = strip_tags($this->helper->specChars($_POST["id"]));
                $page = new Userpanel($this->db, $this->user, $newadmin);
                break;
                
            case "loadfile":
                require_once("classes/class.fileupload.php");
                require_once("classes/class.page.wiki.fileupload.php");
                $page = new FileUpload($this->db, $this->user);
                break;
            
            case "searchresult":
                require_once("classes/class.page.searchresult.php");
                $title = $this->helper->checkRequestMethod("title", "");
                $array = $this->helper->checkRequestMethod("tagid", "");
                                
                if ($title !== "")
                {
                    $page = new Searchresult($array, $this->db, $this->user, $title);
                }
                else
                {
                    $page = new Searchresult($array, $this->db, $this->user);
                }
                break;
                
            case "search":
                $page = new SearchPage($this->db, $this->user);
                break;
            
            case "userpanel":
                require_once("classes/class.page.userpanel.php");
                $page = new Userpanel($this->db, $this->user);
                break;
            
            case "login":
                $page = new FonLoginPage($this->db, $this->user);
                break;
            
            case "editor":
                require_once("classes/class.page.editor.php");
                $page = new FonEditorPage("editor", $this->db, $this->user);
                break;
            
            case "register":
                require_once("classes/class.page.wiki.register.php");
                require_once("classes/class.captcha.php");
                $page = new Register($this->db, $this->user);
                break;
            
            case "logout":
                $this->user->logout();
                break;
            
            case "home":

            default:
                require_once("classes/class.page.wiki.home.php");
                $page = new Home($this->db, $this->user);
        }
        return $page;
    }
}