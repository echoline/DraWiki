function newboard(blah) {
	var boardname = document.getElementById('boardname').value;

	if (boardname.length != 0)
		window.location.href = 'https://' + location.hostname + '/' + boardname;
}

function exportpng() {
	var div = document.getElementById('export');
	var boardname = location.pathname;

	div.innerHTML = '<img style="border:2px solid black" src="/static/export.php?url=' + parent.location.pathname + '&rand=' + Math.random() + '"/><br/>\n';
	div.innerHTML += 'Right-click to save this image<br/>\n';
	div.innerHTML += 'Embed code:<br/><code>&lt;embed src="https://' + location.hostname + '/static/board.php?url=' + boardname + '" type="image/svg+xml" style="width:960px;height:480px;"&gt</code><br/>\n';
}
