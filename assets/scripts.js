Array.from(document.querySelectorAll('.vil-player')).map(p => {
	player = new Plyr(p);
	player.on('enterfullscreen', event => {
		screen.orientation.lock('landscape');
	});
	  player.on('exitfullscreen', event => {
		screen.orientation.unlock();
	});
});
