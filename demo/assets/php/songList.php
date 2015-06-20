<?php

	include "FolderCrawler.php";
    include "CMP3File.php";

    $f = new FolderCrawler;

    $playlist = array_merge(        
        $f->crawl( 'mix', 'mp3' )
    );

?>