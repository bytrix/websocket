<?php

require('Pusher.php');

$key = '8bb3cacf5137c936bec5';
$secret = 'd347d6199a70fb6a2b3f';
$app_id = '166707';
$pusher = new Pusher($key, $secret, $app_id);

if ($_POST) {
	$message = $_POST['message'];
	$username = $_POST['username'];

	$pusher->trigger('test_channel', 'my_event', array('username' => $username, 'message' => $message, 'time'=>date("Y-m-d H:i:s")) );
	// echo 'yes';
}