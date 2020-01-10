<!DOCTYPE html>
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
*/ ?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<title>Multiplayer Paint</title>
	<link href="/static/default.css" type="text/css" rel="stylesheet"/>
	<script src="/static/page.js"></script>
	<script data-ad-client="ca-pub-4649162581902265" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<meta property="og:url"           content="https://<?php

	print $_SERVER['HTTP_HOST'];
	print $_SERVER['REQUEST_URI'];

?>" />
	<meta property="og:type"          content="website" />
	<meta property="og:title"         content="Multiplayer Paint" />
	<meta property="og:description"   content="Multiplayer drawing site" />
	<meta property="og:image"         content="https://<?php

	print $_SERVER['HTTP_HOST'];
	print '/static/export.php?url=';
	print $_SERVER['REQUEST_URI'];

?>" />
</head>
<body>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v5.0"></script>
<div id="wrapper">
	<div id="header">
		<div id="logo">
			<h1><?php

	if ($_SERVER['REQUEST_URI'] == '/')
		echo htmlentities($_SERVER['HTTP_HOST']);
	else
		echo substr(htmlentities(urldecode($_SERVER['REQUEST_URI'])), 1);

			?></h1>
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
<?php
	if ($_SERVER['REQUEST_URI'] != '/') {
?>
<a href="javascript:exportpng()">Export</a></p>
<br/>
<div id="export"></div>
<?php
	}
?>
		</div>
	</div>
	<div id="three-column">
		<div id="tbox1">
			<h2>Social Media</h2>
			<ul class="style1">
<li><div><a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false">Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script></div><br/></li>
<li><div><a data-pin-do="buttonBookmark" href="https://www.pinterest.com/pin/create/button/"></a></div><br/></li>
<li><div class="fb-like" data-href="https://<?php
echo htmlentities($_SERVER['HTTP_HOST']);
echo htmlentities($_SERVER['REQUEST_URI']);
?>" data-width="" data-layout="standard" data-action="like" data-size="small" data-share="true"></div><br/></li>
			</ul>
		</div>
		<div id="tbox2">
			<h2>What is this?</h2>
			<p>It's a multiplayer website of wiki-style paint. Choose a whiteboard name to begin, and invite your friends.</p>
		</div>
		<div id="tbox3">
		</div>
	</div>
<div id="footer">
<p>
</p>
			<p>Copyright &copy; 2011-2020 Eli Cohen. Github URL: <a href="https://github.com/echoline/DraWiki">github.com/echoline/DraWiki</a>. CSS by <a href="http://freecsstemplates.org/">freecsstemplates.org</a>.
</p>
	</div>
</div>
<script async defer src="//assets.pinterest.com/js/pinit.js"></script>
</body>
</html>
