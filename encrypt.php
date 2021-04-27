<?php
include "_inc/_functions.php";
include "_inc/_app.php";
$app = new Password();

// Validate POST data
if (!isset($_POST["key"]) || empty($_POST["key"])) {
  header("Location: /");
  exit();
}
if (!isset($_POST["json"]) || empty($_POST["json"])) {
  header("Location: /");
  exit();
}

// Prepare variables
$slug = generateRandomString(8);
$key = trim($_POST["key"]);
$json = trim($_POST["json"]);
$expiry = trim($_POST["expiry"]);
$date = date("Y-m-d H:i:s");

// If timer is set 
if($expiry == "24") {
  $timer = 24;
  $expiry = 0;
} else {
  $timer = 0;
}

// Insert json in DB
$app->DatabaseInsert(
  "passwords",
  ["created", "read_status", "read_limit", "read_count", "read_timer", "sjcl_json", "slug"],
  [$date, 0, $expiry, 0, $timer, $json, $slug]
);

// Print result
echo '<p>Your secure link:<br> <a href="//scutum.pw/view.php?p=' .
  $slug .
  $key .
  '">https://scutum.pw/view.php?p=' .
  $slug .
  $key .
  "</a></p>";
echo '<p>Your raw link:<br> <a href="//scutum.pw/raw.php?p=' .
  $slug .
  $key .
  '">https://scutum.pw/raw.php?p=' .
  $slug .
  $key .
  "</a></p>";
echo "<p><i>Be advised, the contents of the link above will be deleted after the first view!</i></p>";
?>
