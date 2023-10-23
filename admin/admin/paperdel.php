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
		header("Location:paperdelete.php");
	}
}else{
		header("Location:paperdelete.php");
}

$val=mysqli_query($con,"select count(*) as ct from paper_name where paper_name='$pname'");
while($row_val=mysqli_fetch_assoc($val))
{
	$res=$row_val["ct"];
}
if($res==0)
{
		header("Location:paperdelete.php");
}
else{
	mysqli_query($con,"delete from paper_name where paper_name='$pname'");
	mysqli_query($con,"drop table $pname");
	header("Location:paperdelete.php");
}
?>
