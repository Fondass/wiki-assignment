<?php

class FileUpload extends Wiki
{  
    function bodyContent() 
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
        
        //action="helpers/upload.php"
        
        if ($_SERVER["REQUEST_METHOD"]==="POST")
        {
            $uploader = new Fileuploader;
            var_dump($uploader);
            $result = $uploader->load();
            

	}		
}
}
