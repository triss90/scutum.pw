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
echo '<p>Your secure link:<br> 
  <button class="copy js-copy-btn" title="Copy Link">
    <svg ng-repeat="glyph in glyphs" id="iconDemo-copy" mi-view-box="0 0 1024 1024" viewBox="0 0 1024 1024">
      <title>Copy Link</title>
      <path ng-repeat="path in glyph.paths" class="path0" mi-d="M640 256v-256h-448l-192 192v576h384v256h640v-768h-384zM192 90.51v101.49h-101.49l101.49-101.49zM64 704v-448h192v-192h320v192l-192 192v256h-320zM576 346.51v101.49h-101.49l101.49-101.49zM960 960h-512v-448h192v-192h320v640z" mi-fill="" mi-stroke="inherit" mi-stroke-width="" mi-stroke-linecap="" mi-stroke-linejoin="" mi-stroke-miterlimit="" mi-opacity="" d="M640 256v-256h-448l-192 192v576h384v256h640v-768h-384zM192 90.51v101.49h-101.49l101.49-101.49zM64 704v-448h192v-192h320v192l-192 192v256h-320zM576 346.51v101.49h-101.49l101.49-101.49zM960 960h-512v-448h192v-192h320v640z" stroke="inherit"></path><!-- end ngRepeat: path in glyph.paths -->
    </svg>
  </button>
  <a class="copy-text" href="//scutum.pw/view.php?p=' .
  $slug .
  $key .
  '">https://scutum.pw/view.php?p=' .
  $slug .
  $key .
  "</a></p>";
echo '<p>Your raw link:<br> 
  <button class="copy js-copy-raw-btn" title="Copy Link">
    <svg ng-repeat="glyph in glyphs" id="iconDemo-copy" mi-view-box="0 0 1024 1024" viewBox="0 0 1024 1024">
      <title>Copy Link</title>
      <path ng-repeat="path in glyph.paths" class="path0" mi-d="M640 256v-256h-448l-192 192v576h384v256h640v-768h-384zM192 90.51v101.49h-101.49l101.49-101.49zM64 704v-448h192v-192h320v192l-192 192v256h-320zM576 346.51v101.49h-101.49l101.49-101.49zM960 960h-512v-448h192v-192h320v640z" mi-fill="" mi-stroke="inherit" mi-stroke-width="" mi-stroke-linecap="" mi-stroke-linejoin="" mi-stroke-miterlimit="" mi-opacity="" d="M640 256v-256h-448l-192 192v576h384v256h640v-768h-384zM192 90.51v101.49h-101.49l101.49-101.49zM64 704v-448h192v-192h320v192l-192 192v256h-320zM576 346.51v101.49h-101.49l101.49-101.49zM960 960h-512v-448h192v-192h320v640z" stroke="inherit"></path><!-- end ngRepeat: path in glyph.paths -->
    </svg>
  </button>
  <a class="copy-text-raw"  href="//scutum.pw/raw.php?p=' .
  $slug .
  $key .
  '">https://scutum.pw/raw.php?p=' .
  $slug .
  $key .
  "</a></p>";
echo "<p><i>Be advised, the contents of the link above will be deleted after the first view!</i></p>";

echo "

<script>
// Copy text
function fallbackCopyTextToClipboard(text) {
  var textArea = document.createElement('textarea');
  textArea.value = text;
  
  // Avoid scrolling to bottom
  textArea.style.top = '0';
  textArea.style.left = '0';
  textArea.style.position = 'fixed';

  document.body.appendChild(textArea);
  textArea.focus();
  textArea.select();

  try {
  var successful = document.execCommand('copy');
  var msg = successful ? 'successful' : 'unsuccessful';
  console.log('Fallback: Copying text command was ' + msg);
  } catch (err) {
  console.error('Fallback: Oops, unable to copy', err);
  }

  document.body.removeChild(textArea);
}
function copyTextToClipboard(text) {
  if (!navigator.clipboard) {
  fallbackCopyTextToClipboard(text);
  return;
  }
  navigator.clipboard.writeText(text).then(function() {
  console.log('Async: Copying to clipboard was successful!');
  }, function(err) {
  console.error('Async: Could not copy text: ', err);
  });
}

var copyBtn = document.querySelector('.js-copy-btn'),
  copyTxt = document.querySelector('.copy-text'),
  copyRawBtn = document.querySelector('.js-copy-raw-btn'),
  copyRawTxt = document.querySelector('.copy-text-raw');

copyBtn.addEventListener('click', function(event) {
  copyTextToClipboard(copyTxt.innerHTML);
});

copyRawBtn.addEventListener('click', function(event) {
  copyTextToClipboard(copyRawTxt.innerHTML);
});
</script>
"
?>
