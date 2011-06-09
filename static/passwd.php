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

	$url = '';

	require 'login.php';

	$my_mysql = mysql_connect($my_host, $my_user, $my_pass);
	if ($my_mysql == NULL)
		die (mysql_error($my_mysql));

	mysql_select_db('whiteboard', $my_mysql) or 
		die (mysql_error($my_mysql));

	if (isset($_POST['url']))
		$url = mysql_real_escape_string($_POST['url']);
	else if (!isset($_SERVER['HTTP_REFERER']))
		die ("and how did YOU end up here?!");

	if ($url == '')
		$url = mysql_real_escape_string($_SERVER['HTTP_REFERER']);

	$results = mysql_query('select passwd from passwds where url=\'' .
				$url . '\'', $my_mysql);
	if ($results == NULL)
		die (mysql_error($my_mysql));

	$rows = mysql_num_rows($results);
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Authentication</title>
	<script type="text/javascript" src="/static/md5.js"></script>
</head>
<body>
<?php
	if ($rows == 0) {
		if (!isset($_POST['url'])) {
?>
<form method="post" action="/static/passwd.php">
	<fieldset>
	<legend>Create password</legend>
	<input type="hidden" name="url" value="<?php echo $url ?>"/>
	<label>Password: <input type="password" name="pass[0]" onblur="this.value = MD5(this.value)"/></label><br/>
	<label>Confirm: <input type="password" name="pass[1]" onblur="this.value = MD5(this.value)"/></label><br/>
	<input type="submit" value="Set password"/>
	</fieldset>
</form>
<?php
		} else if ($_POST['pass'][0] != $_POST['pass'][1]) {
?>
<p>passwords do not match</p>
<?php
		} else if (strlen($_POST['pass'][0]) != 0) {
			if (mysql_query('insert into passwds values(\'' . $url 
			.  '\', \'' 
			. mysql_real_escape_string($_POST['pass'][0])
			. '\');')) {
?>
<script>
<!--
	document.cookie = 'passwd=<?php echo $_POST['pass'][0]; ?>; path=/;';
-->
</script>
<p>password set</p>
<p><a href="<?php echo $url ?>">return</a></p>
<?php
			} else {
				echo '<p>' . mysql_error($my_mysql) . "</p>\n";
			}
		} else {
?>
<p>passwords need length</p>
<?php
		}
	} else if (!isset($_POST['url'])) {
		if (!isset($_POST['passwd'])) {
?>
<form method="post" action="/static/passwd.php">
	<fieldset>
	<legend>Enter password</legend>
	<input type="hidden" name="url" value="<?php echo $url ?>"/>
	<label>Password: <input type="password" name="passwd" onblur="this.value = MD5(this.value)"/></label><br/>
	<input type="submit" value="Authenticate"/>
	</fieldset>
</form>
<?php
		} else {
			$row = mysql_fetch_row($results);
			if ($_POST['passwd'] == $row[0]) {
?>
<script>
<!--
	document.cookie = 'passwd=<?php echo $_POST['passwd']; ?>; path=/;';
-->
</script>
<p>authenticated</p>
<p><a href="<?php echo $url ?>">return</a></p>
<?php
			} else {
?>
<p>incorrect password</p>
<?php
			}
		}
	} else {
?>
<script>
<!--
	document.cookie = 'passwd=<?php echo $_POST['passwd']; ?>; path=/;';
-->
</script>
<p>authenticated</p>
<p><a href="<?php echo $url ?>">return</a></p>
<?php
	}
?>
</body>
</html>
