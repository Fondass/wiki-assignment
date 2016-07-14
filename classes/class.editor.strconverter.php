<?php

/* This function works in conjunction with the input buttons function and it's
 * javascript file (but works on it's own). As text in a field is saved up to a database
 * it contains a costum syntax. 
 * 
 * This function, when called uppon, tries to pick out that costum syntax and converts it into 
 * real HTML. This way, costum tags can ben used by the user to in the final result display
 * content that includes links, images, video's, and makes use of other HTML make up tags.
 * 
 * usage: call function when showing data coming from the database that uses this
 * costom syntax.
 * 
 * author: Sybren Bos.
 */

class FonStrConverter
{
    
    public function __construct()
    {
        
    }

//================================================
//         converter scrambled to show
//================================================
/*
 * replaces certain strings in provided content to
 * facilitate a way to use simply html tags.
 * 
 * strings to replace:
 *
 * image    [img]       [/img]
 * link     [link]      [linkttext]     [/link]
 * break    [br]
 * bold     [b]         [/b]
 * h1       [h1]        [/h1]
 * h2       [h2]        [/h2]
 * h3       [h3]        [/h3]
 * h4       [h4]        [/h4]
 * youtube  [youtube]   [/youtube]
 */  
//================================================
    
    public function converterScrambledToShow($string)
    {
        
        $find = array('[img]','[/img]','[link]','[linktext]','[/link]','[br]','[b]','[/b]','[h1]','[/h1]','[h2]','[/h2]','[h3]','[/h3]','[h4]','[/h4]','[youtube]','[/youtube]','https://www.youtube.com/watch?v=');
        
        $replace = array('<img src="','" id="wikiimage">','<a href="','">','</a>','<br>','<b>','</b>','<h1>','</h1>','<h2>','</h2>','<h3>','</h3>','<h4>','</h4>','<iframe width="420" height="315" src="http://www.youtube.com/embed/','"></iframe>','');
                
        $content = str_replace($find,$replace,$string);  
                            
        return $content;           
    }
}