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
if(isset($_SESSION["paper_name"]))
{
	$pname=$_SESSION["paper_name"];
	if($_SESSION["paper_name"]=="")
	{
		header("Location:paperupload.php");
	}
}else{
		header("Location:paperupload.php");
}
//confirm table exist or not
$val=mysqli_query($con,"select count(*) as ct from paper_name where paper_name='$pname'");
while($row_val=mysqli_fetch_assoc($val))
{
	$res=$row_val["ct"];
}
if($res==0)
{
		header("Location:paperupload.php");
}
?>

<html>
	<head><meta name="viewport" content="width=device-width,initial-scale=1.0" >
		<link rel="stylesheet" type="text/css" href="../common.css">
		<link rel="stylesheet" type="text/css" href="paperedit.css">
	</head>
<body>
	<div class="title"><i>Online Exam Portal</i></div>
	<div class="div1">
	<p style="padding:5px;text-align:center;font-size:28px;"><?php echo strtoupper($pname); ?> (Editing)</p><hr>
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
		<form method="post" action="papersave.php">
			Q:&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class="que" name="q"><br>
			a:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="opt" type="text" name="opt1"><br>
			b:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="opt" type="text" name="opt2"><br>
			c:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="opt" type="text" name="opt3"><br>
			d:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="opt" type="text" name="opt4"><br>
			Ans:<input type="text" class="opt" name="ans"><br><br>
			<input type="submit" class="btn" name="sub" value="save">
		</form>
			<form method="post" action="finish_edit.php">
				<input type="submit" class="btn2" name="finish" value="Finish Editing">
		</form>
		
	</div>
</body>
</html>