<?php
session_start();
include('../db/connectdb.php');

//PROCESSING INPUTS FROM P1P5
$session_id = session_id();

$sql = "SELECT * FROM respondents WHERE Session_ID = '".$session_id."'";
$result = $conn->query($sql);

if($result->rowCount() > 0) {
	if(isset($_POST['comments'])) {
		$statement = $conn->prepare("UPDATE respondents SET Sub_Comments = :comments WHERE Session_ID = :sessionid");
		$statement->execute(array('comments' => $_POST['comments'], 'sessionid' => $session_id));
	}
	if(isset($_POST['email'])) {
		$statement = $conn->prepare("INSERT INTO reimbursement (Sub_Email) VALUES (:email)");
		$statement->execute(array('email' => $_POST['email']));		
	}
	
	
} else {
	header("Location: ".$_SESSION['root_dir']."index.php");
	die();
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>*metrics Study on User Perceptions - Visualizations</title>
    <link rel="stylesheet" href="../css/style.css">
	<link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon" />
	
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
				<div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width:100%">
				  100%
				</div>
			</div>
				<h3>Thank you!</h3>
				<p>
				Your submission has been registered. Thank you very much for completing this experiment.<br><br>
				You can now close this window.
				</p>
				<p><b>Contact:</b><br>
				INSTITUTE<br>
				CONTACT PERSON<br>
				MAIL ADDRESS<br>
				PROJECT HOMEPAGE<br><br></p>
				<hr style="background-color:rgb(42,49,98);height:1px;border:0px;border-radius:10px">
		</div>
	

	</body>
</html>
