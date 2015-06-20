<?php

class CMP3File { 
 var $title;var $artist;var $album;var $year;var $comment;var $genre; 
 function getid3 ($file) { 
  if (file_exists($file)) { 
   $id_start=filesize($file)-128; 
   $fp=fopen($file,"r"); 
   fseek($fp,$id_start); 
   $tag=fread($fp,3); 
   if ($tag == "TAG") { 
    $this->title=fread($fp,30); 
    $this->artist=fread($fp,30); 
    $this->album=fread($fp,30); 
    $this->year=fread($fp,4); 
    $this->comment=fread($fp,30); 
    $this->genre=fread($fp,1); 
    fclose($fp); 
    return true; 
   } else { 
    fclose($fp); 
    return false; 
   } 
  } else { return false; } 
 } 
}

?>