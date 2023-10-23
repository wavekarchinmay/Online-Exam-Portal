<?php
session_start();
if(isset($_SESSION["admin"]))
{
}
else{
	header("Location:index.php");
}
//connect to db
$con=mysqli_connect("localhost","root","");
mysqli_select_db($con,"online_users");

?>
<html>
	<head><meta name="viewport" content="width=device-width,initial-scale=1.0" >
		<link rel="stylesheet" type="text/css" href="../common.css">
		<link rel="stylesheet" type="text/css" href="adminporter.css">
	</head>
<body>
	<div class="title"><i>Online Exam Portal</i><a class="btn-logout"  href="logout.php">logout</a></div>
	<div class="div1">
		<b>Manage Papers</b> <button class="btn"  onclick="addpaper()">Manage Papers</button>
	</div>
	<div class="div1">
		<b>Show paper</b> <button class="btn" onclick="showpaper()">Show Papers</button>
	</div>
	<div class="div1">
		<b>Delete paper</b> <button class="btn" onclick="Deletepaper()">Delete Papers</button>
	</div>
	<div class="div1">
		<b>View Report</b> <button class="btn" onclick="showresult()">Show Marks Report</button>
	</div>
	<script lang="js">
		function addpaper()
		{
			window.open("paperupload.php","_self");
		}
		function showpaper()
		{
			window.open("papershow.php","_self");
		}
		function Deletepaper()
		{
			window.open("paperdelete.php","_self");
		}
		function showresult()
		{
			window.open("report.php","_self");
		}
	</script>
</body>
</html>