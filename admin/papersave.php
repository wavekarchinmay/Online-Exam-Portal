<?php
session_start();
if(isset($_SESSION["admin"]))
{
}
else{
	header("Location:index.php");
}
if(isset($_SESSION["paper_name"]))
{
	$pname=$_SESSION["paper_name"];
	if($_SESSION["paper_name"]=="")
	{
		header("Location:paperupload.php");
	}
}else{
		//header("Location:paperupload.php");
}
//connect to db
include("connection.php");
mysqli_select_db($con,"online_exam_papers");
$q=$_REQUEST["q"];
$o1=$_REQUEST["opt1"];
$o2=$_REQUEST["opt2"];
$o3=$_REQUEST["opt3"];
$o4=$_REQUEST["opt4"];
$ans=$_REQUEST["ans"];
$sql1=mysqli_query($con,"insert into $pname (question,option1,option2,option3,option4,answer) values('$q','$o1','$o2','$o3','$o4','$ans')");
header("Location:paperedit.php");
?>