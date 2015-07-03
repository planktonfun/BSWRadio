<?php

	require_once "FolderCrawler.php";
    require_once "CMP3File.php";

    $f = new FolderCrawler;

    $playlist = array_merge(  
        $f->crawl( 'mix2/Music/Party Musics/Party music - collection', 'mp3' ),              
        $f->crawl( 'mix2/Music/(1995) Wolfgang', 'mp3' ),              
		$f->crawl( 'mix2/Music/Greyhoundz/Execution Style', 'mp3' ),       
		$f->crawl( 'mix2/Music/He Is We - Old Demos -  (2010)', 'mp3' ),            
		$f->crawl( 'mix2/Music/Franco', 'mp3' ),            
		$f->crawl( 'mix2/Music/newly added music/emo', 'mp3' ), 
		$f->crawl( 'mix2/Music/newly added music/OPM', 'mp3' ),      
		$f->crawl( 'mix2/Music/P.N.E/Middle-Aged Juvenile Novelty Pop Rockers', 'mp3' ), 
		$f->crawl( 'mix2/Music/Punk Goes Pop/Punk Goes Pop 5', 'mp3' ),            
		$f->crawl( 'mix2/Music/Punk Goes Pop/Punk Goes Pop 6', 'mp3' ),            
		$f->crawl( 'mix2/Music/Punk Goes Pop/Punk Goes Pop 1+2 CDRip-Music_Monster/Punk Goes Pop 1', 'mp3' ),            
		$f->crawl( 'mix2/Music/Punk Goes Pop/Punk Goes Pop 1+2 CDRip-Music_Monster/Punk Goes Pop 2', 'mp3' ),            
		$f->crawl( 'mix2/Music/Punk Goes Pop/VA - Punk Goes Pop vol.3 (2010)(320kbps)', 'mp3' ),            
		$f->crawl( 'mix2/Music/Punk Goes Pop/VA-Punk_Goes_Pop_4-2011-FNT/VA-Punk_Goes_Pop_4-2011-FNT', 'mp3' ),            
		$f->crawl( 'mix2', 'mp3' ), 
		$f->crawl( 'mix2/Jap/HS music', 'mp3' ),
		$f->crawl( 'mix2/2014', 'mp3' ),
		$f->crawl( 'mix2/BSW-RADIO', 'mp3' ),
		$f->crawl( 'mix2/Billboard 2015 Top 100 Singles (June)', 'mp3' ),
		$f->crawl( 'mix2/Billy', 'mp3' ),
		$f->crawl( 'mix2/Downloads', 'mp3' ),
		$f->crawl( 'mix2/Ed Sheeran', 'mp3' ),
		$f->crawl( 'mix2/Final Riot', 'mp3' ),
		$f->crawl( 'mix2/Music', 'mp3' ),
		$f->crawl( 'mix2/Xmas', 'mp3' )
    );

?>