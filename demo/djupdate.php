<?php
require('./assets/php/config.php');
require('./assets/php/Pusher.php');

$pusher = new Pusher($app_key, $app_secret, $app_id);

$data['message'] = 'update_dj_123';
$data['updatedj'] = $dj_ip;

$pusher->trigger($app_channel, 'my_event', $data);