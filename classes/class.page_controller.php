<?php
/* Sybren Bos.... wished al rights were reserved, but they weren't :( 
   Use at own risk (i am not liable for any mistakes and/or errors, yours and mine) */

class FonController 
{
    var $db;
    var $user;
    var $ispostrequest;
   
    // constructs an instance of the controller class and also creates a database object. (is this the best practice?)    
    public function __construct()
    {
           require_once("classes/class.login.php");
           require_once("classes/class.db.php");
           require_once("classes/class.debug.php");
           require_once("classes/class.helpers.php");
           require_once("classes/class.page.wiki.login.php");
           $this->db = new database();
           $this->helper = new Helpers();
           $this->user = new FonLogin($this->db, $this->helper);
           
           //not really using this yet:
           if ($_SERVER["REQUEST_METHOD"]==="POST")
           {
               $this->ispostrequest = true;
           }
           else
           {
               $this->ispostrequest = false;
           }
    }
    
//===============================================================
    
    
    public function requestCheck()
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
    
//===============================================================    
    
    //this call the show function on the page object created with fonPageController()
    public function handleRequest() 
    {
        $pagevar =  $this->getPage();
        $page = $this->pageController(htmlspecialchars($pagevar, ENT_QUOTES, "UTF-8"));
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
    public function getPage () 
    {
        $key = "page";

        $result = $this->helper->arrayChecker($key);
        return $result;
    } 
  
//==============================================================
    
    //more ajax stuff    
    public function handleAjaxRequest()
    {
        $pagevar = $this->getAjaxPage();
        $ajaxaction = htmlspecialchars($pagevar, ENT_QUOTES, "UTF-8");
        
        switch($ajaxaction)
        {
           case 'rating':
               require_once("classes/class.rating.php");
               $rater = new FonRatingSystem($this->db);
               $score = htmlspecialchars($_POST["number"], ENT_QUOTES, "UTF-8");
               $id = htmlspecialchars($_POST["pageid"], ENT_QUOTES, "UTF-8");
               $userid = htmlspecialchars($_POST["userid"], ENT_QUOTES, "UTF-8");
               $rater->ratingCalc($id, $score, $userid);
               break;
               
               case 'advanced':
               require_once("classes/class.page.php");
               require_once("classes/class.page.wiki.php");
               require_once("classes/class.page.search.php");
               $thing = new SearchPage($this->db, $this->user);
               $thing->search->searchBox($this->db, true, true);
               break;
               
               ## BELOW CODE NEEDS TO BE PUT IN IT'S OWN FUNCTIONS. WORK IN PROGRESS! ##
           
               case 'more':                              
               session_start();
               $_SESSION['searchresults'] += 5;
               if (($_SESSION['searchresults'] + 5) < count($_SESSION['searchcache']))
               {
                    for($i = 0; $i < 5; $i++)
                    {
                        $a = $i + $_SESSION['searchresults'];
                        echo '* <a href="?page=wikipage&id='.$_SESSION['searchcache'][$a].'">'.$_SESSION['searchcache'][$a]."</a><br />";
                    }

                    echo '<br /><button id="less">Previous</button></div>';
                    echo '<button id="more">Next</button></div>';
               }
               else
               {
                    for($i = 0; $i < 5; $i++)
                    {
                        $a = $i + $_SESSION['searchresults'];
                        echo '* <a href="?page=wikipage&id='.$_SESSION['searchcache'][$a].'">'.$_SESSION['searchcache'][$a]."</a><br />";
                                                
                        if (($a + 1) == count($_SESSION['searchcache']))
                        {
                            break;
                        }
                    }
                    echo '<br /><button id="less">Previous</button></div>';
               }

               //$jsonarray = json_encode($_SESSION['searchcache']);
               //var_dump ($jsonarray);
               break;
            case 'less':
                              
               session_start();
               $_SESSION['searchresults'] -= 5;
               if ($_SESSION['searchresults'] < count($_SESSION['searchcache']))
               {
                    for($i = 0; $i < 5; $i++)
                    {
                        $a = $i + $_SESSION['searchresults'];
                        echo '* <a href="?page=wikipage&id='.$_SESSION['searchcache'][$a].'">'.$_SESSION['searchcache'][$a]."</a><br />";
                    }

                    echo '<br />';
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

               //$jsonarray = json_encode($_SESSION['searchcache']);
               //var_dump ($jsonarray);
               break;
               
               ## ABOVE CODE NEEDS TO BE PUT IN IT'S OWN FUNCTIONS. WORK IN PROGRESS! ##
               
        }      
    }

//==============================================================
    
    //more ajax stuff
    public function getAjaxPage()
    {
        $key = "ajaxaction";
        
        $result = $this->helper->arrayChecker($key);
        return $result;
    }
    
//==============================================================
    
    public function pageController($pagevar) 
    {
        //the actual switch that will return a page object depending on the $pagevar
        
        session_start();
        
        $page = null;

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
                
            case "loadfile":
                require_once("classes/class.page.wiki.fileupload.php");
                $page = new FileUpload($this->db, $this->user);
                break;
            
            case "searchresult":
                require_once("classes/class.page.searchresult.php");
                
                $title = $this->helper->arrayChecker("title", "");
                $array = $this->helper->arrayChecker("tagid", "");
                                
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
                $this->user->userLogout();
                break;
            
            case "home":

                
            default:

                include_once("classes/class.page.wiki.home.php");
                $page = new Home($this->db, $this->user);
        }
        return $page;
    }
}
