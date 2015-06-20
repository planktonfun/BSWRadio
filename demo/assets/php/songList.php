<?php

	require_once "FolderCrawler.php";
    require_once "CMP3File.php";

    $f = new FolderCrawler;

    $playlist = array_merge(        
        $f->crawl( 'mix', 'mp3' )
    );

?>