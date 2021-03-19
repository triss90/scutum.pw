<?php
include("_inc/_functions.php");
include("_inc/_app.php");
$app = new Password;

// Validate POST data
if (!isset($_POST['key']) || empty($_POST['key'])) {
	header('Location: /');
	exit;
}
if (!isset($_POST['json']) || empty($_POST['json'])) {
	header('Location: /');
	exit;
}

// Prepare variables
$slug = generateRandomString(8);
$key = trim($_POST['key']);
$json = trim($_POST['json']);
$date = date("Y-m-d H:i:s");

// Insert json in DB
$app->DatabaseInsert("passwords", array('created','read_status','sjcl_json','slug'), array($date,0,$json,$slug));

// Print result
echo '<p>Your secure link:<br> <a href="//localhost:8888/view.php?p='.$slug.$key.'">https://localhost:8888/view.php?p='.$slug.$key.'</a></p>';
echo '<p>Your raw link:<br> <a href="//localhost:8888/raw.php?p='.$slug.$key.'">https://localhost:8888/raw.php?p='.$slug.$key.'</a></p>';
echo '<p><i>Be advised, the contents of the link above will be deleted after the first view!</i></p>';
?>