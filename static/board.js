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

var xmlns = "http://www.w3.org/2000/svg"
var clicked = false;
var res;
var col = "black";
var last = Math.round((new Date()).getTime() / 1000.0);
var size = "4";

function connect() {
	var conn = new XMLHttpRequest();
	conn.open("POST", "/static/out.php", true);
	conn.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	conn.onreadystatechange = function() {
		if ((conn.readyState == 4) && (conn.status == 200)) {
			if (conn.responseText.length != 0) {
				var lines = conn.responseText.split("\n");
				var now = parseInt (lines[0]);

				//alert (conn.responseText);

				if (now > last)
				{
					if (last == 0) {
		// TODO
					}
					last = now;
				}
				for (var i = 1; i < lines.length; i++) {
					var str = lines[i];
					if (str != undefined && str != '') {
						var p = JSON.parse(str);
						var id = p[1];
						var e = document.getElementById(id);
						if ((p[3] != "1") && (e == undefined)) {
							var n = document.createElementNS(xmlns, "path");
							n.setAttributeNS(null, "id", p[1]);
							n.setAttributeNS(null, "stroke", p[2]);
							n.setAttributeNS(null, "fill", "none");
							n.setAttributeNS(null, "stroke-width", p[4]);
							n.setAttributeNS(null, "d", p[0]);
							//n.oncontextmenu=erase;
							document.getElementById("saved").appendChild(n);
						} else if ((p[3] == "1") && (e != null)) {
							document.getElementById("saved").removeChild(e);
						}
					}
				}
			}
			setTimeout('connect()', 1000);
		}
	};
	conn.send("last=" + last + "&url=" + window.here);
}

function startmove(X, Y) {
	res = Math.floor (Math.random() * 1000001);
	var p = document.getElementById(res);
	if (p == null) {
		p = document.createElementNS(xmlns, "path");
		p.setAttributeNS(null, "id", res);
		p.setAttributeNS(null, "stroke", col);
		p.setAttributeNS(null, "fill", "none");
		p.setAttributeNS(null, "stroke-width", size);
		p.setAttributeNS(null, "d", "M " + X + " " + Y);
		//p.oncontextmenu=erase;
		document.getElementById("unsaved").appendChild(p);
	} else {
		var d = p.getAttributeNS(null, "d");
		d = d.replace(/$/, " L " + X + " " + Y);
		p.setAttributeNS(null, "d", d);
	}
	clicked = true;
}

function endmove() {
	clicked = false;

	save ();
}

window.lastx = 0;
window.lasty = 0;
window.here = url;

function move(X, Y) {
	if (clicked == false)
		return;

	var dx = X - window.lastx;
	var dy = Y - window.lasty;
	var dist = Math.sqrt(dx*dx + dy*dy);
	if (dist > 2) {
		window.lastx = X;
		window.lasty = Y;
		var p = document.getElementById(res);
		var d = p.getAttributeNS(null, "d");
		d = d.replace(/$/, " L " + X + " " + Y);
		p.setAttributeNS(null, "d", d);
	}
}

function mousedown(evt) {
	startmove(evt.pageX, evt.pageY);
}

function mousemove(evt) {
	move(evt.pageX, evt.pageY);
}

function mouseup(evt) {
	endmove();
}

function getCoors(e) {
	if (e.touches && e.touches.length) { 	// iPhone
		return e.touches[0];
	}
	return e;
}

function touchstart(evt) {
	evt.preventDefault();
	evt.stopPropagation();
	e = getCoors(evt);
	startmove(e.clientX, e.clientY);
	return false;
}

function touchmove(evt) {
	evt.preventDefault();
	evt.stopPropagation();
	e = getCoors(evt);
	move(e.clientX, e.clientY);
	return false;
}

function touchend(evt) {
	endmove();
	return false;
}

function setup(evt) {
	connect();

	document.addEventListener("touchstart", touchstart, false);
	document.addEventListener("touchmove", touchmove, false);
	document.addEventListener("touchend", touchend, false);
	document.addEventListener("mousedown", mousedown, false);
	document.addEventListener("mousemove", mousemove, false);
	document.addEventListener("mouseup", mouseup, false);
}

function save() {
	var paths = document.getElementById("unsaved").getElementsByTagName("path");
	if (paths.length == 0)
		return;

	var path;
	var out = "url=" + window.here + "&json={\"paths\":[";
	for (var i = 0; i < (paths.length-1); i++) {
		path = paths[i];
		out += JSON.stringify([path.getAttributeNS(null, "id"),
					path.getAttributeNS(null, "d"),
					path.getAttributeNS(null, "stroke"),
					path.getAttributeNS(null, "stroke-width")]) + ",";
		document.getElementById("saved").appendChild (path);
	}
	path = paths[paths.length-1];
	out += JSON.stringify([path.getAttributeNS(null, "id"),
				path.getAttributeNS(null, "d"),
				path.getAttributeNS(null, "stroke"),
				path.getAttributeNS(null, "stroke-width")]) + "]}";
	document.getElementById("saved").appendChild (path);

	var xhr = new XMLHttpRequest();
	xhr.open("POST", "/static/save.php");
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.onreadystatechange = function() {
		if ((xhr.readyState == 4) && (xhr.status == 200)) {
			if(xhr.responseText != '1') {
				//alert(xhr.responseText);
				var evt = {};
				evt.target = path;
				erase(evt);
			}
		}
	}; 
	xhr.send(out);
}

function color(n) {
	col = n.getAttributeNS(null, "fill");
}

function brush(n) {
	size = n;
}

function erase(evt) {
	var path = evt.target;

	var out = "url=" + window.here + "&json={\"paths\":[";
	out += JSON.stringify([path.getAttributeNS(null, "id")]) + "]}";

	var xhr = new XMLHttpRequest();
	xhr.open("POST", "/static/erase.php");
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.onreadystatechange = function() {
		if ((xhr.readyState == 4) && (xhr.status == 200)) {
			if (xhr.responseText == '1')
				document.getElementById("saved").removeChild (path);
			else if (xhr.responseText != '0')
				alert (xhr.responseText);
		}
	}; 
	xhr.send(out);

	return false;
}
