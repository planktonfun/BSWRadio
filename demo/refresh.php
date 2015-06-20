<?php
require_once('./assets/php/config.php');
require_once('./assets/php/Pusher.php');

$pusher = new Pusher($app_key, $app_secret, $app_id);

if(isset($_POST['message'])) {
	$data['message'] = $_POST['message'];
} else {
	$data['message'] = 'refresh_this_123';
}

$pusher->trigger($app_channel, 'my_event', $data);