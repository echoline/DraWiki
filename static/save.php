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

	if (!isset($_POST['json']) || !isset($_POST['url']))
		die ("post, haste!");

	require '../login.php';

	$my_mysql = mysql_connect($my_host, $my_user, $my_pass);
	if ($my_mysql == NULL)
		die (mysql_error($my_mysql));

	mysql_select_db('whiteboard', $my_mysql) or 
		die (mysql_error($my_mysql));

	$url = mysql_real_escape_string(strtolower($_POST['url']));

	if (($url == '/') && ($CAN_EDIT_MAIN == FALSE))
		exit (0);

	$hash = substr(base_convert(md5($url), 16, 10), 0, 8);

	$json = json_decode($_POST['json'], true);
	if ($json == NULL)
		die('invalid json');

	$paths = $json['paths'];

	for ($i = 0; $i < count($paths); $i++) {
		if (!preg_match('/ L /', $paths[$i][1]))
			continue;

		mysql_query('replace into paths values (\'' . $url . '\', \'' .
		    htmlentities(mysql_real_escape_string($paths[$i][0])) .
		    '\', \'' .
		    htmlentities(mysql_real_escape_string($paths[$i][1])) .
		    '\', \'' .
		    htmlentities(mysql_real_escape_string($paths[$i][2])) .
		    '\', \'' . $hash . '\', \'' . time() . '\', false, \'' .
		    htmlentities(mysql_real_escape_string($paths[$i][3])) . '\')') or
			die(mysql_error($my_mysql));
	}
?>
