<?php /*
Copyright (C) 2011 Eli Cohen

This file is part of DraWiki.

DraWiki is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

DraWiki is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with DraWiki.  If not, see <http://www.gnu.org/licenses/>.
*/
	if (!isset ($_GET['url']))
		exit(0);

	require '../login.php';

	$my_mysql = mysqli_connect($my_host, $my_user, $my_pass, $my_db, $my_port, $my_socket);
	if ($my_mysql == NULL)
		die ('mysqli_connect');

	$url = mysqli_real_escape_string($my_mysql, urlencode(strtolower($_GET['url'])));
	$hash = substr(base_convert(md5($url), 16, 10), 0, 8);

	header ('Content-type: image/png');
	header ('Content-Disposition: attachment; filename="' . $url . '.png"; filename*=UTF-8\'\'' . $url . '.png');

	while(file_exists("/DraWiki/static/tmp/" . $hash . ".lock")) usleep(1000000);
	touch ("/DraWiki/static/tmp/" . $hash . ".lock");

	$results = mysqli_query($my_mysql, 'select * from paths where hash=\'' . $hash . '\' order by time');

	function callback($buffer) {
		global $hash;

		file_put_contents('/DraWiki/static/tmp/' . $hash . '.svg', $buffer);
		system ('/usr/local/bin/rsvg-convert -o /DraWiki/static/tmp/' . $hash . '.png /DraWiki/static/tmp/' . $hash . '.svg');
#		system ('/usr/local/bin/convert /DraWiki/static/tmp/' . $hash . '.svg /DraWiki/static/tmp/' . $hash . '.png');

		return file_get_contents('/DraWiki/static/tmp/' . $hash . '.png');
	}

	ob_start("callback");
?><!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="960" height="480">
<rect x="0" y="0" width="960" height="480" fill="white" stroke="white"/>
<?php
	if (file_exists('/DraWiki/static/tmp/' . $hash . '.2.png')) {
?><image x="0" y="0" width="960px" height="480px" xlink:href="file:///DraWiki/static/tmp/<?php

	print $hash;
	
?>.2.png"></image>
<?php
	}

	if ($results != NULL) {
		while ($row = mysqli_fetch_row($results)) {
			if (!preg_match('/^M [0-9]+ [0-9]+/', $row[2]))
				continue;
			if (preg_match('/[^ML\-0-9\ ]/', $row[2]))
				continue;
			if (preg_match('/L[^ ]/', $row[2]))
				continue;
			if (preg_match('/[^ ]L/', $row[2]))
				continue;
			if (preg_match('/[^ \-0-9]0-9/', $row[2]))
				continue;
			if (!preg_match('/^[0-9]+$/', $row[7]))
				continue;
			if ($row[7] < 4 || $row[7] > 16)
				continue;
			if (!preg_match('/^(black|brown|red|orange|yellow|green|blue|purple|pink|gray|white)$/', $row[3]))
				continue;

			print '<path d="' . $row[2] . '" stroke="' . $row[3] . '" stroke-width="' . $row[7] . '" fill="none"/>' . "\n";
			$results2 = mysqli_query($my_mysql, 'delete from paths where hash=\'' . $hash . '\' and id=\'' . $row[1] . '\'');
			if ($results2 == NULL)
				die (mysqli_error ($my_mysql));
		}
	}
?>
</svg><?php
	ob_end_flush();
	copy ('/DraWiki/static/tmp/' . $hash . '.png', '/DraWiki/static/tmp/' . $hash . '.2.png');
	unlink("/DraWiki/static/tmp/" . $hash . '.lock');
?>
