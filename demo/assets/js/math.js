// Calculating functions
		function overlap(r1, r2) {
		    var hit = !(r1.x + r1.w < r2.x ||
		               r2.x + r2.w < r1.x ||
		               r1.y + r1.h < r2.y ||
		               r2.y + r2.h < r1.y);
	    	
	    	return hit;
		}

		function limVar( num, min, max ) {
			return Math.min( Math.max( parseFloat( num ), min ), max );
		}

		function randNum( min, max ) {
			return Math.floor( Math.random() * (max - min + 1) + min );
		}

		function drawEllipse( centerX, centerY, width, height ) 
		{
			context.beginPath();
			context.moveTo(centerX, centerY - height/2);

			context.bezierCurveTo(
			centerX + width/2, centerY - height/2,
			centerX + width/2, centerY + height/2,
			centerX, centerY + height/2);

			context.bezierCurveTo(
			centerX - width/2, centerY + height/2,
			centerX - width/2, centerY - height/2,
			centerX, centerY - height/2);

			context.fillStyle = 'rgba(0,0,0,0.4)';
			context.fill();
			context.closePath();	
		}

		function scaleImage( ) {
			context.scale( scalewidth, scaleheight);
		}

		function revertScale( ) {
			context.scale( revertwidth, revertheight);
		}

		function calculateFPS() {

			var thisFrameFPS = 1000 / ((now=new Date) - lastUpdate);
			
			if (now!=lastUpdate){
				fps += (thisFrameFPS - fps) / fpsFilter;
				lastUpdate = now;
			}

		}

		function drawFromPartImage( image, map, x, y, w, h) {

			if(typeof(w)==='undefined') w = map.w;
			if(typeof(h)==='undefined') h = map.h;

			context.drawImage( image, 
				map.x, map.y, map.w, map.h,
				x, y, w, h
			);
		
		}

		function addText( text, x, y ) {
			context.font = "28px Gloria Hallelujah";
			context.fillStyle = 'black';
			context.fillText( text, x, y);
		}

		function drawRect( x, y, w, h, color ) {

			if(typeof(color)==='undefined') {
				context.fillStyle = 'rgba(40,206,199,0.8)';
			} else {
				context.fillStyle = 'rgba(' + color + ',0.8)';
			}

			context.fillRect(x,y,w,h);
		}

		function drawCirc( x, y, radius, color ) {

			if( radius < 0.001 ) return;
			
			context.beginPath();
			context.arc( x, y, radius, 0, Math.PI*2, false);

			if(typeof(color)==='undefined') {
				context.fillStyle = 'rgba(40,206,199,0.8)';
			} else {
				context.fillStyle = 'rgba(' + color + ',0.8)';
			}

			context.fill();
		}

		function timeStamp() {
			if (!Date.now) {
			    Date.now = function() { 
			    	return new Date().getTime(); 
			    };
			}

			return Date.now();
		}

		function roughSizeOfObject( object ) {

		    var objectList = [];
		    var stack = [ object ];
		    var bytes = 0;

		    while ( stack.length ) {
		        var value = stack.pop();

		        if ( typeof value === 'boolean' ) {
		            bytes += 4;
		        }
		        else if ( typeof value === 'string' ) {
		            bytes += value.length * 2;
		        }
		        else if ( typeof value === 'number' ) {
		            bytes += 8;
		        }
		        else if
		        (
		            typeof value === 'object'
		            && objectList.indexOf( value ) === -1
		        )
		        {
		            objectList.push( value );

		            for( var i in value ) {
		                stack.push( value[ i ] );
		            }
		        }
		    }

		    return bytes;
		}

		var SoundCloudAudioSource = function(audioElement) {
		    var player = document.getElementById(audioElement);
		    var self = this;
		    var analyser;
		    var audioCtx = new (window.AudioContext || window.webkitAudioContext); // this is because it's not been standardised accross browsers yet.
		    analyser = audioCtx.createAnalyser();
		    analyser.fftSize = 256; // see - there is that 'fft' thing. 
		    var source = audioCtx.createMediaElementSource(player); // this is where we hook up the <audio> element
		    source.connect(analyser);
		    analyser.connect(audioCtx.destination);
		    var sampleAudioStream = function() {
		        // This closure is where the magic happens. Because it gets called with setInterval below, it continuously samples the audio data
		        // and updates the streamData and volume properties. This the SoundCouldAudioSource function can be passed to a visualization routine and 
		        // continue to give real-time data on the audio stream.
		        analyser.getByteFrequencyData(self.streamData);
		        // calculate an overall volume value
		        var total = 0;
		        for (var i = 0; i < 80; i++) { // get the volume from the first 80 bins, else it gets too loud with treble
		            total += self.streamData[i];
		        }
		        self.volume = total;
		    };
		    setInterval(sampleAudioStream, 20); // 
		    // public properties and methods
		    this.volume = 0;
		    this.streamData = new Uint8Array(128); // This just means we will have 128 "bins" (always half the analyzer.fftsize value), each containing a number between 0 and 255. 
		    this.playStream = function(streamUrl) {
		        // get the input stream from the audio element
		        player.setAttribute('src', streamUrl);
		        player.play();
		    }
		};