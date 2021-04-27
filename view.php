<?php
include("_inc/_app.php");
$app = new Password;
$siteTitle = "scutum.pw | View";

// Get encrypted JSON from DB
$p = $_GET['p'];
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

include("_inc/header.php");
?>

<div class="container">
	
	<?php include("_inc/navigation.php"); ?>
	
	<div class="row">
		<h1 id="funky"><a href="/">Welcome to scutum.pw</a></h1>
	</div>
	
	<div class="row">
		<h3>Here is your decrypted string:</h3><br>
		<div class="col tiny-12 medium-12" id="col">
			<div id="output" class="active"></div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col tiny-12 medium-12">
			<?php if ($pass['read_timer'] == "24") { ?>
				<p>This password expires: <span class="highlight"><?php echo $new_time; ?></span></p>
			<?php } else if($pass['read_count'] <= $pass['read_limit']-1 && $pass['id'] != "") { ?>
				<p>Views: <span class="highlight"><?php echo $pass['read_count']+1 . " / " . $pass['read_limit']; ?></span></p>
			<?php } ?>
			<div id="explain"></div>
		</div>
	</div>
	
	<div class="row"><p><a href="/">Back</a> | <a href="/faq.php">Questions? See the Official FAQ.</a></p></div>
	
</div>
	 
	<?php if ($pass['read_status'] == 1 || $pass['read_status'] == "") { ?>
		<script>
			var output = document.getElementById('output');
			var col = document.getElementById('col');
			col.classList.add('error');
			output.innerHTML += '<h2>This string does not exist!</h2>';
			explain.innerHTML += '<ul>';
			explain.innerHTML += '<li>The link has expired. We only store the information for 24 hours.</li>';
			explain.innerHTML += '<li>You\'ve already visited the link before. The link selfdestructs after the first visit</li>';
			explain.innerHTML += '<li>The URL is wrong. Please check for spelling errors and typos.</li>';
			explain.innerHTML += '<li>Someone else has viewed the link before you. You should take steps in order to mitigate onsequences that may arise from someone else having read the message.</li>';
			explain.innerHTML += '<ul>';
		</script>
	<?php } else { ?>
		<script>
			var output = document.getElementById('output');
			var explain = document.getElementById('explain');
			var col = document.getElementById('col');
			col.classList.add('success');
			output.innerHTML = '<h2>' + sjcl.decrypt('<?php echo $key ?>', '<?php echo $pass['sjcl_json']; ?>')+ '</h2>';
			explain.innerHTML += '<p><i>Remember to save the decrypted content somewhere safe. All trace of the string above has already been deleted from our servers!</i><p>'
		</script>
	<?php } ?>
 
<?php include("_inc/footer.php"); ?>