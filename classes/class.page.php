<?php
	
/*
 * basic pages template, all .page and .wiki files are children of this one.
 * 
 * usage: Extend from here to create new pages.
 * 
 * author: Ian de Jong
 */


class Page
{

    function show()
    {
            $this->beginDoc();
            $this->beginHeader();
            $this->headerContent();
            $this->endHeader();
            $this->beginBody();
            $this->bodyContent();
            $this->endBody();
            $this->endDoc();
    }	

    protected function beginDoc() 
    { 
            echo "<!DOCTYPE html><html>"; 
    }

    protected function beginHeader() 
    { 
            echo "<head>"; 
    }

    protected function headerContent() 
    { 
            echo "<title></title>";
    }

    protected function endHeader()
    { 
            echo "</head> \r"; 
    }

    protected function beginBody() 
    { 
            echo "<body>"; 
    }

    protected function bodyContent() 
    { 

            echo ""; 

    }

    protected function endBody() 
    { 
            echo "</body>"; 
    }

    protected function endDoc() 
    { 
            echo "</html>"; 
    }
}
		

