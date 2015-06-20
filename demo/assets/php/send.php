<?php

require('Pusher.php');

$app_id = '75978';
$app_key = 'c7074daf2062830b98d0';
$app_secret = 'ea27c6ff5e8972016a0f';
$dj_ip = '192.168.1.113';

$pusher = new Pusher($app_key, $app_secret, $app_id);

if(isset($_POST['message'])) {
	$data['message'] = $_POST['message'];
	$data['localip'] = $_POST['localip'];
} else {
	$data['message'] = 'hello world';
	$data['localip'] = 'n/a';
}

if ( strpos( $data['localip'], $dj_ip ) !== false ) {    
	$pusher->trigger('test_channel', 'my_event', $data);
}
