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
<rect x="0" y="0" width="960px" height="480px" fill="white" stroke="white"/>
<image x="0" y="0" width="960px" height="480px" xlink:href="/static/export.php?url=<?php

	echo htmlentities($_GET['url']);

?>"></image>
<script>
var url = <?php
	echo json_encode(htmlentities($_GET['url']));
?>;
</script>
<script xlink:href="/static/board.js"></script>
<g id="saved"></g>
<g id="unsaved"/>
<rect x="0" y="10" width="30" height="30" fill="black" stroke="red" onclick="color(this)" class="color"/>
<rect x="0" y="40" width="30" height="30" fill="brown" stroke="black" onclick="color(this)" class="color"/>
<rect x="0" y="70" width="30" height="30" fill="red" stroke="black" onclick="color(this)" class="color"/>
<rect x="0" y="100" width="30" height="30" fill="orange" stroke="black" onclick="color(this)" class="color"/>
<rect x="0" y="130" width="30" height="30" fill="yellow" stroke="black" onclick="color(this)" class="color"/>
<rect x="0" y="160" width="30" height="30" fill="green" stroke="black" onclick="color(this)" class="color"/>
<rect x="0" y="190" width="30" height="30" fill="blue" stroke="black" onclick="color(this)" class="color"/>
<rect x="0" y="220" width="30" height="30" fill="purple" stroke="black" onclick="color(this)" class="color"/>
<rect x="0" y="250" width="30" height="30" fill="pink" stroke="black" onclick="color(this)" class="color"/>
<rect x="0" y="280" width="30" height="30" fill="gray" stroke="black" onclick="color(this)" class="color"/>
<rect x="0" y="310" width="30" height="30" fill="white" stroke="black" onclick="color(this)" class="color"/>
<rect x="0" y="350" width="30" height="30" fill="white" stroke="red" onclick="brush(4)" id="brush4"/>
<circle cx="15" cy="365" r="2" fill="black" stroke="black" onclick="brush(4)"/>
<rect x="0" y="380" width="30" height="30" fill="white" stroke="black" onclick="brush(8)" id="brush8"/>
<circle cx="15" cy="395" r="4" fill="black" stroke="black" onclick="brush(8)"/>
<rect x="0" y="410" width="30" height="30" fill="white" stroke="black" onclick="brush(12)" id="brush12"/>
<circle cx="15" cy="425" r="6" fill="black" stroke="black" onclick="brush(12)"/>
<rect x="0" y="440" width="30" height="30" fill="white" stroke="black" onclick="brush(16)" id="brush16"/>
<circle cx="15" cy="455" r="8" fill="black" stroke="black" onclick="brush(16)"/>
</svg>
