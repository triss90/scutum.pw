<?php
include "_inc/_app.php";
$app = new Password();

// Delete passwords older than 24 hours
foreach($passwords = $app->DatabasePrepareQuery("SELECT * FROM passwords WHERE read_timer = ?", array('24')) as $password) {	
	if (time() - strtotime($password['created']) > 60*60*24) {
		echo $password['created'] . "- DELETED<br>";
	} else {
		echo $password['created'] . "<br>";
	}
}