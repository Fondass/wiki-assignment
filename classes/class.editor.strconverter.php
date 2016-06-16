<?php

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
        
        $find = array('[img]','[/img]','[link]','[linktext]','[/link]','[br]','[b]','[/b]','[h1]','[/h1]','[h2]','[/h2]','[h3]','[/h3]','[h4]','[/h4]');
        $replace = array('<img src="','" id="wikiimage">','<a href="','">','</a>','<br>','<b>','</b>','<h1>','</h1>','<h2>','</h2>','<h3>','</h3>','<h4>','</h4>');
                
        $content = str_replace($find,$replace,$string);        
                             
        return $content;           
    }
}