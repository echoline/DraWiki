<?php
	/*
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

# convert -size 960x480 svg:- jpeg:- < test.svg > test.jpg
	if (!isset ($_GET['url']))
		exit(0);

	require '../login.php';

	$my_mysql = mysqli_connect($my_host, $my_user, $my_pass, $my_db, $my_port, $my_socket);
	if ($my_mysql == NULL)
		die (mysqli_error($my_mysql));

	$url = mysqli_real_escape_string($my_mysql, strtolower($_GET['url']));
	$hash = substr(base_convert(md5($url), 16, 10), 0, 8);

	while(file_exists("/tmp/" . $hash . ".lock")) usleep(1000000);
	touch ("/tmp/" . $hash . ".lock");

	header ('Content-type: image/png');
	header ('Content-Disposition: inline; filename="' . preg_replace("%/%", "_", $url) . '.png"');

	$results = mysqli_query($my_mysql, 'select * from paths where hash=\'' . $hash . '\' order by time');

	function callback($buffer) {
		global $hash;

		chdir('/');
		file_put_contents('/tmp/' . $hash . '.svg', $buffer);
		system ('/usr/local/bin/convert /tmp/' . $hash . '.svg /tmp/' . $hash . '.png');

		return file_get_contents('/tmp/' . $hash . '.png');
	}

	ob_start("callback");
?>
<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="960" height="480">
<rect x="0" y="0" width="960" height="480" fill="white" stroke="white"/>
<?php
	if (file_exists('/tmp/' . $hash . '.2.png')) {
?><image x="0" y="0" width="960px" height="480px" href="file:///tmp/<?php

	echo $hash;
	
?>.2.png"></image>
<?php
	}

	if ($results != NULL) {
		while ($row = mysqli_fetch_row($results)) {
			print '<path d="' . $row[2] . '" stroke="' . $row[3] . '" stroke-width="' . $row[7] . '" fill="none"/>' . "\n";
			$results2 = mysqli_query($my_mysql, 'delete from paths where hash=\'' . $hash . '\' and id=\'' . $row[1] . '\'');
			if ($results2 == NULL)
				die (mysqli_error ($my_mysql));
		}
	}
?>
</svg><?php
	ob_end_flush();
	copy ('/tmp/' . $hash . '.png', '/tmp/' . $hash . '.2.png');
	unlink("/tmp/" . $hash . '.lock');
?>
