<?php
$username=$_REQUEST["un"];
$password=$_REQUEST["pwd"];
include ("connection.php");
if(!$con)
{
	die("connetion");
}
if($_REQUEST["un"]=="") 
{
	//header("Location:index.php");
}
else if($_REQUEST["pwd"]=="")
{
	//header("Location:index.php");
}
$res="Invalid Username";
mysqli_select_db($con,"admin");
$sql=mysqli_query($con,"select * from login where username='$username'");
while($row=mysqli_fetch_assoc($sql))
{
	
	$db_un=$row["username"];
	$db_pwd=$row["password"];
	if($username==$db_un && $password==$db_pwd)
	{
		session_start();
		$_SESSION["admin"]=$username;
		header("Location:adminporter.php");
	}
	else{
		$res="Invalid Username or password";
	}
	echo mysqli_error($con);
}

?>
<html>
<head><meta name="viewport" content="width=device-width,initial-scale=1.0" >
	<link rel="stylesheet" type="text/css" href="../common.css">
	<link rel="stylesheet" type="text/css" href="../valid.css">
</head>
	<body>
	<div class="title"><i>Online Examination Portal</i></div>
		<div class="div1">
			<p class="p1">Error</p>
		<p class="res" style="text-align:center;margin-left:0;"><?php echo $res; ?></p>
		<button class="btn" onclick="login()">Login</button>
		</div>
	<script lang="js">
		function login()
		{
			window.open("index.php","_self");
		}
	</script>
	</body>
</html>