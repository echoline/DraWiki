function newboard(blah) {
	var boardname = document.getElementById('boardname').value;

	if (boardname.length != 0)
		window.location.href = 'https://' + location.hostname + '/' + boardname;
}

