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

	header ('Content-type: image/png');

	require '../login.php';

	$my_mysql = mysql_connect($my_host, $my_user, $my_pass);
	if ($my_mysql == NULL)
		die (mysql_error($my_mysql));

	$url = mysql_real_escape_string(strtolower($_GET['url']));
	$hash = substr(base_convert(md5($url), 16, 10), 0, 8);
	$ftime = filemtime('./tmp/' . $hash . '.png') + 7;
	$time = time();

	if (file_exists('./tmp/' . $hash . '.png') && ($time < $ftime)) {
		echo file_get_contents('./tmp/' . $hash . '.png');
		exit (0);
	}

	mysql_select_db('whiteboard', $my_mysql) or 
		die (mysql_error($my_mysql));

	$results = mysql_query('select * from paths where hash=\'' . $hash . '\' and erased=false');
	if ($results == NULL)
		die (mysql_error ($my_mysql));

	function callback($buffer) {
		global $hash;

		unlink ("./tmp/" . $hash . '.png');

		file_put_contents("./tmp/" . $hash . '.svg', $buffer);
		system ('/usr/bin/convert ./tmp/' . $hash . '.svg ./tmp/' . $hash . '.png');

		unlink ('./tmp/' . $hash . '.svg');

		return file_get_contents('./tmp/' . $hash . '.png');
	}

	ob_start("callback");
?>
<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="960" height="480">
<rect x="0" y="0" width="960" height="480" fill="white" stroke="white"/>
<?php

	$rows = mysql_num_rows($results);
	while ($row = mysql_fetch_row($results))
		print '<path d="' . $row[2] . '" stroke="' . $row[3] . '" stroke-width="' . $row[7] . '" fill="none"/>' . "\n";
?>
</svg>
<?php
	ob_end_flush();
?>
