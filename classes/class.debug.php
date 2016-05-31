<?php
/* Geert Weggemans */

/* comment by fondas: output's a log file into the same folder as your project.
   copy (Debug::writeToLogFile("")) to where ever you wanna know if your code reaches this point.
   anything written in the ("") part will be logged and saved with a timestamp in a .txt file in your same folder.
*/




abstract class Debug
{
    public static function writeToLogFile($logmsg)
    {
        $dateTime = new DateTime("now");
        $dow = $dateTime->format("l");
        $w     = $dateTime->format("W");
        $fn     = _LOGPATH_."log_".$dow.".txt";
        $file = (is_file($fn)&&$w == date('W',filemtime($fn)))? fopen($fn,"a") : $file = fopen($fn,"w");
        fprintf($file,"%s | %.50s | %s \n",  $dateTime->format("d-m-Y G:i:s"), $_SERVER["REMOTE_ADDR"], $logmsg);
        fclose($file);
    }
    
    
    
   // Debug::writeToLogFile("dit is een beetje code");
}

