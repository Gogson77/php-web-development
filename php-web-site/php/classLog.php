<?php
    class Log{
        public static function upisiLog($nameFile, $textToWrite){

            $textToWrite = date("d.m.Y H:i:s",time())."-$textToWrite\r\n";
            $text = "";
            if(file_exists($nameFile)) $text=file_get_contents($nameFile);        
            $textToWrite .= $text;
            file_put_contents($nameFile, $textToWrite);
            
        }

    }

?>