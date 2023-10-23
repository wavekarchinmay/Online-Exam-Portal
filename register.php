<?php
// error_reporting(0);
require_once 'phpmailer/src/PHPMailer.php';
require_once 'phpmailer/src/SMTP.php';
require_once 'phpmailer/src/Exception.php';

//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function returnCred(){
	if(!file_exists('cred.env')){
		return;
	}

	$cont = file_get_contents('cred.env');
	$res = explode(' ',$cont);
	if(count($res) > 0 && !empty($res[0]) && !empty($res[1])){
		$temp = [];
		foreach($res as $key => $val){
			$result = explode('=',$val);
			if(count($result) > 0){
				$temp[$result[0]] = $result[1];
			}
		}
		return $temp;
	}else{
		return;
	}
}

function sendMail($email,$name){
	$fname = 'logs.txt';
	$per = file_exists($fname) ? "a" : "w+";
	$cred = returnCred();

	if(!$cred){
		echo "Someting wents to wring with env file!";
	}

	$mail = new PHPMailer(true);
	$mail->isSMTP();
	$mail->SMTPAuth = true;

	//to view proper logging details for success and error messages
	// $mail->SMTPDebug = 1;
	$mail->Host = 'smtp.gmail.com';  //gmail SMTP server
	$mail->Username = $cred['email'];   //email
	$mail->Password = $cred['pass'];   //16 character obtained from app password created
	$mail->Port = 465;                    //SMTP port
	$mail->SMTPSecure = "ssl";

	//sender information
	$mail->setFrom($cred['email'], 'Exam Portal');

	//receiver address and name
	$mail->addAddress($email, $name);

	$mail->isHTML(true);

	$mail->Subject = 'Exam Portal Registration';
	$mail->Body    = "<h1>Welcome, ".$name."</h1><br> You are successfully registered!";

	// Send mail
	try{
		if (!$mail->send()) {
			$log = fopen($fname,$per);
			fwrite($log,'Unable to send mail '.date('h:i:s d:m:y').' '. $mail->ErrorInfo);
			fclose($log);
		}

	}catch(Exception $e){
		$log = fopen($fname,$per);
		fwrite($log,'Unable to send mail '.date('h:i:s d:m:y').' '. $e);
		fclose($log);
	}
	

	$mail->smtpClose();
}

include("connection.php");

$db=mysqli_select_db($con,"registration");
if(!$db)
{
	die("not connect");
}
$email=$_REQUEST["email"];
$name=$_REQUEST["nm"];
$req_pwd=$_REQUEST["pwd"];
if($name=="" && $req_pwd=="")
{
	header("Location:index.php");
}
else{
	$val=mysqli_query($con,"select count(*) as ct from user_reg where uname='$name'");
	while($row_row=mysqli_fetch_assoc($val))
	{
		$res=$row_row["ct"];
	}
	if($res==0)
	{
		sendMail($email,$name);
		$sql1=mysqli_query($con,"insert into user_reg (uname,pwd,email,reg_date) values ('$name','$req_pwd','$email',CURRENT_TIMESTAMP)");
		$msg="Congratulations"." ".$name." "."You Are Successfully Registered.";
	}
	else{
		$msg="Sorry Username Alrady Exist.Try Another One.";
	}
}
?>
<html>
<head><meta name="viewport" content="width=device-width,initial-scale=1.0" >
	<link rel="stylesheet" type="text/css" href="register.css">
	 <link rel="stylesheet" type="text/css" href="common.css">
	 <title>Registration Success</title>
 </head>  
	<body>
	 <div class="title"><i>Online Examination Portal</i></div>
	<div class="div1">
		<p class="p1"><?php echo $msg; ?></p>
		<button class="btn" onclick="login()">Login</button>
	</div>
	</body>
	<script lang="js">
		function login()
		{
			window.open("index.php","_self");
		}
	</script>
</html>