<?php

    include "CMP3File.php";

    class FolderCrawler 
	{
        private $_cache = true;
        private $_cache_file = 'data.cache';
        private $_cache_interval = 'YMDH';

        public function __construct( ) {
            
            if( $this->_cache == true && !file_exists( $this->_cache_file ) ) {
                file_put_contents( $this->_cache_file, json_encode(array('created' => 'now' )));
            }

        }

        private function getCache( $key ) {
            
            $file = file_get_contents( $this->_cache_file );
            $list = json_decode( $file, true );

            return ( isset( $list[$key] ) ) ? $list[$key] : false;
        }

        private function updateCache( $key, $array ) {
            
            $file = file_get_contents( $this->_cache_file );
            $list = json_decode( $file, true );

            if( !$this->getCache( $key ) ) {
                $list[ $key ] = $array;
            }

            file_put_contents( $this->_cache_file, json_encode( $list ));
        }

		public function crawl( $_folder_name, $_type ) {
			
            if( $this->_cache == true ) {
                
                $cache = $this->getCache( date( $this->_cache_interval ) . strip_tags( addslashes( $_folder_name ) ) );

                if( $cache != false ) {                    
                    return $cache;
                }
            }

			$files = scandir($_folder_name);

			if( !scandir($_folder_name) ) {
				die( 'Folder specified is unknown: ' . $_folder_name );
			}

			$files_added = array();

			foreach ($files as $key => $value ) {

				$path = $_folder_name . '/' . $value;

				$info = new SplFileInfo( $path );

				if( $info->getExtension() == $_type ) {
					
					$mp3 = new CMP3File;
					$mp3->getid3( $path );

					if( trim( strip_tags( $mp3->title ) ) != "" ) {
                        $files_added[] = array(
                            "mp3"    => $path,
                            "title"  => strip_tags( addslashes( $mp3->title ) ),
                            "artist" => strip_tags( addslashes( $mp3->artist ) )
                        );
                    } else {
                        $files_added[] = array(
                            "mp3"    => $path,
                            "title"  => strip_tags( addslashes( $value ) ),
                            "artist" => 'Mr. Pogi'
                        );
                    }
				}
			}

            if( $this->_cache == true ) {
                $this->updateCache( date( $this->_cache_interval ) . strip_tags( addslashes( $_folder_name ) ), $files_added );
            }

			return $files_added;
		}


	}

?>
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
    <script src="./assets/js/sound.js"></script>
    <script src="./assets/js/webrtc.js"></script>

    <?php 

        $f = new FolderCrawler;

        $playlist = array_merge( 
             $f->crawl( 'mix2/Music/Greyhoundz/Execution Style', 'mp3' ),
             $f->crawl( 'mix2', 'mp3' )
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

            // Server.send( 'message', text );   
            $.post('send.php',{ message: text, localip: localip });  
                     
        }

        function log( text ) {
            console.log( text );
        }



    </script>
    <script src="//js.pusher.com/2.2/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.log = function(message) {
          if (window.console && window.console.log) {
            window.console.log(message);
          }
        };

        var pusher = new Pusher('c7074daf2062830b98d0');
        var channel = pusher.subscribe('test_channel');
        channel.bind('my_event', function(data) {          
          var payload = data.message;
          change_song( payload );
          if(payload=='refresh_this_123') {
            location.href = location.href;
          }
        });


    </script>
</head>
<body>

<div id="title">BSW Web Radio</div>
</body>
</html>