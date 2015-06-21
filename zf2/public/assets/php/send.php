<?php

require_once('config.php');
require_once('Pusher.php');

$pusher = new Pusher($app_key, $app_secret, $app_id);

if(isset($_POST['message'])) {
	$data['message'] = $_POST['message'];
	$data['localip'] = $_POST['localip'];
	$data['updatedj'] = false;
} else {
	$data['message'] = 'hello world';
	$data['localip'] = 'n/a';
	$data['updatedj'] = false;
}

if ( strpos( $data['localip'], $dj_ip ) !== false ) {    
	$pusher->trigger($app_channel, 'my_event', $data);
}
