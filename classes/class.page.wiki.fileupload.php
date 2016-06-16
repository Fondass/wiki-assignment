<?php

class FileUpload extends Wiki
{  
    function bodyContent() 
    { 
        if ($_SERVER["REQUEST_METHOD"]==="GET")
        {
            echo '<form action="helpers/upload.php" method="post" enctype="multipart/form-data">
                Select image to upload:
                <input type="file" name="fileToUpload" id="fileToUpload">
                <input type="submit" value="Upload Image" name="submit">
                </form>';
        }
}}
