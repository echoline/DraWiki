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
var json = "";
var col = "black";

function connect() {
	var conn = new XMLHttpRequest();
	conn.open("POST", "/static/out.php", true);
	conn.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	conn.onreadystatechange = function() {
		if ((conn.readyState == 4) && (conn.status == 200)) {
			if (conn.responseText.length != 0) {
				var lines = conn.responseText.split("\n");
				for (var i = 0; i < lines.length; i++) {
					var str = lines[i].split("|")[1];
					if (str != undefined) {
						var p = JSON.parse(str);
						if (document.getElementById(p.attributes.id) == undefined) {
							var n = document.createElementNS(xmlns, "path");
							n.setAttributeNS(null, "id", p.attributes.id);
							n.setAttributeNS(null, "stroke", p.attributes.stroke);
							n.setAttributeNS(null, "fill", "none");
							n.setAttributeNS(null, "stroke-width", "4");
							n.setAttributeNS(null, "d", p.attributes.d);
							document.getElementById("unsaved").appendChild(n);
						}
					}
				}
			}
			connect();
		}
	};
	if (json != "") {
		conn.setRequestHeader("Content-length", window.location.href.length + 10 + json.length);
		conn.send("url=" + window.location.href + "&json=" + json);
	} else {
		conn.setRequestHeader("Content-length", window.location.href.length + 4);
		conn.send("url=" + window.location.href);
	}
	json = "";
}

function setup(evt) {
	connect();

	document.onmousedown = function(evt) {
		res = new Date().getTime();
		var p = document.getElementById(res);
		if (p == null) {
			p = document.createElementNS(xmlns, "path");
			p.setAttributeNS(null, "id", res);
			p.setAttributeNS(null, "stroke", col);
			p.setAttributeNS(null, "fill", "none");
			p.setAttributeNS(null, "stroke-width", "4");
			p.setAttributeNS(null, "d", "M " + evt.pageX + " " + evt.pageY);
			document.getElementById("unsaved").appendChild(p);
		} else {
			var d = p.getAttributeNS(null, "d");
			d = d.replace(/$/, " L " + evt.pageX + " " + evt.pageY);
			p.setAttributeNS(null, "d", d);
		}
		clicked = true;
	}

	document.onmouseup = function(evt) {
		clicked = false;

		var p = document.getElementById(res);
		json = JSON.stringify(xmlToJson(p));
	}

	document.onmousemove = function(evt) {
		if (clicked == false)
			return;

		var p = document.getElementById(res);
		var d = p.getAttributeNS(null, "d");
		d = d.replace(/$/, " L " + evt.pageX + " " + evt.pageY);
		p.setAttributeNS(null, "d", d);
	}
}

function save() {
	var paths = document.getElementById("unsaved").getElementsByTagName("path");
	var out = "url=" + window.location.href + "&json={\"paths\": [";
	for (var i = 0; i < (paths.length-1); i++) {
		out += JSON.stringify(xmlToJson(paths[i])) + ",";
	}
	out += JSON.stringify(xmlToJson(paths[paths.length-1])) + "]}";
	var xhr = new XMLHttpRequest();
	document.getElementById("save").childNodes[0].nodeValue = "Saving...";
	xhr.open("POST", "/static/save.php");
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.setRequestHeader("Content-length", out.length);
	xhr.onreadystatechange = function() {
		if ((xhr.readyState == 4) && (xhr.status == 200)) {
			document.getElementById("save").childNodes[0].nodeValue = "Save";
			alert(xhr.responseText);
		}
	};
	xhr.send(out);
}

function color(n) {
	col = n.getAttributeNS(null, "fill");
}

// Changes XML to JSON
function xmlToJson(xml) {
  
  // Create the return object
  var obj = {};

  if (xml.nodeType == 1) { // element
    // do attributes
    if (xml.attributes.length > 0) {
    obj["attributes"] = {};
      for (var j = 0; j < xml.attributes.length; j++) {
        var attribute = xml.attributes.item(j);
        obj["attributes"][attribute.nodeName] = attribute.nodeValue;
      }
    }
  } else if (xml.nodeType == 3) { // text
    obj = xml.nodeValue;
  }

  // do children
  if (xml.hasChildNodes) {
    for(var i = 0; i < xml.childNodes.length; i++) {
      var item = xml.childNodes.item(i);
      var nodeName = item.nodeName;
      if (typeof(obj[nodeName]) == "undefined") {
        obj[nodeName] = xmlToJson(item);
      } else {
        if (typeof(obj[nodeName].length) == "undefined") {
          var old = obj[nodeName];
          obj[nodeName] = [];
          obj[nodeName].push(old);
        }
        obj[nodeName].push(xmlToJson(item));
      }
    }
  }
  return obj;
};

