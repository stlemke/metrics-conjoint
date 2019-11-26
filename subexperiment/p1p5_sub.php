<?php
session_start();
include('../db/connectdb.php');

$session_id = session_id();

$sql = "SELECT * FROM respondents WHERE Session_ID = '".$session_id."'";
$result = $conn->query($sql);
if($result->rowCount() > 0) {
} else {
	header("Location: ".$_SESSION['root_dir']."index.php");
	die();
}

if(isset($_POST['post-ranking'])) {
	$rankingInput = explode(",",$_POST['post-ranking']);
	$displayInput = explode(",",$_POST['post-display']);
	foreach($result as $row) {
		$respondent = $row['Respondent_ID'];
	}
	$displayOrder = "";
	foreach($displayInput as $item) {
		if($displayOrder == "") {
			$displayOrder = $item;
		} else {
			$displayOrder = $displayOrder.",".$item;
		}
	}
	$rankingOrder = "";
	foreach($rankingInput as $item) {
		if(is_numeric($item)) {
			if($rankingOrder == "") {
				$rankingOrder = $item;
			} else {
				$rankingOrder = $rankingOrder.",".$item;
			}
		}
	}
	$dt = new DateTime();
	$dtstring = $dt->format('Y-m-d H:i:s');

	$sql = "INSERT INTO sub_choices (Respondent_ID, PubIDs_Order_Displayed, PubIDs_Order_Chosen, Timestamp)
		VALUES ('".$respondent."','".$displayOrder."','".$rankingOrder."','".$dtstring."')";
		$conn->exec($sql);
		
	$_SESSION['bonusTasksSolved']++;
}



?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>*metrics Study on User Perceptions - Visualizations</title>
    <link rel="stylesheet" href="../css/style.css">
	<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>

	<body>
		<div class="maincontainer">
			<?php include('header_sub.php');?>
			<hr style="background-color:rgb(42,49,98);height:1px;border:0px;border-radius:10px;margin-top:10px">
			<div class="progress">
				<div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width:90%">
				  90%
				</div>
			</div>
			<form action="close_sub.php"  method="POST" name="startform" style="width:100%" onsubmit="return validate(this);">
				<h3>Additional Comments</h3>
				<p>
				<b>Do you have any comments on the bonus-experiment you just participated in?</b></p>
				<textarea rows="4" cols="80" maxlength="1000" style="margin-left:20px" name="comments"></textarea><br><br>
				
				<p>
				If you would like to receive an additional lot in the aforementioned drawing of 15 Amazon vouchers (30€ each), please enter a valid email address below. <br><br> Your email address will be stored separately from your previous inputs and will only be used in the price drawing.<br><br>
				</p>
				<label style="margin-left:40px">Email: <input type="text" name="email" style="width:200px;margin-left:21px" maxlength="64"></label><br><br>
				
				
				
				<hr style="background-color:rgb(42,49,98);height:1px;border:0px;border-radius:10px">
				<div style="width:210px;margin-left:auto;margin-right:auto;margin-bottom:10px">
						<button class="startbutton" type="submit" value="Submit" id="start" style="float:right">Continue</button>
					</div>
					<button type="button" class="deletebutton" onclick="exit()" style="float:left;margin-left:10px">Exit and clear data</button>
			</form>	
		</div>
		
		
		
	<script>
	function validate(form) {

	}
	
	function exit() {
		var r = confirm("Do you really want to exit the experiment and clear all your previous input? You can restart the experiment later, but you will need to start it from the beginning.");
		if (r == true) {
			window.location.replace($_SESSION['root_dir']."exit.php");
		}
	}
	</script>
	</body>
</html>
