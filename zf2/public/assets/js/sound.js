/**
 * A sound pool to use for the sound effects
 */

function playSound( sound ) {

	// check if ipad
	var jump_sound = sound;
	jump_sound.volume = .12;
	// jump_sound.load();
	jump_sound.play();

}

function loadSound( src, callback ) {		  
	var sound = new Audio( src );
	sound.addEventListener('loadeddata', function(){ callback( sound ); });
	sound.load();
}

function textToMessage( text ) {
    // var src = 'http://translate.google.com/translate_tts?tl=en&q=;
    var src = 'http://translate.google.com/translate_tts?tl=en&q=' + escape(text.replace(/ /gi,"+"));
    
    loadSound( src, function( sound ) {
    	playSound( sound );
    });
}

function test() {
	textToMessage( 'Hello World' );
}