<!doctype html>
<html>
<head>
	<meta charset='UTF-8' />
	<style>
		input, textarea {border:1px solid #CCC;margin:0px;padding:0px}

		#body {max-width:800px;margin:auto}
		#log {width:100%;height:400px}
		#message {width:100%;line-height:20px}
		#generated {width:100%;line-height:20px}
	</style>
	<script src="/assets/js/jquery.min.js"></script>
	<script src="/assets/js/fancywebsocket.js"></script>
	<script>
		var Server;

		function log( text ) {
			$log = $('#log');
			//Add text to log
			$log.append(($log.val()?"\n":'')+text);
			//Autoscroll
			$log[0].scrollTop = $log[0].scrollHeight - $log[0].clientHeight;
		}

		function send( text ) {
			Server.send( 'message', text );
		}

		$(document).ready(function() {
			log('Connecting...');
			Server = new FancyWebSocket('ws://' + location.hostname + ':9301');

			$('#message').keypress(function(e) {
				if ( e.keyCode == 13 && this.value ) {
					log( 'You: ' + this.value );
					send( this.value );

					$(this).val('');
				}
			}); 

			$('.send_song .send, .update_mod .send, .update_dj .send, .refresh .send').click(function(){
				
				var parent = $(this).closest('div');
				var _class = parent.attr('class');

				var gen = {};

				$('.' + _class + ' input' ).each(function(){
					
					var val = ( $(this).val() ) ? $(this).val() : false;

					gen[ $(this).attr('class') ] = val;				

				});

				$('#message').val( JSON.stringify( gen ) );
				
			});			

			//Let the user know we're connected
			Server.bind('open', function() {
				log( "Connected." );
				logSpeedStart( );
			});

			//OH NOES! Disconnection occurred.
			Server.bind('close', function( data ) {
				log( "Disconnected." );
			});

			//Log any messages sent from server
			Server.bind('message', function( payload ) {
				if( payload == "congratz. --Your Trusty Server" ) {
					logSpeedEnd( );
				} else {
					log( payload );
				}
			});

			Server.connect();
		});

		// Log latency speed
		var startTime = 0;

		function logSpeedStart( ) {
				startTime = new Date().getTime();
			  	send( 'helloworld! --Pau' );
		}

		function logSpeedEnd( ) {  	


			  	endTime = new Date().getTime() - startTime;
				$.get( "http://<?= $_SERVER[ 'SERVER_NAME']?>:8080/testingarea/live_logs/input_only.php?total_time=" + (endTime/1000) );
		}

	</script>
</head>

<body>
	<div id='body'>
		<textarea id='log' name='log' readonly='readonly'></textarea><br/>
		<textarea type='text' row="3" id="message" /></textarea>
		
		<div class="send_song">			
			<label for="message">Message: </label><input type='text' class='message' name='message' value="Let Her Go" /><br>
			<label for="localip">Localip: </label><input type='text' class='localip' name='localip' value="10.60.46.220" /><br>
			<button class="send">send song</button>			
		</div>
		
		<div class="update_mod">		
			<label for="update_mod">Update_mod: </label><input type='text' class='update_mod' name='update_mod' value="Hello world and all who inhabit it" /><br>
			<label for="localip">Localip: </label><input type='text' class='localip' name='localip' value="10.60.46.220" /><br>	
			<button class="send">updated mod</button>			
		</div>
	
		<div class="update_dj">		
			<label for="updatedj">Updatedj: </label><input type='text' class='updatedj' name='updatedj' value="false" /><br>
			<button class="send">update dj ip</button>			
		</div>

		<div class="refresh">		
			<label for="message">Message: </label><input type='text' class='message' name='message' value="refresh_this_123" /><br>
			<button class="send">refresh all</button>			
		</div>
		
	</div>
	<pre>
	<?= round(( microtime(true) - $_SERVER[ 'REQUEST_TIME_FLOAT' ] )*1000) . ' ms' ?>
</body>

</html>