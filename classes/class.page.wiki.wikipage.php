<?php

/* this generate a wiki page based upon data from the 
 * page and pages_tags tables in the database 
 * 
 * usage: this takes a page out of the database 
 * and shows it to the visitor. only works if 
 * referenced as ?page=wikipage&id=(whatever page you want to see)
 * 
 * author: Ian de Jong
 * additions: Sybren Bos
 */

//================================================

    class Wikipage extends Wiki
    {
        protected $pagename = "";
        protected $wikipage = array();
        protected $db;
        protected $user;
        protected $converter;
        protected $buttons;
        protected $rating;

//================================================
//              wiki page constructor
//================================================
/*
 * takes a pagename as a parameter, without a 
 * provided pagename object creation will fail.
 */  
//================================================           

    public function __construct($pagename, $db, $user) 
    {
        
        if(is_string($pagename))
        {
            $this->pagename = $pagename;
            $this->db = $db;
            $this->user = $user;
            $this->converter = new FonStrConverter();
            $this->buttons = new FonInputButtons();
            $this->rating = new FonRatingSystem($db);
        }
        else
        {
            throw new Exception('Page not found.');
        }
    }
//================================================
//                 wiki content
//================================================
/*
 * generates a generic wiki page out of the data
 * that is kept on the database. which page will
 * be generator depends on the ID given in the 
 * URL.
 */  
//================================================ 
            
    protected function wikiContent()
    {
        $this->wikipage = $this->db->getPagesAndTagsOnName($this->pagename);

        $content = $this->converter->converterScrambledToShow($this->wikipage[0]["content"]);

        echo '<fieldset id="wikigenfield"><legend>
            <h3 id="wikigentitle">'.$this->wikipage[0][1].'</h3></legend>
            <p id="wikigencontent">'.$content.'
            </p>
            <form method="POST" action="index.php?page=editor&id='.$this->pagename.'">
            <input type="hidden" name="page" value="editor">';

        if ($this->user->checkLogged())    
        {
            echo '<input type="submit" name="editbutton" value="Edit">';
        }

        echo '</form></fieldset> 
            <p id="wikigentags"></p>';

        /* 
        echo "Article name: ".$this->wikipage[0]['name'];
        echo "<br />Article id: ".$this->wikipage[0]['id'];
        echo "<br />Page content: ".$this->wikipage[0]['content'];
        echo "<br />Creator id: ".$this->wikipage[0]['users_id'];
        echo "<br />Tag id's: ";
        */

        foreach ($this->wikipage as $value)
        {
            echo $value[10]." - ";
        }

        $pageid = $this->wikipage[0][0];

        echo '<div id="ratingshow">
            <p id=ratingshowref>'.$this->rating->Show($pageid).'</p>/10</div>';

        $this->db->checkPageRated($pageid);
        if ($this->user->checkLogged())
        {
            if (is_array($this->db->checkPageRated($pageid)))
            {
                if (in_array($this->db->getActiveUserId(), $this->db->checkPageRated($pageid)))
                {
                    echo "";
                }
                else
                {
                    echo $this->rating->showForm($pageid);
                }
            }
            else
            {
                echo $this->rating->showForm($pageid);
            }
        }
    }

//===================================================

    function bodyContent() 
    { 
        $this->wikiContent();
    }
}
        
