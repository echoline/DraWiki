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

	$ret = 0;

	if (!isset($_POST['json']) || !isset($_POST['url']))
		die ("no");

	require '../login.php';

	$my_mysql = mysqli_connect($my_host, $my_user, $my_pass, $my_db, $my_port, $my_socket);
	if ($my_mysql == NULL)
		die (mysqli_error($my_mysql));

	$url = mysqli_real_escape_string($my_mysql, strtolower($_POST['url']));

	if (($url == '/') && ($CAN_EDIT_MAIN == FALSE)) {
		echo $ret;
		exit (0);
	}

	$hash = substr(base_convert(md5($url), 16, 10), 0, 8);

	$json = json_decode($_POST['json'], true);
	if ($json == NULL)
		die('invalid json');

	$paths = $json['paths'];

	for ($i = 0; $i < count($paths); $i++) {
		if (!preg_match('/^M [0-9\.]+ [0-9\.]+/', $paths[$i][1]))
			die('2');
		if (preg_match('/[^ML\-0-9\.\ ]/', $paths[$i][1]))
			die('3');
		if (preg_match('/L[^ ]/', $paths[$i][1]))
			die('4');
		if (preg_match('/[^ ]L/', $paths[$i][1]))
			die('5');
		if (preg_match('/[^ \-0-9\.]0-9/', $paths[$i][1]))
			die('6');
		if (!preg_match('/^[0-9]+$/', $paths[$i][3]))
			die('7');
		if ($paths[$i][3] < 4 || $paths[$i][3] > 16)
			die('8');
		if (!preg_match('/^(black|brown|red|orange|yellow|green|blue|purple|pink|gray|white)$/', $paths[$i][2]))
			die('9');

		mysqli_query($my_mysql, 'replace into paths values (\'' . $url
		    . '\', \'' . rand() . '\', \'' .
		    htmlentities(mysqli_real_escape_string($my_mysql,
		    $paths[$i][1])) . '\', \'' .
		    htmlentities(mysqli_real_escape_string($my_mysql,
		    $paths[$i][2])) . '\', \'' . $hash . '\', \'' . time() .
		    '\', false, \'' .
		    htmlentities(mysqli_real_escape_string($my_mysql,
		    $paths[$i][3])) . '\')') or
			die(mysqli_error($my_mysql));
		$ret = 1;
	}

	echo $ret;
?>
