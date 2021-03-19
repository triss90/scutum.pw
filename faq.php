<?php
include("_inc/_functions.php");
$key = generateRandomString(64);
$siteTitle = "scutum.pw | FAQ";

include("_inc/header.php");
?>

<div class="container">
	
	<?php include("_inc/navigation.php"); ?>
	
	<div class="row center-tiny start-medium">
		<div class="tiny-12">
			<h1 id="funky"><a href="/">Welcome to scutum.pw</a></h1>
		</div>
	</div>
	
	<div class="row center-tiny start-medium">
		<div class="tiny-12">
			<h2>Frequently Asked Questions:</h2>
		</div>
	</div>
	
	
	<div class="row">
		<div class="col tiny-3 medium-3">
			<p>Are you really unable to read my data?</p>
		</div>
		<div class="col tiny-9 medium-9">
			<p>We only use strong cryptographic algorithms (e.g. AES), to randomly generate keys. The encryption is based upon the popular open source <a href="http://bitwiseshiftleft.github.io/sjcl/" target="_blank">Stanford JavaScript Crypto Library</a>. here is no way to crack the crypto itself and decipher your message.</p>
		</div>
	</div>
		
	<div class="row">
		<div class="col tiny-3 medium-3">
			<p>Why should I trust you with my data?</p>
		</div>
		<div class="col tiny-9 medium-9">
			<p>You shouldn't! </p>
		</div>
	</div>
	
	<div class="row">
		<div class="col tiny-3 medium-3">
			<p>How do you make money?</p>
		</div>
		<div class="col tiny-9 medium-9">
			<p>We don't. Full stop. This is strictly a non-profit project!</p>
		</div>
	</div>
	
	<div class="row">
		<div class="col tiny-3 medium-3">
			<p>How do I contact you?</p>
		</div>
		<div class="col tiny-9 medium-9">
			<p>You can reach out to <a href="https://triss.dev" target="_blank">Tristan White</a>, the creator and person responsible for maintaining this project.</p>
		</div>
	</div>
	
	<div class="row">
		<div class="col tiny-3 medium-3">
			<p>Have you had a trustworthy third party audit the your code?</p>
		</div>
		<div class="col tiny-9 medium-9">
			<p>No. Even if we had, the audit would only good at the very moment it was made. The site could very well be compromised. You'll have to trust that we handle the security properly!</p>
		</div>
	</div>
	
	<div class="row">
		<div class="col tiny-3 medium-3">
			<p>Is <a href="https://leakedpassword.com">leakedpassword.com</a> safe?</p>
		</div>
		<div class="col tiny-9 medium-9">
			<p>If you check your password or string against <a href="https://leakedpassword.com">leakedpassword.com</a>, it will be uploaded to their servers. Use this feature at your own discretion</p>
		</div>
	</div>
	
	<div class="row"><p><a href="/">Back</a></p></div>
	
</div>


<?php include("_inc/footer.php"); ?>

