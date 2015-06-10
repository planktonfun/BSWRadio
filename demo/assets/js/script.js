		
// Game Script
var rps_map = {
		Rock: { weakness: 'Paper', strength: 'Scissor' },
		Scissor: { weakness: 'Rock', strength: 'Paper' },
		Paper: { weakness: 'Scissor', strength: 'Rock' }
	};

var outcome = false;
var score_you = 0;
var score_opponent = 0;
var selected = false;

$('button').click(function(){

	selected = $(this).text();
	
	send( selected );

});

function think( ) {

	if( !opponent_hand ){
		log( 'Waiting for opponent hand' );

		return; 
	}
	if( !selected ){
		log( 'Waiting for your hand' );

		return;
	}

	if( opponent_hand == selected ) outcome = 'Tie';
	
	if( rps_map[opponent_hand].strength == selected ) {
		outcome = 'Lose';
		score_opponent++;
	}

	if( rps_map[selected].strength == opponent_hand ) {
		outcome = 'Win';
		score_you++;
	}

	$('#opponent').text( 'opponent: ' + opponent_hand + '\nyou: ' + selected + '\noutcome: ' + outcome );	
	$('#score_you').text( score_you );	
	$('#score_opponent').text( score_opponent );

	// clear both hands
	opponent_hand = false;
	selected = false;

}