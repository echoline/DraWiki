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
		die ("post, haste!");

	require '../login.php';

	$my_mysql = mysql_connect($my_host, $my_user, $my_pass);
	if ($my_mysql == NULL)
		die (mysql_error($my_mysql));

	mysql_select_db('whiteboard', $my_mysql) or 
		die (mysql_error($my_mysql));

	$last = mysql_real_escape_string($_POST['last']);
	$url = mysql_real_escape_string(strtolower($_POST['url']));
	$hash = substr(base_convert(md5($url), 16, 10), 0, 8);

	print time() . "\n";

//	if ($last == 0)
//		exit(0);

	$results = mysql_query('select d,id,color,erased,size from paths where (time>=' . $last . ' and hash=\'' . $hash  . '\' and erased=false) or (time>=' . ($last-240) . ' and erased=true);', $my_mysql);
	if ($results == NULL)
		die (mysql_error ($my_mysql));

	$rows = mysql_num_rows($results);
	while ($row = mysql_fetch_row($results))
		print json_encode ($row) . "\n";
?>
