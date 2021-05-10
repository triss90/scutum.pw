<?php
include "_inc/_app.php";
$app = new Password();
$siteTitle = "scutum.pw | Raw data";

// Get encrypted JSON from DB
$p = $_GET["p"];
$slug = substr($p, 0, 8);
$key = substr($p, 8, 64);
$pass = $app->DatabasePrepareQueryReturnFirstField("SELECT * FROM passwords WHERE slug = ?",[$slug]);
$new_read_count = $pass['read_count']+1;
$app->DatabaseUpdate("passwords", array('read_count'), array($new_read_count, $slug), "WHERE slug = ?" );
$new_time = date('Y-m-d H:i:s', strtotime('+24 hour',strtotime($pass['created'])));

// Delete data
if ($pass['read_count'] >= $pass['read_limit']-1 && $pass['read_timer'] != 24) {
	$app->DatabaseUpdate("passwords", array('read_status'), array(1, $slug), "WHERE slug = ?" );
	$app->DatabaseDelete("passwords", "WHERE slug = ?", [$slug]);
}
?>

<style>
* {	
	font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
}
</style>

<script type="text/javascript" src="/assets/js/sjcl.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<h3>Decrypted string: <span id="output" class="active"></span></h3>

<?php if ($pass["read_status"] == 1 || $pass["read_status"] == "") { ?>
	<script>
		var output = document.getElementById('output');
		output.innerHTML += '<span style="color:#f06966;">This string does not exist!</span>';
	</script>
<?php } else { ?>
	<script>
		var output = document.getElementById('output');
		output.innerHTML = '<span style="color:#6abe83">' + sjcl.decrypt('<?php echo $key; ?>', '<?php echo $pass[ "sjcl_json"]; ?>')+ '</span>';
	</script>
<?php } ?>

<?php if ($pass['read_timer'] == "24") { ?>
<p>This password expires: <span <span style="color:#f1ac9d"><?php echo $new_time; ?></span></p>
<?php } else if($pass['read_count'] <= $pass['read_limit']-1 && $pass['id'] != "") { ?>
<p>Views: <span <span style="color:#f1ac9d"><?php echo $pass['read_count']+1 . " / " . $pass['read_limit']; ?></span></p>
<?php } ?>