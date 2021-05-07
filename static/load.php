<?php /*
Copyright (C) 2011-2020 Eli Cohen

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
	if (!isset($_GET['url']) || $_GET['url'] == '' || !isset($_GET['ts']) || $_GET['ts'] == '')
		die('no');
	$url = strtolower(htmlentities(urlencode($_GET['url'])));
	$ts = strtolower(htmlentities(urlencode($_GET['ts'])));
	$hash = substr(base_convert(md5($url), 16, 10), 0, 8);

	if (!file_exists("/DraWiki/static/tmp/" . $hash . "/" . $ts . ".png"))
		die('no');

	if (!copy("/DraWiki/static/tmp/" . $hash . "/" . $ts . ".png", "/DraWiki/static/tmp/" . $hash . ".2.png"))
		die('no');

	header("Location: https://" . $_SERVER['HTTP_HOST'] . "/" . $url . "?ts=" . time());
?>
