        
        $(document).ready(function(){
            var description = 'Browse it, Rate it, Play it, Buy it. <i class="unselectable btbtn fa fa-2x fa-volume-up text-grey"></i>';

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
                    current_song = test;
               }
            });

        }

        var toggle_title = false;

        setInterval( function(){

            toggle_title = !toggle_title;

            if( toggle_title ) {
                $('title').html('BSW Radio');
            } else {
                $('title').html(current_song);                
            }

        }, 1500);

        function change_mod( _message ) {
            $('.mod').html( _message );
        }     
        
        // Live Server
        var Server = null;
        
        $(document).ready(function() {
            log('Connecting...');

            Server = new FancyWebSocket( server_name );

            //Let the user know we're connected
            Server.bind('open', function() {
                log( "Connected." );        
            });

            //OH NOES! Disconnection occurred.
            Server.bind('close', function( data ) {
                log( "Disconnected." );
            });

            //Log any messages sent from server
            Server.bind('message', function( data ) {

                log( data );

                var data = JSON.parse( data );
                var payload = data.message;

                if( typeof( data.updatedj ) === "undefined" ) data.updatedj = false;
                if( typeof( data.localip ) === "undefined" )  data.localip  = 'wqeqwe';
                if( typeof( data.update_mod ) === "undefined" ) data.update_mod = false;

                console.log( payload + 'from' + data.localip );

                if( data.updatedj != false )
                    dj_ip = data.updatedj;

                if( data.localip.indexOf(dj_ip) != -1 ) {
                    change_song( payload );
                    
                    if( data.update_mod != false )
                        change_mod( data.update_mod );
                } 

                if( data.localip.indexOf(dj_ip) != -1 ) 
                    change_song( payload );

                if(payload=='refresh_this_123') {
                    location.href = location.href;
                }

            });

            Server.connect();
        });

        function send( text ) {
            log( 'You:' + text );

            Server.send( 'message', JSON.stringify( { message: text, localip: localip } ) );
            // $.post('/ajax/send/',{ message: text, localip: localip });              
        }

        function log( text ) {
            $log = $('#log');
            //Add text to log
            $log.append(($log.val()?"\n":'')+text);
            //Autoscroll
            $log[0].scrollTop = $log[0].scrollHeight - $log[0].clientHeight;
        }       

        // Enable pusher logging - don't include this in production
        Pusher.log = function(message) {
          if (window.console && window.console.log) {
            window.console.log(message);
          }
        };

        var pusher = new Pusher( pusher_config.key );
        var channel = pusher.subscribe( pusher_config.channel );
        channel.bind('my_event', function(data) {                    
          var payload = data.message;

          if( typeof( data.updatedj ) === "undefined" ) data.updatedj = false;
          if( typeof( data.update_mod ) === "undefined" ) data.update_mod = false;
          if( typeof( data.localip ) === "undefined" )  data.localip  = 'wqeqwe';

          console.log( payload + 'from' + data.localip );
          console.log( data );
          
          if( data.updatedj != false )
            dj_ip = data.updatedj;

          if( data.localip.indexOf(dj_ip) != -1 ) {
            change_song( payload );
            
            if( data.update_mod != false )
                change_mod( data.update_mod );
          }
          
          if(payload=='refresh_this_123') {
            location.href = location.href;
          }
        });

        $(document).ready(function() {
            $(document).on('click','.btbtn',function(){
                toggleMute( this );
            });

            $(document).on('click','#update_mod',function(){
                Server.send( 'message', JSON.stringify( { update_mod: $('.message').val(), localip: localip } ) );
                // $.post('/ajax/setMessage/',{ update_mod: $('.message').val(), localip: localip });

            });
        });

        function getVolume( ) {
            var vol = 0;

            $('audio,video').each(function(){
                vol = $(this).context.volume;
            });

            return vol;
        }

        function setVolume( vol ) {
            $('audio,video').each(function(){
                $(this).context.volume = vol;
            });
        }

        function toggleMute( elem ) {

            if( getVolume( ) == 0 ) {
                $(elem).addClass('fa-volume-up');
                $(elem).removeClass('fa-volume-off');

                setVolume( 1 );
            } else {                
                $(elem).removeClass('fa-volume-up');
                $(elem).addClass('fa-volume-off');

                setVolume( 0 );
            }
        }

        // Live Server Track changes        
        $(document).on('click', '.track', function () {            

            var sample = $(this).find( '.title' ).text();
            
            if( global )                
                send( sample );

        });