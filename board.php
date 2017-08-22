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
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<link href="/static/default.css" type="text/css" rel="stylesheet"/>
	<title>Multiplayer Paint</title>
	<script src="/static/page.js"></script>
</head>
<body>
<div id="wrapper">
	<div id="header">
		<div id="logo">
			<h1><?php 

	echo $_SERVER['SERVER_NAME'];

			?></h1>
			<p><?php

#	if ($_SERVER['REQUEST_URI'] == '/')
#		echo 'drawingrooms';
#	else
	echo substr(htmlentities(urldecode($_SERVER['REQUEST_URI'])), 1);

			?></p>
		</div>
	</div>
	<div id="page">
		<div id="content">
<?php
	if ($_SERVER['REQUEST_URI'] != '/') {
?>
		<embed id="board" src="/static/board.php?url=<?php

		echo htmlentities($_SERVER['REQUEST_URI']);

		?>" type="image/svg+xml" style="width:960px; height:480px; border:2px solid black;">
<?php
	}
?>
<p>
<input type="text" style="width:33%" placeholder="<?php

	if (htmlentities($_SERVER['REQUEST_URI']) == '/')
		echo "Name your canvas here";
	else
		echo substr(htmlentities($_SERVER['REQUEST_URI']), 1);

?>" id="boardname" onkeydown="if (event.keyCode == 13) newboard()"/><input type="button" value="Go" onclick="newboard()"/>
</p>

<?php
	if ($_SERVER['REQUEST_URI'] != '/') {
?>
<p>Html code to embed this elsewhere:
<br/>
<input style="width:100%;" type="text" readonly="readonly" value="&lt;embed src=&quot;http://<?php

echo htmlentities($_SERVER['HTTP_HOST']);
?>/static/board.php?url=<?php
echo htmlentities($_SERVER['REQUEST_URI']);

?>&quot; style=&quot;width:960px; height:480px; &quot; type=&quot;image/svg+xml&quot;&gt;
"></p>

<p>Right-click link to "save as" png:
<br/>
<a href="http://<?php

echo htmlentities($_SERVER['HTTP_HOST']);
?>/static/export.php?url=<?php
echo htmlentities($_SERVER['REQUEST_URI']);

?>">save png</a></p>
<?php
	}
?>
		</div>
	</div>
	<div id="three-column">
		<div id="tbox1">
			<ul class="style1">
				<li>Copyright &copy; 2012-13 Eli Cohen.</li>
				<li>A <a href="http://neoturbine.net">Neoturbine</a> website.</li>
				<li>CSS by <a href="http://freecsstemplates.org/">FCT</a>.</li>
			</ul>
		</div>
		<div id="tbox2">
			<h2>What is this?</h2>
			<p>This site is for drawing stuff.  It uses AJAX and HTML5 to provide a multiplayer drawing stuff experience.</p>
		</div>
		<div id="tbox3">
			<h2>Remember...</h2>
			<p>People can draw over what you draw.  Stuff can also be erased by right-clicking strokes made recently, until the page is refreshed.</p>
		</div>
	</div>
<?php /* <iframe src="https://www.facebook.com/plugins/like.php?href=http://<?php

echo htmlentities($_SERVER['HTTP_HOST']);
echo htmlentities($_SERVER['REQUEST_URI']);

?>"
	scrolling="no" frameborder="0"
	style="border:none; width:300px; height:2em;"></iframe> */ ?>
<div id="footer">
<p>
<script type="text/javascript"><!--
google_ad_client = "ca-pub-4649162581902265";
/* mysite */
google_ad_slot = "2771843899";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</p>
	</div>
</div>
</body>
</html>
