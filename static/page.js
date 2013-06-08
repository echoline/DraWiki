function newboard(blah) {
	var boardname = document.getElementById('boardname').value;

	if (boardname.length != 0)
		window.location.href = 'http://echoline.org/' + boardname;
}

function exportpng() {
	var div = document.getElementById('export');

	div.innerHTML = '<img style="border:none" src="/static/export.php?url=' + parent.location.pathname + '"/><br/>\n';
	div.innerHTML += 'Right-click to save this one\n';
}
