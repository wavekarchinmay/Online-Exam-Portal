<?php
session_start();
if(isset($_SESSION["user"]))
{
}
else{
		header("Location:index.php");
}
?>
<html>
<head><meta name="viewport" content="width=device-width,initial-scale=1.0" >
	<link rel="stylesheet" type="text/css" href="selectpaper.css">
	<link rel="stylesheet" type="text/css" href="common.css">
	<title>Examination</title>
</head>
	<body>
	<div class="title"><i>Online Exam Portal</i></div>
		<div class="div1">
			<p class="p1">Select Paper</p>
			<form method="post" action="exam_prepare.php">
				<input class="inp" type="text" name="paper_code" ><br>
				<input class="btn" type="submit" value="Start">
			</form>
		</div>
	</body>
</html>