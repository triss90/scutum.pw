function toggleTheme() {
	var style = document.getElementById('style'),
		toggle = document.getElementById('theme');
	if(style.hasAttribute('media')) {
		style.removeAttribute('media');
		localStorage.setItem('style', '1');
	} else {
		style.setAttribute('media', 'max-width: 1px');
		localStorage.removeItem('style');
	}
}