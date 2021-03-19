<?php
include("_inc/_functions.php");
$key = generateRandomString(64);
$siteTitle = "scutum.pw";

include("_inc/header.php");
?>

<div class="container">
	
	<?php include("_inc/navigation.php"); ?>
	
	<div class="row center-tiny start-medium">
		<h1 id="funky"><a href="/">Welcome to scutum.pw</a></h1>
	</div>
	
	<div class="row center-tiny start-medium"><p><a href="/faq.php">Questions? See the Official FAQ.</a></p></div>
	
	<div class="row">
		
		<div class="col tiny-12 medium-6">
			<p>scutum.pw allows you to encrypt and transfer passwords and other sensitive data via a one-time link. <wbr> 
			The recipient can only view the page once, after which, the data is destroyed completely.</p>
			<hr>
			<h2>Encrypt</h2>
			<p>Enter your password or string to securely encrypt it:</p>
			<form action="encrypt.php" method="post" id="encryptString">
				<textarea name="string"  id="string" cols="30" rows="10" required placeholder="Enter password or string here..."></textarea><br>
				<input type="hidden" name="key" id="key" required value="<?php echo $key; ?>">
				<input type="hidden" name="json" id="json" required value="test"></input>
				<div class="checkbox">
					<input type="checkbox" id="leakedpassword" name="leakedpassword" value="1" />
					<label for="leakedpassword" class="checkbox-label">Test password with <a href="leakedpassword.com">leakedpassword.com</a></label>
				</div>				
				<br><br>
				<button id="encrypt" type="submit">Generate secure link</button><br><br>
			</form>
			<hr>
			<div id="loader"></div>
			<div id="output"></div>
			<div id="leak"></div>
		</div>
		
		<div class="col tiny-12 medium-6">
			<h2>One time only</h2>
			<p>Instead of sending passwords or other sensible data by email og text, you can safely store it on our servers and send the unique link instead. Once the intended recipient has accessed the link, it is deleted immediately. Thus you can be confident that nobody else has seen or read the message before or afterwards!</p>
			<hr>
			<h2>Security</h2>
			<p>We use strong cryptographic algorithms to safely encrypt your data. Encryption is performed directly in your browser, before it is sent to our servers. As such, neither we, nor anyone else can read or access your original data. All data is protected by a unique random password. Only the person with the unique link can access the data.</p>
			<hr>
			<h2>Trust</h2>
			<p>Although we have no feasible way of accessing or reading your data, you still have to trust us with it. No matter how secure we have made our service, encryption in the browser is not perfect. <a href="/faq.php">Read the FAQ</a> to find out more.</p>
			<hr>
			<h2>collaboration</h2>
			<p>We work closely with <a href="leadkedpassword.com">leakedpassword.com</a> to provide a simple test on the entered information. By accepting this, you accept sending your information to their servers. For more info on security, please visit their website.</p>
		</div>
		
	</div>
	
</div>
<br><br><br>

<script>
	$("#encryptString").submit(function(e) {
		e.preventDefault();
		// Leaked password integration, good idea?
		var leakedpassword = document.getElementById('leakedpassword');
		document.getElementById('leak').innerHTML = "";
		if (leakedpassword.checked == true) {
			console.log('checked');
			$.getJSON("https://leakedpassword.com/api/?p="+event.target.value, function(data) {
				if (data.password.leak == true) {
					document.getElementById('leak').innerHTML = "<p class='alert'>It appears the string has been leaked as part of hacked password dump! - <i>Thanks to our friends over at <a href='https://leakedpassword.com' target='_blank'>leakedpassword.com</a></i></p>"
				}
			});
		}
		// Post form
		var form = $(this);
		var url = form.attr('action');
		var customString = document.getElementById('string').value;
		var encrypted = sjcl.encrypt("<?php echo $key ?>", customString);
		$("#json").val(encrypted);
		$.ajax({
			type: "POST",
			url: url,
			data: form.serialize(),
			beforeSend: function() {
				$('#output').removeClass('active');
				$('#loader').addClass('active');
				$('#encrypt').addClass('disabled');
				$('#encrypt').attr('disabled', true);
			},
			success: function (response) {
				setTimeout(function(){ 
					$('#output').addClass('active');
					$('#loader').removeClass('active');
					$('#encrypt').removeClass('disabled');
					$('#encrypt').attr('disabled', false);
					$('#output').html(response);
				}, Math.floor(Math.random() * 3501));
			},
			error: function (response) {
				// Error
			}
		});
	});
</script>

<?php include("_inc/footer.php"); ?>

