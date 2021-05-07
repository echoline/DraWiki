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
	if (!isset($_GET['url']) || $_GET['url'] == '')
		die('no');
	$url = strtolower(htmlentities(urlencode($_GET['url'])));
	$url2 = strtolower(htmlentities(urldecode($_GET['url'])));
	$hash = substr(base_convert(md5($url), 16, 10), 0, 8);

	require '../login.php';

	$my_mysql = mysqli_connect($my_host, $my_user, $my_pass, $my_db, $my_port, $my_socket);
	if ($my_mysql == NULL)
		die ('mysqli_connect');

	$url = mysqli_real_escape_string($my_mysql, urlencode(strtolower($_GET['url'])));
	$hash = substr(base_convert(md5($url), 16, 10), 0, 8);

	while(file_exists("/DraWiki/static/tmp/" . $hash . ".lock")) usleep(1000000);
	touch ("/DraWiki/static/tmp/" . $hash . ".lock");

	$results = mysqli_query($my_mysql, 'select * from paths where hash=\'' . $hash . '\' order by time');

	function callback($buffer) {
		global $hash;

		file_put_contents('/DraWiki/static/tmp/' . $hash . '.svg', $buffer);
		system ('/usr/local/bin/rsvg-convert -o /DraWiki/static/tmp/' . $hash . '.png /DraWiki/static/tmp/' . $hash . '.svg');
#		system ('/usr/local/bin/convert /DraWiki/static/tmp/' . $hash . '.svg /DraWiki/static/tmp/' . $hash . '.png');

	}

	ob_start("callback");
?><!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="960" height="480">
<rect x="0" y="0" width="960" height="480" fill="white" stroke="white"/>
<?php
	if (file_exists('/DraWiki/static/tmp/' . $hash . '.2.png')) {
?><image x="0" y="0" width="960px" height="480px" xlink:href="file:///DraWiki/static/tmp/<?php

	print $hash;
	
?>.2.png"></image>
<?php
	}

	if ($results != NULL) {
		while ($row = mysqli_fetch_row($results)) {
			if (!preg_match('/^M [0-9]+ [0-9]+/', $row[2]))
				continue;
			if (preg_match('/[^ML\-0-9\ ]/', $row[2]))
				continue;
			if (preg_match('/L[^ ]/', $row[2]))
				continue;
			if (preg_match('/[^ ]L/', $row[2]))
				continue;
			if (preg_match('/[^ \-0-9]0-9/', $row[2]))
				continue;
			if (!preg_match('/^[0-9]+$/', $row[7]))
				continue;
			if ($row[7] < 4 || $row[7] > 16)
				continue;
			if (!preg_match('/^(black|brown|red|orange|yellow|green|blue|purple|pink|gray|white)$/', $row[3]))
				continue;

			print '<path d="' . $row[2] . '" stroke="' . $row[3] . '" stroke-width="' . $row[7] . '" fill="none"/>' . "\n";
			$results2 = mysqli_query($my_mysql, 'delete from paths where hash=\'' . $hash . '\' and id=\'' . $row[1] . '\'');
			if ($results2 == NULL)
				die (mysqli_error ($my_mysql));
		}
	}
?>
</svg><?php
	ob_end_flush();
	copy ('/DraWiki/static/tmp/' . $hash . '.png', '/DraWiki/static/tmp/' . $hash . '.2.png');
	unlink("/DraWiki/static/tmp/" . $hash . '.lock');
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<title>Multiplayer Drawing Wiki</title>
	<link href="/static/default.css" type="text/css" rel="stylesheet"/>
	<script src="/static/page.js"></script>
	<meta name="description" content="Multiplayer drawing site" />
	<meta property="og:url"           content="https://<?php

	print $_SERVER['HTTP_HOST'];
	print '/';
	print $url;

?>" />
	<meta property="og:type"          content="website" />
	<meta property="og:title"         content="Multiplayer drawing site" />
	<meta property="og:description"   content="A multiplayer website of wiki-style paint. Choose a whiteboard name to begin, and invite your friends." />
	<meta property="og:image"         content="https://<?php

	print $_SERVER['HTTP_HOST'];
	print '/static/export.php?ts=' . time() . '&url=';
	print $url;

?>" />
	<script data-ad-client="ca-pub-4649162581902265" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
</head>
<body>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v5.0"></script>
<div id="wrapper">
	<div id="header">
		<div id="logo">
			<h1><?php

	if ($url == '')
		echo htmlentities($_SERVER['HTTP_HOST']);
	else
		echo $url2;

			?></h1>
		</div>
<?php
	if ($url != '') {
		$useragent=$_SERVER['HTTP_USER_AGENT'];
		if(preg_match('/android.+mobile/i', $useragent)) {
?>
<div id="logo" style="float:right;"><h1><a href="intent://<?php
	print $_SERVER['HTTP_HOST'] . '/' . $url;
?>#Intent;scheme=https;package=org.echoline.drawiki;end;">Open in App</a></h1></div>
<?php
		}
	}
?>
	</div>
	<div id="page">
		<div id="content">
<?php
	if ($url != '') { 
		$dir = '/DraWiki/static/tmp/' . $hash;
		mkdir($dir, 0755);
		$file = $dir . '/' . time() . '.png';
		$filehash = md5_file($dir . '.png');
		$files = glob($dir . '/*');
		$flag = false;
		foreach ($files as $orig) {
			$orighash = md5_file($orig);
			if ($orighash == $filehash) {
				$flag = true;
				break;
			}
		}
		if ($flag == false)
			copy($dir . '.png', $dir . '/' . time() . '.png');
		$files = array_reverse(glob($dir . '/*'));
		foreach ($files as $orig) {
			$ts = preg_replace("/^.*\/([0-9]+).png$/", "$1", $orig);
			$name = preg_replace("/^\/DraWiki/","",$orig);
?>
<h2 id="<?php echo $ts ?>">
<script>
	document.getElementById('<?php echo $ts ?>').innerHTML = new Date(<?php echo $ts ?> * 1000);
</script>
</h2>
<p>
<img src="<?php echo $name ?>" />
</p><p>
<a href="<?php echo $name ?>" download="<?php echo $url2 ?>.png">Download file</a>
<a href="/static/load.php?url=<?php echo $url ?>&ts=<?php echo $ts ?>">Reset to this version</a>
</p>
<?php
		}
	}
?>
<p>
<input type="text" style="width:33%" placeholder="<?php

	if ($url == '')
		echo "Name your canvas here";
	else {
		echo $url2;
	}

?>" id="boardname" onkeydown="if (event.keyCode == 13) newboard()"/><input type="button" value="Go" onclick="newboard()"/>
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
echo '/' . $url;
?>" data-width="" data-layout="standard" data-action="like" data-size="small" data-share="true"></div><br/></li>
			</ul>
		</div>
		<div id="tbox2">
			<h2>What is this?</h2>
			<p>It's a multiplayer website of wiki-style paint. Choose a whiteboard name to begin, and invite your friends.</p>
			<p>Questions? Comments? Email me at my nickname at gmail.</p>
		</div>
		<div id="tbox3">
<?php
//include '/DraWiki/static/adwidget.php';
?>
		</div>
	</div>
<div id="footer">
<p>
</p>
	<p>Site by <a href="https://echoline.org">echoline</a>. Drawings reflect the visitors' opinions, not mine. CSS by <a href="http://freecsstemplates.org/">freecsstemplates.org</a>.</p>
</div>
</div>
<script async defer src="//assets.pinterest.com/js/pinit.js"></script>
</body>
</html>
