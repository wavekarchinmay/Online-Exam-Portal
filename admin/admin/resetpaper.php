<?php
session_start();
if(!isset($_SESSION["admin"])){
	header("Location:index.php");
}

include("connection.php");
mysqli_select_db($con,"online_users");

if(empty($_REQUEST["name"]) || empty($_REQUEST["paper"]))
{	
	header("Location:report.php");
}

$qry = "delete from online_exam_papers.report where username='".$_REQUEST['name']."' && paper_name='".$_REQUEST['paper']."'";
$qry2 = "delete from online_exam_papers.paper_status where user_name='".$_REQUEST['name']."' && paper_name='".$_REQUEST['paper']."'";
$res2 = mysqli_query($con,$qry);
$res3 = mysqli_query($con,$qry2);
if($res2 && $res3){
	$pid = $_REQUEST['name'].$_REQUEST['paper'];
	$val = mysqli_query($con,"SHOW TABLES LIKE '".strtolower($pid)."'");
	if(isset($val->field_count)){
		$res = mysqli_query($con,"Drop table ".$pid);
		if($res){
			header("Location:report.php");
		}
	}
}
header("Location:error.php");

?>
