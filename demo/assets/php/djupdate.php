<?php
require_once('config.php');
require_once('Pusher.php');

$pusher = new Pusher($app_key, $app_secret, $app_id);

$data['message'] = 'update_dj_123';
$data['updatedj'] = $dj_ip;

$pusher->trigger($app_channel, 'my_event', $data);