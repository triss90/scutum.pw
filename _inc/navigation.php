<nav>
	<div class="logo">
		<a href="/">scutum.pw</a>
	</div>
	<ul>
		<li><a href="/">Home</a></li>
		<li><a href="/faq.php">FAQ</a></li>
		<li><a href="https://github.com/triss90/scutum.pw" target="_blank">Github</a></li>
		<li>
			<div class="checkbox-header">
				<input type="checkbox" id="theme" name="theme" onchange="toggleTheme(this);" class="checkbox-header-input"/>
				<label for="theme" class="checkbox-header-label"></label>    
			</div>
		</li>
	</ul>
</nav>
<script>
   if (localStorage.getItem('style') === '1') {
	   document.getElementById('style').removeAttribute('media');
	   document.getElementById('theme').checked = true;
   }
</script>