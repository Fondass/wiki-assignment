<?php

/* the file upload page pressents the visitor with a form to upload images.
 * 
 * usage: ... not.. currently only accasible by typing in the URL ?page=loadfile
 * 
 * author: Ian de Jong
 */

class FileUpload extends Wiki
{  
    public function bodyContent() 
    { 
        if ($_SERVER["REQUEST_METHOD"]==="GET")
        {
            echo '<form method="post" enctype="multipart/form-data">
                <input type="hidden" name="page" value="loadfile">
                Select image to upload:
                <input type="file" name="fileToUpload" id="fileToUpload">
                <input type="submit" value="Upload Image" name="submit">
                </form>';
        }
        
        if ($_SERVER["REQUEST_METHOD"]==="POST")
        {
            $uploader = new Fileuploader;
            $uploader->load();
	}		
    }
}
