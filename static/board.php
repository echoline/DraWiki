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
<rect x="0" y="0" width="990px" height="480px" fill="white" stroke="white"/>
<image x="30" y="0" width="960px" height="480px" xlink:href="/static/export.php?url=<?php

	echo strtolower(htmlentities(urlencode($_GET['url'])));

?>"></image>
<script>
var url = <?php
	echo json_encode(htmlentities(urlencode($_GET['url'])));
?>;
</script>
<script xlink:href="/static/board.js"></script>
<g transform="translate(30,0)">
<g id="saved"></g>
<g id="unsaved"/>
</g>
<rect x="0" y="0" width="30" height="480" fill="black" stroke="black"/>
<rect x="0" y="0" width="30" height="30" fill="black" stroke="red" onclick="color(this)" class="color"/>
<rect x="0" y="30" width="30" height="30" fill="brown" stroke="black" onclick="color(this)" class="color"/>
<rect x="0" y="60" width="30" height="30" fill="red" stroke="black" onclick="color(this)" class="color"/>
<rect x="0" y="90" width="30" height="30" fill="orange" stroke="black" onclick="color(this)" class="color"/>
<rect x="0" y="120" width="30" height="30" fill="yellow" stroke="black" onclick="color(this)" class="color"/>
<rect x="0" y="150" width="30" height="30" fill="green" stroke="black" onclick="color(this)" class="color"/>
<rect x="0" y="180" width="30" height="30" fill="blue" stroke="black" onclick="color(this)" class="color"/>
<rect x="0" y="210" width="30" height="30" fill="purple" stroke="black" onclick="color(this)" class="color"/>
<rect x="0" y="240" width="30" height="30" fill="pink" stroke="black" onclick="color(this)" class="color"/>
<rect x="0" y="270" width="30" height="30" fill="gray" stroke="black" onclick="color(this)" class="color"/>
<rect x="0" y="300" width="30" height="30" fill="white" stroke="black" onclick="color(this)" class="color"/>
<rect x="0" y="340" width="30" height="30" fill="white" stroke="red" onclick="brush(4)" id="brush4"/>
<circle cx="15" cy="355" r="2" fill="black" stroke="black" onclick="brush(4)"/>
<rect x="0" y="370" width="30" height="30" fill="white" stroke="black" onclick="brush(8)" id="brush8"/>
<circle cx="15" cy="385" r="4" fill="black" stroke="black" onclick="brush(8)"/>
<rect x="0" y="400" width="30" height="30" fill="white" stroke="black" onclick="brush(12)" id="brush12"/>
<circle cx="15" cy="415" r="6" fill="black" stroke="black" onclick="brush(12)"/>
<rect x="0" y="430" width="30" height="30" fill="white" stroke="black" onclick="brush(16)" id="brush16"/>
<circle cx="15" cy="445" r="8" fill="black" stroke="black" onclick="brush(16)"/>
</svg>
