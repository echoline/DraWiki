<?php
if (!isset($_GET['url']))
	$url='';
else
	$url=strtolower($_GET['url']);
?>
<html>
<head>
</head>
<body style="background-color:black;padding:0px;margin:0px;">
<embed src="/static/board.php?url=<?php
	echo htmlentities(urlencode($url));
?>" style="width:960px;height:480px;padding:0px;margin:0px;"></embed>
</body>
</html>
