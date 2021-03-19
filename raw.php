<?php
include("_inc/_app.php");
$app = new Password;
$siteTitle = "scutum.pw | Raw data";

// Get encrypted JSON from DB
$p = $_GET['p'];
$slug = substr($p, 0, 8);
$key = substr($p, 8, 64);
$pass = $app->DatabasePrepareQueryReturnFirstField("SELECT * FROM passwords WHERE slug = ?", array($slug));

// Delete data
$app->DatabaseDelete( "passwords", "WHERE slug = ?", array($slug));
?>

<script type="text/javascript" src="/assets/js/sjcl.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<h3>Decrypted string: <span id="output" class="active"></span></h3>


<?php if ($pass['read_status'] == 1 || $pass['read_status'] == "") { ?>
	<script>
		var output = document.getElementById('output');
		output.innerHTML += '<span style="color:red;">This string does not exist!</span>';
	</script>
<?php } else { ?>
	<script>
		var output = document.getElementById('output');
		output.innerHTML = '<span style="color:green">' + sjcl.decrypt('<?php echo $key ?>', '<?php echo $pass['sjcl_json']; ?>')+ '</span>';
	</script>
<?php } ?>
 
