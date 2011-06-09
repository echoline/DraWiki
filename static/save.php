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

	require 'login.php';

	$my_mysql = mysql_connect($my_host, $my_user, $my_pass);
	if ($my_mysql == NULL)
		die (mysql_error($my_mysql));

	mysql_select_db('whiteboard', $my_mysql) or 
		die (mysql_error($my_mysql));

	$url = mysql_real_escape_string($_POST['url']);

	$results = mysql_query('select passwd from passwds where url=\'' 
				. $url . '\'');

	$rows = mysql_num_rows($results);
	if ($rows != 0) {
		$row = mysql_fetch_row($results);
		if ($row[0] != $_COOKIE['passwd'])
			die('incorrect password');
	}

	$json = json_decode($_POST['json'], true);
	if ($json == NULL)
		die('invalid json');

	$paths = $json['paths'];

	for ($i = 0; $i < count($paths); $i++) {
		if (!preg_match('/ L /', $paths[$i]['attributes']['d']))
			continue;

		mysql_query('replace into paths values (\'' . $url . '\', \'' .
		    mysql_real_escape_string($paths[$i]['attributes']['id']) .
		    '\', \'' .
		    mysql_real_escape_string($paths[$i]['attributes']['d']) .
		    '\', \'' .
		    mysql_real_escape_string($paths[$i]['attributes']['stroke']) .
		    '\')') or
			die(mysql_error($my_mysql));
	}
	echo 'saved as ' . $url;
?>
