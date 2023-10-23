<?php
session_start();
if(isset($_SESSION["user"]))
{
	$_SESSION["user"];
}
?>
<html>
<head><meta name="viewport" content="width=device-width,initial-scale=1.0" >
	<link rel="stylesheet" type="text/css" href="../common.css">
	<link rel="stylesheet" type="text/css" href="../error.css">
</head>
	<body>
	<div class="title"><i>Online Exam Portal</i></div>
		<div class="div1">
			<p class="p1">Error</p>
			<form method="post" action="exam_prepare.php">
				<p class="res">Something Wents to Wrong!</p>
			</form>
		</div>
	</body>
</html>