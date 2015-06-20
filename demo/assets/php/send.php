<?php

require('config.php');
require('Pusher.php');

$pusher = new Pusher($app_key, $app_secret, $app_id);

if(isset($_POST['message'])) {
	$data['message'] = $_POST['message'];
	$data['localip'] = $_POST['localip'];
} else {
	$data['message'] = 'hello world';
	$data['localip'] = 'n/a';
}

if ( strpos( $data['localip'], $dj_ip ) !== false ) {    
	$pusher->trigger($app_channel, 'my_event', $data);
}
