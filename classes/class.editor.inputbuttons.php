<?php

/* 
 * 
 * 
 * 
 */

class FonInputButtons
{
    public function __construct()
    {
        
    }
    
    
    public function fonInputButtonMenu()
    {
        
        return '<fieldset style="display:inline-block; float:right; margin-right:17%; margin-top:-27%; position:relative">
             <legend>editor input</legend>
            <script type="text/javascript" src="javascript/editorbuttons.js"></script>
            <input type="button" value="image" onclick="fonAddImgToField();">
            <input type="button" value="link" onclick="fonAddLinkToField();">
            <br>
            <input type="button" value="Break" onclick="fonAddBreakToField();">
            <input type="button" value="bold" onclick="fonAddBoldToField();">
            <br>
            <input type="button" value="h1" onclick="fonAddH1ToField();">
            <input type="button" value="h2" onclick="fonAddH2ToField();">
            <br>
            <input type="button" value="h3" onclick="fonAddH3ToField();">
            <input type="button" value="h4" onclick="fonAddH4ToField();">
            </fieldset>
            ';
        
        
        
    }
    
    
}