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
if(isset($_REQUEST["new_name"]) && !empty($_REQUEST["new_name"]))
{
	 $pname=$_REQUEST["new_name"];
	 $sql1=mysqli_query($con,"CREATE TABLE IF NOT EXISTS `$pname` (
		  `qno` int(11) NOT NULL AUTO_INCREMENT,
		  `question` varchar(100) NOT NULL,
		  `option1` varchar(200) NOT NULL,
		  `option2` varchar(200) NOT NULL,
		  `option3` varchar(200) NOT NULL,
		  `option4` varchar(200) NOT NULL,
		  `answer` varchar(200) NOT NULL,
		  PRIMARY KEY (`qno`))");
		$val=mysqli_query($con,"select count(*) as ct from paper_name where paper_name='$pname'");
		while($row_v=mysqli_fetch_assoc($val))
		{
			$res=$row_v["ct"];
		}
		if($res==0)
		{
			$sql2=mysqli_query($con,"insert into paper_name (paper_name) values('$pname') ");
			header("Location:paperupload.php");
		}
		else{
		  echo "<div style='width:300px;height:150px;border:1px solid red;margin:auto;margin-top:150px;color:red;text-align:center;'><p style='margin-top:50px;'>Table Name Exist Please Choose Another Name</p></div>";
		}
}else{
	//echo "ok";
		header("Location:paperupload.php");
}
//exit;
?>