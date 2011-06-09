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

	header('Content-type: image/svg+xml');

	include 'login.php';

	$my_mysql = mysql_connect($my_host, $my_user, $my_pass);
	if ($my_mysql == NULL)
		die (mysql_error($my_mysql));

	mysql_select_db('whiteboard', $my_mysql) or 
		die (mysql_error($my_mysql));

	$url = mysql_real_escape_string('http://' . $_SERVER['SERVER_NAME'] . 
					$_SERVER['REQUEST_URI']);

	$results = mysql_query('select passwd from passwds where url=\'' . 
				$url . '\'', $my_mysql);
	if ($results == NULL)
		die (mysql_error($my_mysql));

	$protected = mysql_num_rows($results);
	if ($protected != 0) {
		$row = mysql_fetch_row($results);
		$passwd = $row[0];
	}

	$results = mysql_query('select * from paths where url=\'' . 
				$url . '\'', $my_mysql);
	if ($results == NULL)
		die (mysql_error($my_mysql));
?>
<?xml version="1.0" standalone="no"?>
<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" onload="setup(evt);" width="100%" height="100%">
<script xlink:href="/static/board.js"></script>
<?php
	$rows = mysql_num_rows($results);
	for ($i = 0; $i < $rows; $i++) {
		$row = mysql_fetch_row($results);
		echo '<path stroke="' . $row[3] 
			. '" stroke-width="4" fill="none" id="' 
			. $row[1] . '" d="' . $row[2] . "\"/>\n";
	}

	if (($protected == 0) || ($_COOKIE['passwd'] == $passwd)) {
?>
<a xlink:href="javascript:save();"><text x="10" y="20" fill="blue" id="save">Save</text></a>
<?php
		if ($protected == 0) {
?>
<a xlink:href="/static/passwd.php"><text x="90" y="20" fill="blue">Set password required to save</text></a>
<?php
		}
	} else {
?>
<a xlink:href="/static/passwd.php"><text x="10" y="20" fill="blue">Login</text></a>
<?php
	}
?>
<rect x="10" y="30" width="10" height="10" fill="black" stroke="black" onclick="color(this)"/>
<rect x="10" y="50" width="10" height="10" fill="brown" stroke="black" onclick="color(this)"/>
<rect x="10" y="70" width="10" height="10" fill="red" stroke="black" onclick="color(this)"/>
<rect x="10" y="90" width="10" height="10" fill="orange" stroke="black" onclick="color(this)"/>
<rect x="10" y="110" width="10" height="10" fill="yellow" stroke="black" onclick="color(this)"/>
<rect x="10" y="130" width="10" height="10" fill="green" stroke="black" onclick="color(this)"/>
<rect x="10" y="150" width="10" height="10" fill="blue" stroke="black" onclick="color(this)"/>
<rect x="10" y="170" width="10" height="10" fill="purple" stroke="black" onclick="color(this)"/>
<rect x="10" y="190" width="10" height="10" fill="pink" stroke="black" onclick="color(this)"/>
<rect x="10" y="210" width="10" height="10" fill="white" stroke="black" onclick="color(this)"/>
<g id="unsaved"/>
</svg>
