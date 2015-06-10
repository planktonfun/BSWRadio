<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <title>BSW Radio</title>
    <link rel="stylesheet" type="text/css" href="../plugin/css/style.css">
    <link rel="stylesheet" type="text/css" href="css/demo.css">
    <script src="./assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="../plugin/jquery-jplayer/jquery.jplayer.js"></script>
    <script type="text/javascript" src="../plugin/ttw-music-player-min.js"></script>    
    <script src="./assets/js/fancywebsocket.js"></script>

    <?php 
        include "FolderCrawler.php";
        include "CMP3File.php";

        $f = new FolderCrawler;

        $playlist = array_merge( 
            $f->crawl( 'mix2', 'mp3' ), 
            $f->crawl( 'mix2/Jap/HS music', 'mp3' ),
            $f->crawl( 'mix2/2014', 'mp3' ),
            $f->crawl( 'mix2/BSW-RADIO', 'mp3' ),
            $f->crawl( 'mix2/Billboard 2015 Top 100 Singles (June)', 'mp3' )
        );

    ?>
    <script type="text/javascript">

        var myPlaylist = [];

        <?php 
            
        foreach ( $playlist as $key => $value) {

            ?>

            myPlaylist.push({
                mp3:"<?php echo $value['mp3'] ?>",
                oga:'mix/1.ogg',
                title:"<?php echo $value['title'] ?>",
                artist:"<?php echo $value['artist'] ?>",
                rating:4,
                buy:'#',
                price:'1.00',
                duration:'0:30',
            });

            <?php
     
        }

        ?>

        $(document).ready(function(){
            var description = 'Browse it, Rate it, Play it, Buy it.';

            $('body').ttwMusicPlayer(myPlaylist, {
                currencySymbol:'P',
                buyText:'BUY',
                tracksToShow:5,
                autoPlay:false, 
                description:description,
                ratingCallback:function(index, playlistItem, rating){
                    console.log(index, playlistItem, rating);
                },

                jPlayer:{
                    swfPath:'../plugin/jquery-jplayer' //You need to override the default swf path any time the directory structure changes
                }
            });
        });

        var global = true;

        // Change Song BY Title
        function change_song( _title_click ) {
            
            $('.track .title').each(function(){
               var test =  $(this).text(); //console.log( test );
               if( test == _title_click  ) {
                    global = false;
                    $(this).click();
                    global = true;
               }
            });

        }        
        
        // Live Server
        var Server = null;

        $(document).ready(function() {
            log('Connecting...');

            Server = new FancyWebSocket('ws://<?= $_SERVER[ 'SERVER_NAME']; ?>:9301');

            //Let the user know we're connected
            Server.bind('open', function() {
                log( "Connected." );        
            });

            //OH NOES! Disconnection occurred.
            Server.bind('close', function( data ) {
                log( "Disconnected." );
            });

            //Log any messages sent from server
            Server.bind('message', function( payload ) {
                log( payload );

                change_song( payload );

            });

            Server.connect();
        });

        function send( text ) {
            log( 'You:' + text );

            Server.send( 'message', text );            
        }

        function log( text ) {
            console.log( text );
        }

        // Live Server Track changes        
        $(document).on('click', '.track', function () {

            console.log('eh');

            var sample = $(this).find( '.title' ).text();
            
            if( global )                
                send( sample );


        });        

    </script>
</head>
<body>

<div id="title">BSW Web Radio</div>
</body>
</html>