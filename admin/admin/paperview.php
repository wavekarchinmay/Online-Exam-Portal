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
if(isset($_REQUEST["paper_name"]))
{
	$pname=$_REQUEST["paper_name"];
	if($_REQUEST["paper_name"]=="")
	{
		header("Location:papershow.php");
	}
}else{
		header("Location:papershow.php");
}

$val=mysqli_query($con,"select count(*) as ct from paper_name where paper_name='$pname'");
while($row_val=mysqli_fetch_assoc($val))
{
	$res=$row_val["ct"];
}
if($res==0)
{
		header("Location:papershow.php");
}
?>
<html>
	<head><meta name="viewport" content="width=device-width,initial-scale=1.0" >
		<link rel="stylesheet" type="text/css" href="../common.css">
		<link rel="stylesheet" type="text/css" href="admin.css">
	</head>
<body>
	<div class="title"><i>Online Exam Portal</i><a class="btn-logout"  href="logout.php">logout</a></div>
	<div class="div1">
	<p style="padding:5px;text-align:center;font-size:28px;"><?php echo strtoupper($pname); ?> (Preview)</p><hr>
<?php
	$i=1;
	$sql=mysqli_query($con,"select * from online_exam_papers.$pname");
		while($row=mysqli_fetch_assoc($sql))
		{
			echo $i.")"."&nbsp;&nbsp;&nbsp;".$row["question"]."<br>".
			"a."."&nbsp;&nbsp;&nbsp;".$row["option1"]."<br>".
			"b."."&nbsp;&nbsp;&nbsp;".$row["option2"]."<br>".
			"c."."&nbsp;&nbsp;&nbsp;".$row["option3"]."<br>".
			"d."."&nbsp;&nbsp;&nbsp;".$row["option4"]."<br>".
			"ans."."&nbsp;&nbsp;&nbsp;".$row["answer"]."<br><br>";
			$i++;
		}

?>
	</div>
</body>
</html>