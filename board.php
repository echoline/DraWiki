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
	<meta name="description" content="Multiplayer drawing site" />
	<meta property="og:url"           content="https://<?php

	print $_SERVER['HTTP_HOST'];
	print '/';
	$url = urlencode(substr(preg_replace("/\?.*$/", "", $_SERVER['REQUEST_URI']),1));
	print $url;

?>" />
	<meta property="og:type"          content="website" />
	<meta property="og:title"         content="Multiplayer Paint" />
	<meta property="og:description"   content="Multiplayer drawing site" />
	<meta property="og:image"         content="https://<?php

	print $_SERVER['HTTP_HOST'];
	print '/static/export.php?url=';
	print $url;

?>" />
<?php
$useragent=$_SERVER['HTTP_USER_AGENT'];

if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {
?>
<script>
<!--
	document.addEventListener("scroll", function(event) { window.scrollTo(0,0); event.preventDefault(); event.stopPropagation(); }, false);
// -->
</script>
</head>
<body>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v5.0"></script>
<?php
	if ($url != '') { 
?>
		<embed id="board" src="/static/board.php?url=<?php

	print $url;

		?>" type="image/svg+xml" style="width:960px; height:480px; border:2px solid black;">
<?php
	}
?>
<div style="float:left;"><p><input type="text" style="height:4em;" placeholder="<?php

	if (htmlentities($url) == '')
		echo "Name your canvas here";
	else
		echo htmlentities(urldecode($url));

?>" id="boardname" onkeydown="if (event.keyCode == 13) newboard()"/><input type="button" value="Go" onclick="newboard()"/></p>
			<ul class="style1">
<li><div><a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false">Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script></div><br/></li>
<li><div><a data-pin-do="buttonBookmark" href="https://www.pinterest.com/pin/create/button/"></a></div><br/></li>
<li><div class="fb-like" data-href="https://<?php
echo htmlentities($_SERVER['HTTP_HOST']);
echo htmlentities($_SERVER['REQUEST_URI']);
?>" data-width="" data-layout="standard" data-action="like" data-size="small" data-share="true"></div><br/></li>
			</ul></div>
<script async defer src="//assets.pinterest.com/js/pinit.js"></script>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick" />
<input type="hidden" name="hosted_button_id" value="CJXPLN8M9V39U" />
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
</form>
</body>
</html>
<?php
	exit(0);
}
?>
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
		echo htmlentities(urldecode($url));

			?></h1>
		</div>
	</div>
	<div id="page">
		<div id="content">
<?php
	if ($url != '') { 
?>
		<embed id="board" src="/static/board.php?url=<?php

	print $url;

		?>" type="image/svg+xml" style="width:960px; height:480px; border:2px solid black;">
<?php
	}
?>
<p>
<input type="text" style="width:33%" placeholder="<?php

	if ($url == '')
		echo "Name your canvas here";
	else
		echo htmlentities(urldecode($url));

?>" id="boardname" onkeydown="if (event.keyCode == 13) newboard()"/><input type="button" value="Go" onclick="newboard()"/>
<?php
	if ($url != '') {
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
echo '/' . $url;
?>" data-width="" data-layout="standard" data-action="like" data-size="small" data-share="true"></div><br/></li>
			</ul>
		</div>
		<div id="tbox2">
			<h2>What is this?</h2>
			<p>It's a multiplayer website of wiki-style paint. Choose a whiteboard name to begin, and invite your friends.</p>
			<p>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick" />
<input type="hidden" name="hosted_button_id" value="CJXPLN8M9V39U" />
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
</form>
			</p>
		</div>
		<div id="tbox3">
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 300x250, created 8/24/10 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:300px;height:250px"
     data-ad-client="ca-pub-4649162581902265"
     data-ad-slot="5586908359"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
		</div>
	</div>
<div id="footer">
<p>
</p>
			<p>Site by echoline. Github: <a href="https://github.com/echoline/DraWiki">github.com/echoline/DraWiki</a>. CSS by <a href="http://freecsstemplates.org/">freecsstemplates.org</a>.
</p>
	</div>
</div>
<script async defer src="//assets.pinterest.com/js/pinit.js"></script>
</body>
</html>
