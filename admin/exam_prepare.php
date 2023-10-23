<html>
	<head><meta name="viewport" content="width=device-width,initial-scale=1.0" >
		<title>Error</title>
			<link rel="stylesheet" type="text/css" href="common.css">
			<link rel="stylesheet" type="text/css" href="error.css">
	</head>
	<body>
		<?php
		session_start();
		if(isset($_SESSION["user"]))
		{
			$user=$_SESSION["user"];
		}
		else{
			header("Location:index.php");
		}

		//connect to db
		include("connection.php");
		mysqli_select_db($con,"online_users");

		//validate whether input has empty or not
		if($_REQUEST["paper_code"]!="")
		{	
			$paper_code=$_REQUEST["paper_code"];
			$_SESSION["paper_code_val"]=$paper_code;
		}
		else{
			header("Location:selectpaper.php");
		}

		//create required table name
		$req_table=$user.$paper_code;
		?>
		<?php
			$sql_paper_val=mysqli_query($con,"select * from online_exam_papers.paper_name where paper_name='$paper_code'");
			while($row_paper=mysqli_fetch_assoc($sql_paper_val))
			{
				$pap=$row_paper["paper_name"];
				if($pap!=$paper_code)
				{
					header("Location:selectpaper.php");
				}
				else{
					//create table same as username
					$sql=mysqli_query($con,"CREATE TABLE IF NOT EXISTS `$req_table` (
						`no` int(11) NOT NULL AUTO_INCREMENT,
						`qno` int(11) NOT NULL,
						`username` varchar(50) NOT NULL,
						`question` varchar(200) NOT NULL,
						`option1` varchar(200) NOT NULL,
						`option2` varchar(200) NOT NULL,
						`option3` varchar(200) NOT NULL,
						`option4` varchar(200) NOT NULL,
						`user_ans` varchar(200) NOT NULL,
						PRIMARY KEY (`no`)
					)");
					//echo $req_table;
					$sql_chk=mysqli_query($con,"select count(*) as tot from $req_table");
					while($rowchk=mysqli_fetch_assoc($sql_chk))
					{
						$count=$rowchk["tot"];
					}
					if($count==0)
					{
						echo mysqli_error($con);
						//used to randomly select question from paper_set
						$sql1=mysqli_query($con,"select * from online_exam_papers.$paper_code order by rand() limit 20");
						$i=1;	
						while($row=mysqli_fetch_assoc($sql1))
						{
							$req_no="no".$i;
							$qno=$row["qno"];
							$qus=$row["question"];
							$opt1=$row["option1"];
							$opt2=$row["option2"];
							$opt3=$row["option3"];
							$opt4=$row["option4"];
							$sql2=mysqli_query($con,"insert into $req_table (qno,username,question,option1,option2,option3,option4,user_ans) values('$qno','$user','$qus','$opt1','$opt2','$opt3','$opt4',' ')");
							$_SESSION["paper_code"]=$req_table;
							header("Location:exam.php");
						}
					}
					else{
						$sql_status=mysqli_query($con,"select count(*) as cts from online_exam_papers.paper_status where user_name='$user' and status='true' and paper_name='$paper_code'");
						while($row_stat=mysqli_fetch_assoc($sql_status))
						{
							$p_state=$row_stat["cts"];
							
						}
						if($p_state==0)
						{
								echo"paper_ok";
								$_SESSION["paper_code"]=$req_table;
								header("Location:exam.php");
						}
						else{
								echo"paper_error";
								header("Location:error.php");
						}
					}
				}
			}
	?>
	<div class="title"><i>Online Exam Portal</i></div>
	<div class="div1">
		<p class="p1">Error</p>
		<form method="post" action="exam_prepare.php">
			<p class="res" style="text-align: center;margin-left: 0;">Enter Valid Paper Name</p>
		</form>
	</div>

</html>