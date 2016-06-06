<?php
	
//this is the base html template for a wiki page, it extends from the page class

//make sure this is required at the places where it is needed
//include the classes that extend this class
//include('classes/');

class Wiki extends Page
{

    public function __construct($db, $user) 
    {
        $this->db = $db;
        $this->user = $user;
    }
            
    function beginDoc() 
    { 
        echo "<!DOCTYPE html><html>"; 
    }

    function beginHeader() 
    { 
        echo '<head>
            <meta charset=UTF-8 />
            <meta name="codepedia" content="Netbeans" />
            <link rel="stylesheet" href="stylesheet.css" type="text/css" media="all" />'; 
    }

    function headerContent() 
    { 
        echo "<title>The Codepedia</title>";
    }

    function endHeader()
    { 
        echo "</head> \r"; 
    }

    function beginBody() 
    {
        
        echo '<body><div id="wrapper">
                <div id="menubar">';
        
        if ($this->user->fonLoggedUser())
        {
           echo '<p id="loggeduser"> Active user:'.$_SESSION["username"].'</p>
               <form id="logoutbutton" method="POST" action="index.php?page=logout">
               <input type="submit" value="Logout"></form>';
        }
        else
        {
            echo '
                <form id="menuloginsection" method="POST" action="index.php?page=login">
                <legend>User Login</legend>
                <input type="text" name="usernamefield" placeholder="Username" required>
                <br>
                <input type="text" name="passwordfield" placeholder="Password" required>
                <br>
                <input type="submit" name="loginsubmit" value="Login">
                </form>';
        }
            
            
            $thing = new SearchPage($this->db, $this->user);
            $thing->searchBox();

        echo '<a href="index.php?page=home">
            <div class="menubutton" id="homebutton">Home</div></a>
            
            <a href="index.php?page=userpanel">
            <div class="menubutton" id="usersbutton">Users</div></a>
            
            <a href="index.php?page=wikipage&id=info">
            <div class="menubutton" id="infobutton">Info</div></a>

            <a href="index.php?page=register">
            <div class="menubutton" id="regbutton">Register</div></a>
            
            <a href="index.php?page=editor">
            <div class="menubutton" id="editbutton">Editor</div></a>

            </div><div id=maincontent>
            '; 
    }

    function bodyContent() 
    { 

        echo ""; 

    }

    function endBody() 
    { 
        echo "</div></div></body>"; 
    }

    function endDoc() 
    { 
        echo "</html>"; 
    }

}
