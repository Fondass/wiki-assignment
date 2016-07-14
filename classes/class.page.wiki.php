<?php

/*
 * this is the base html template for a wiki page, 
 * it extends from the page class
 * 
 * usage: any created pages should be an extend from
 * this page, (or an extend of an extend from this page)
 * 
 * author: Ian de Jong, Sybren Bos
 */

 class Wiki extends Page
 {
    protected $db;
    protected $user;
	
    public function __construct($db, $user) 
    {
        $this->db = $db;
        $this->user = $user;
    }
            
    protected function beginDoc() 
    { 
        echo "<!DOCTYPE html><html>"; 
    }

//================================================
//                begin header
//================================================
/*
 * put relevant header information here like
 * javescript files and other header information.
 */  
//================================================
    
    protected function beginHeader() 
    { 
        echo '<head>
            <meta charset=UTF-8 />
            <meta name="codepedia" content="Netbeans" />
            <link rel="stylesheet" href="stylesheet.css" type="text/css" media="all" />
	    <script type="text/javascript" src="javascript/jquery-1.12.4.min.js"></script>
            <script type="text/javascript" src="javascript/editorbuttons.js"></script>
            <script type="text/javascript" src="javascript/ajaxscript.js"></script>
            <script type="text/javascript" src="javascript/menubuttonchange.js"></script>
            <script type="text/javascript" src="javascript/ajaxsearch.js"></script>';
    }

    protected function headerContent() 
    { 
        echo "<title>The Codepedia</title>";
    }

    protected function endHeader()
    { 
        echo "</head>"; 
    }

//================================================
//                  begin body
//================================================
/*
 * The code below is responsible for putting a 
 * consistent menu across the entire website.
 * 
 * In the menu can be found links to the page
 * controller, the login function 
 * (and consequently, the logout function),
 * and the search function.
 */  
//================================================
    protected function beginBody() 
    {
        echo '<body><div id="wrapper">
              <div id="menubar">
              <div id=menutopwrapper></div>';

        echo '<a href="index.php?page=home">
             <div class="menubutton" id="homebutton">Home</div></a>';
            
        if ($this->user->checkLogged())
        {
            echo '<a href="index.php?page=userpanel">
            <div class="menubutton" id="usersbutton">Users</div></a>';
        }
            
        echo '<div id="searchtotal"><div class="menubutton" id="searchbutton">
              <p class="menutextcolor">Search</p></div>';
        
        echo '<div class="seek">';
          
        $thing = new SearchPage($this->db, $this->user);
        $thing->search->searchBox($this->db, true, false);
        
        echo '</div>';
        
        echo '</div><a href="index.php?page=wikipage&id=info">
            <div class="menubutton" id="infobutton">Info</div></a>';
        
        if ($this->user->checkLogged())
        {
            echo '<a href="index.php?page=logout">
                <div class= "menubutton" id="regbuttonoff">Logout</div></a>';
        }
        else
        {
            echo '<div id=logintotal>
            <div class="menubutton" id="regbutton">
            <p class="menutextcolor">Register/Login</p></div>';
            
            $loginthing = new FonLoginPage($this->db, $this->user);
            $loginthing->showLogin();
            
            echo '</div>';    
        }
        
        if ($this->user->checkLogged())
        {
            echo '<a href="index.php?page=editor">
               <div class="menubutton" id="editbutton">Editor</div></a>';
        }    
            echo '</div><div id=maincontent>'; 
    }

    protected function bodyContent() 
    { 
        echo ""; 
    }

    protected function endBody() 
    { 
        echo "</div></div></body>"; 
    }

    protected function endDoc() 
    { 
        echo "</html>"; 
    }
}