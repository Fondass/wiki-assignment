<?php

class FonInputButtons
{
    public function __construct()
    {
        
    }
    
    public function InputButtonMenu()
    {  
        return '<fieldset style="display:inline-block; float:right; margin-right:17%; margin-top:-27%; position:relative">
             <legend>editor input</legend>
            <script type="text/javascript" src="javascript/editorbuttons.js"></script>
            <input type="button" value="image" onclick="addImgToField();">
            <input type="button" value="link" onclick="addLinkToField();">
            <br>
            <input type="button" value="Break" onclick="addBreakToField();">
            <input type="button" value="bold" onclick="addBoldToField();">
            <br>
            <input type="button" value="h1" onclick="addH1ToField();">
            <input type="button" value="h2" onclick="addH2ToField();">
            <br>
            <input type="button" value="h3" onclick="addH3ToField();">
            <input type="button" value="h4" onclick="addH4ToField();">
            </fieldset>
            ';  
    }  
}