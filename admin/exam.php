<?php
session_start();
if(isset($_SESSION["user"]))
{
	$_SESSION["user"];
	$user=$_SESSION["user"];
	if(isset($_SESSION["paper_code"]))
	{
		$tablename=$_SESSION["paper_code"];
	}
	else{
		header("Location:index.php");
	}
}
else{
	header("Location:index.php");
}
//connect to db
include("connection.php");
mysqli_select_db($con,"online_users");

?>

<html>
	<head><meta name="viewport" content="width=device-width,initial-scale=1.0" >
		<link rel="stylesheet" type="text/css" href="common.css">
		<link rel="stylesheet" type="text/css" href="exam.css">
		<title>Exam</title>
	</head>
<body>
	<div class="title"><i>Online Exam Portal</i>
		<div class="timer">
            <time id="countdown">30:00</time>
        </div></div>
	<div class="div1">
	<p align="center" style="color:red;" class="note">Note:Carefully Read All Questions Before Selecting option.</p>
	<form name="form1" method="post" action="result.php">
	<?php
	//select all questions from database
	$sql=mysqli_query($con,"select * from $tablename");
	$i=1;
	while($row=mysqli_fetch_assoc($sql))
	{
	$req_no="no".$i;
	$qno=$row["qno"];
	$opt1=$row["option1"];
	$opt2=$row["option2"];
	$opt3=$row["option3"];
	$opt4=$row["option4"];
	echo $i.")  ".$row["question"]."<br><br>".
	"<b>a.</b>  <input type='radio' name='".$req_no."[]' value='$opt1' />$opt1<br>
	<b>b.</b>   <input class='radio' type='radio'  name='".$req_no."[]' value='$opt2' />$opt2<br>
	<b>c.</b>   <input class='radio' type='radio'  name='".$req_no."[]' value='$opt3' />$opt3<br>
	<b>d.</b>  <input class='radio' type='radio' name='".$req_no."[]' value='$opt4' />$opt4<br>
	<input type='hidden' name='tot' value=$i>
	<input type='hidden' name='qno[]' value=$qno><br><br><br>";
		$i++;
	}

	?>
	<input class="btn" type="submit" value="Finesh Test">
	</form>
	</div>
	<script>
 var seconds = 1800;
      function secondPassed() {
          var minutes = Math.round((seconds - 30)/60),
              remainingSeconds = seconds % 60;

          if (remainingSeconds < 10) {
              remainingSeconds = "0" + remainingSeconds;
          }

          document.getElementById('countdown').innerHTML = minutes + ":" + remainingSeconds;
          if (seconds == 0) {
              clearInterval(countdownTimer);
             //form1 is your form name
            document.form1.submit();
          } else {
              seconds--;
          }
      }
      var countdownTimer = setInterval('secondPassed()', 1000);
</script>
</body>
</html>