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

	header('Content-type: text/plain');

	if (!isset($_POST['url']) || !isset($_POST['last']))
		die ("no");

	require '../login.php';

	$my_mysql = mysqli_connect($my_host, $my_user, $my_pass, $my_db, $my_port, $my_socket);
	if ($my_mysql == NULL)
		die ('0');

	$last = mysqli_real_escape_string($my_mysql, htmlentities($_POST['last']));
	$url = htmlentities(mysqli_real_escape_string($my_mysql, urlencode(strtolower($_POST['url']))));
	$hash = substr(base_convert(md5($url), 16, 10), 0, 8);

	print time() . "\n";

//	if ($last == 0)
//		exit(0);

	$results = mysqli_query($my_mysql, 'select d,id,color,erased,size from paths where (time>=' . $last . ' and hash=\'' . $hash  . '\' and url=\'' . $url . '\');');
	if ($results == NULL)
		die (mysqli_error ($my_mysql));

	$rows = mysqli_num_rows($results);
	while ($row = mysqli_fetch_row($results)) {
		if (!preg_match('/^M [0-9]+ [0-9]+/', $row[0]))
			continue;
		if (preg_match('/[^ML\-0-9\ ]/', $row[0]))
			continue;
		if (preg_match('/L[^ ]/', $row[0]))
			continue;
		if (preg_match('/[^ ]L/', $row[0]))
			continue;
		if (preg_match('/[^ \-0-9]0-9/', $row[0]))
			continue;
		if (!preg_match('/^[0-9]+$/', $row[4]))
			continue;
		if ($row[4] < 4 || $row[4] > 16)
			continue;
		if (!preg_match('/^(black|brown|red|orange|yellow|green|blue|purple|pink|gray|white)$/', $row[2]))
			continue;

		print json_encode ($row) . "\n";
	}
?>
