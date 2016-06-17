<?php

/* This function works in conjunction with the input buttons function and it's
 * javascript file (but works on it's own). As text in a field is saved up to a database
 * it contains a costum syntax. 
 * 
 * This function, when called uppon, tries to pick out that costum syntax and converts it into 
 * real HTML. This way, costum tags can ben used by the user to in the final result display
 * content that includes links, images, video's, and makes use of other HTML make up tags.
 */




class FonStrConverter
{
    
    public function __construct()
    {
        
    }

    
    
    public function converterScrambledToShow($string)
    {
        
        /*
         * image [img] [/img]
         * link [link] [linkttext] [/link]
         * break [br]
         * bold [b] [/b]
         * h1   [h1] [/h1]
         * h2   [h2]  [/h2]
         * h3   [h3]  [/h3]
         * h4   [h4]  [/h4]
         */
        

        $find = array('[img]','[/img]','[link]','[linktext]','[/link]','[br]','[b]','[/b]','[h1]','[/h1]','[h2]','[/h2]','[h3]','[/h3]','[h4]','[/h4]','[youtube]','[/youtube]','https://www.youtube.com/watch?v=');
        
        $replace = array('<img src="','" id="wikiimage">','<a href="','">','</a>','<br>','<b>','</b>','<h1>','</h1>','<h2>','</h2>','<h3>','</h3>','<h4>','</h4>','<iframe width="420" height="315" src="http://www.youtube.com/embed/','"></iframe>','');
                
        $content = str_replace($find,$replace,$string);  
        
                            
        return $content;           
    }
    
    
    
}