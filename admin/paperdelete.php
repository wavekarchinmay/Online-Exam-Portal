<?php
session_start();
if(isset($_SESSION["admin"]))
{
}
else{
	header("Location:index.php");
}
//connect to db
include("connection.php");
mysqli_select_db($con,"online_exam_papers");

?>
<html>
	<head><meta name="viewport" content="width=device-width,initial-scale=1.0" >
		<link rel="stylesheet" type="text/css" href="../common.css">
		<link rel="stylesheet" type="text/css" href="papershow.css">
	</head>
<body>
	<div class="title"><i>Online Exam Portal</i><a class="btn-logout"  href="logout.php">logout</a></div>
	<div class="div2">
	<b>Paper Name</b><hr>
		<?php
		$sql=mysqli_query($con,"select * from paper_name");
		while($row=mysqli_fetch_assoc($sql))
		{
			echo $row["paper_name"]."<br>";
		}
		
		?>
	</div>
	<div class="div1">
		<b>Enter Paper Name</b><hr>
		<form method="get" action="paperdel.php">
			<input type="text" class="inp" name="paper_name">
			<input type="submit" class="btn" value="proceed">
		</form>
	</div>
</body>
</html>