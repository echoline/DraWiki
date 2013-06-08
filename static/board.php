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

	if (!isset($_GET['url']))
		die ("Error.");

	header('Content-type: image/svg+xml');
?>
<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" onload="setup(evt);" width="100%" height="100%" bgcolor="white">
<rect x="0" y="0" width="959px" height="480px" fill="white" stroke="white"/>
<image x="0" y="0" width="960px" height="480px" xlink:href="/static/export.php?url<?php

	echo preg_replace("%^.*url%", "",
			htmlentities($_SERVER['REQUEST_URI']));

?>"></image>
<script>
var url = <?php
	echo json_encode($_GET['url']);
?>;
</script>
<script xlink:href="/static/board.js"></script>
<g id="saved"></g>
<g id="unsaved"/>
<rect x="10" y="10" width="16" height="10" fill="black" stroke="black" onclick="color(this)"/>
<rect x="10" y="30" width="16" height="10" fill="brown" stroke="black" onclick="color(this)"/>
<rect x="10" y="50" width="16" height="10" fill="red" stroke="black" onclick="color(this)"/>
<rect x="10" y="70" width="16" height="10" fill="orange" stroke="black" onclick="color(this)"/>
<rect x="10" y="90" width="16" height="10" fill="yellow" stroke="black" onclick="color(this)"/>
<rect x="10" y="110" width="16" height="10" fill="green" stroke="black" onclick="color(this)"/>
<rect x="10" y="130" width="16" height="10" fill="blue" stroke="black" onclick="color(this)"/>
<rect x="10" y="150" width="16" height="10" fill="purple" stroke="black" onclick="color(this)"/>
<rect x="10" y="170" width="16" height="10" fill="gray" stroke="black" onclick="color(this)"/>
<rect x="10" y="190" width="16" height="10" fill="white" stroke="black" onclick="color(this)"/>
<rect x="10" y="220" width="16" height="10" fill="white" stroke="black" onclick="brush(4)"/>
<circle cx="18" cy="225" r="2" fill="black" stroke="black" onclick="brush(4)"/>
<rect x="10" y="240" width="16" height="10" fill="white" stroke="black" onclick="brush(8)"/>
<circle cx="18" cy="245" r="4" fill="black" stroke="black" onclick="brush(8)"/>
<rect x="10" y="260" width="16" height="10" fill="white" stroke="black" onclick="brush(12)"/>
<circle cx="18" cy="265" r="6" fill="black" stroke="black" onclick="brush(12)"/>
<rect x="10" y="280" width="16" height="10" fill="white" stroke="black" onclick="brush(16)"/>
<circle cx="18" cy="285" r="8" fill="black" stroke="black" onclick="brush(16)"/>
</svg>
