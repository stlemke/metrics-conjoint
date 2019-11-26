<?php
session_start();
include('db/connectdb.php');
//PROCESSING INPUT FROM thankyou.php
$session_id = session_id();

$sql = "SELECT * FROM respondents WHERE Session_ID = '".$session_id."'";
$result = $conn->query($sql);

if($result->rowCount() > 0) {
	$Want_drawing = "";
	$Want_results = "";
	$Want_general_info = "";
	$Want_invitations = "";
	if(isset($_POST['email'])) {
		if(isset($_POST['drawing-checkbox'])) {
			$Want_drawing = "yes";
		}
		if(isset($_POST['results-checkbox'])) {
			$Want_results = "yes";
		}
		if(isset($_POST['generalupdates-checkbox'])) {
			$Want_general_info = "yes";
		}
		if(isset($_POST['futurestudies-checkbox'])) {
			$Want_invitations = "yes";
		}
		$statement = $conn->prepare("INSERT INTO reimbursement (Email, Want_drawing, Want_results, Want_general_info, Want_invitations) VALUES (:email, :want_drawing, :want_results, :want_general_info, :want_invitations)");
		$statement->execute(array('email' => $_POST['email'], 'want_drawing' => $Want_drawing, 'want_results' => $Want_results, 'want_general_info' => $Want_general_info, 'want_invitations' => $Want_invitations));		
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
    <title>*metrics Study on User Perceptions</title>
    <link rel="stylesheet" href="css/style.css">
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
			<?php include('header.php');?>
			<hr style="background-color:rgb(42,49,98);height:1px;border:0px;border-radius:10px;margin-top:10px">			
			<div class="progress">
				<div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width:100%">
				  100%
				</div>
			</div>
				<h3>Thank you!</h3>
				<p>
				Your submission has been registered. Thank you very much for completing this experiment. 
				<br><br>
				If you'd be interested in additionally participating in a related (much shorter) experiment of ours, you can do so by clicking on the image below or on <a href="subexperiment/demo_sub.php" style="width:600px" target="_blank">this link</a>. The second experiment investigates on how certain visualizations for metrics data are interpreted by researchers and would take about 5 minutes to complete. If you participate in the Amazon voucher drawing, completing the bonus experiment will grant you one additional lot. 
				</p><br>
				<center><a href="subexperiment/demo_sub.php" style="width:600px" target="_blank"><img src="img/subexp_preview_c.png" alt="Sub-Experiment" style="border:1px solid black;width:600px"></a></center>
				<br><br>
				<p><b>Contact:</b><br>
				ZBW - Leibniz Information Centre for Economics<br>
				Steffen Lemke<br>
				Mail: s.lemke@zbw.eu<br>
				https://metrics-project.net/<br><br></p>
				<hr style="background-color:rgb(42,49,98);height:1px;border:0px;border-radius:10px">
		</div>
	

	</body>
</html>
