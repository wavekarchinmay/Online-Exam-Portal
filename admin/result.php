<?php
session_start();
//vaidate user session created or not
if(isset($_SESSION["user"]))
{
	$user=$_SESSION["user"];
	$tablename=$_SESSION["paper_code"];
}
else{
	header("Location:index.php");
}

//session for database table
if(isset($_SESSION["paper_code_val"]))
{
	$paper_code_val=$_SESSION["paper_code_val"];
}
else{
	header("Location:index.php");
}

//connect to db
include("connection.php");
mysqli_select_db($con,"online_users");

//fetch user answer from prev page
$qno=$_REQUEST["qno"];
$tot_questions=$_REQUEST["tot"];
$attemp=0;
for($i=1;$i<=$tot_questions;$i++)
{
	$req='no'.$i;
	
	if(isset($_REQUEST[$req]))
	{
		$np=$_REQUEST[$req];
		//echo $qno[$i-1];
		$attemp=($attemp+1);
		for($j=0;$j<count($np);$j++)
		{
			
			$ans=$np[$j];
			$qn=$qno[$i-1];
			//update table 
			$sql2=mysqli_query($con,"update $tablename set user_ans='$ans' where qno='$qn'");
		}	
	}
	else{
		$np="";
	}
}

$true=0;
$false=0;
$sql3=mysqli_query($con,"select * from $tablename");
while($row_user_tb=mysqli_fetch_assoc($sql3))
{
	$usr_qno=$row_user_tb["qno"];
	$usr_ans=$row_user_tb["user_ans"];
	$sql4=mysqli_query($con,"select * from online_exam_papers.$paper_code_val where qno='$usr_qno'");
	while($row_paper_tb=mysqli_fetch_assoc($sql4))
	{
		$db_qno=$row_paper_tb["qno"]."<br>";
		$db_ans=$row_paper_tb["answer"];
		if($usr_ans==$db_ans)
		{
			$true=($true+1);
		}
		else{
			$false=($false+1);
		}
		
	}
}
if(isset($_SESSION["user"]))
{
	$val=mysqli_query($con,"select count(*) as ct from online_exam_papers.paper_status where user_name='$user' and paper_name='$paper_code_val'");
	while($row_v=mysqli_fetch_assoc($val))
	{
		$res=$row_v["ct"];
	}
	if($res==0)
	{
		$sql_status=mysqli_query($con,"insert into online_exam_papers.paper_status (paper_name,user_name,status) values ('$paper_code_val','$user','True')");
		$sql_report=mysqli_query($con,"insert into online_exam_papers.report (username,paper_name,total_ques,tot_attempt,wrong_ans,right_ans,date_time) values('$user','$paper_code_val','$tot_questions','$attemp','$false','$true',CURRENT_TIMESTAMP)");
		
	}
}
session_unset();
session_destroy();

?>
<html>
<head><meta name="viewport" content="width=device-width,initial-scale=1.0" >
	<link rel="stylesheet" type="text/css" href="common.css">
	<link rel="stylesheet" type="text/css" href="result.css">
	<title>Result</title>
</head>
	<body>
	<div class="title"><i>Online Exam Portal</i></div>
		<div class="div1">
			<p class="p1">Result</p>
				<p class="res">Right Answer:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $true; ?></p>
				<p class="res">Wrong Answer:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $false; ?></p>
				<p class="res">Total Attempts:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $attemp."/".$tot_questions; ?></p>		
		</div>
	</body>
</html>