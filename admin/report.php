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
		<link rel="stylesheet" type="text/css" href="report.css">
	</head>
<body>
	<div class="title"><i>Online Exam Portal</i><a class="btn-logout"  href="logout.php">logout</a></div>
	<div class="div1" style="overflow:scroll;">
	<table align="center" border=0 cellspacing="0" cellpadding="10">
	<tr>
		<th>Name</th>
		<th>Paper Name</th>
		<th>Total Questions</th>
		<th>Questions Attemped</th>
		<th>Wrong Answers</th>
		<th>Right Answer</th>
		<th>Exam Date and Time</th>
		<th>Action</th>
	</tr>
	<?php
	$i=1;
	$sql=mysqli_query($con,"select * from report");
		while($row=mysqli_fetch_assoc($sql))
		{
			echo"<tr><td>".$row["username"]."</td>".
			"<td>".$row["paper_name"]."</td>".
			"<td>".$row["total_ques"]."</td>".
			"<td>".$row["tot_attempt"]."</td>".
			"<td>".$row["wrong_ans"]."</td>".
			"<td>".$row["right_ans"]."</td>".
			"<td>".$row["date_time"]."</td>".
			"<td><a href=resetpaper.php?name=".$row["username"].'&paper='.$row["paper_name"].">Reset</a></td>"
			."</tr>";
			$i++;
		}

	?>
	</table>
	</div>

</body>
</html>