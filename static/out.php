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

	if (!isset($_POST['url']))
		die ("post, haste!");

	if (isset($_POST['json']) && (json_decode($_POST['json']) != NULL))
		system('echo -e ' . escapeshellarg($_POST['url']) . '\|' .
			escapeshellarg($_POST['json']) . ' >> ../data ');

	system('grep ' . escapeshellarg($_POST['url']) . '\| ../data | tail');

?>
