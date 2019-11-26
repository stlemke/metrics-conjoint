<?php
session_start();
include('db/connectdb.php');
//DELETE ALL USER INPUT
$session_id = session_id();

$sql = "SELECT * FROM respondents WHERE Session_ID = '".$session_id."'";
$result = $conn->query($sql);

if($result->rowCount() > 0) {
	foreach($result as $row) {
		if(isset($row['Respondent_ID'])) {
			$respondent_id = $row['Respondent_ID'];
			
			$statement = $conn->prepare("DELETE FROM choices WHERE Respondent_ID = :respondent_id");
			$statement->execute(array('respondent_id' => $respondent_id));	
			
			$statement = $conn->prepare("DELETE FROM respondents WHERE Respondent_ID = :respondent_id");
			$statement->execute(array('respondent_id' => $respondent_id));	
			
			$statement = $conn->prepare("DELETE FROM sub_choices WHERE Respondent_ID = :respondent_id");
			$statement->execute(array('respondent_id' => $respondent_id));	
		}
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
				<h3>Goodbye!</h3>
				<p>
				You exited the experiment without saving your input - all data collected during your participation was deleted. 
				<br><br>
				You can start the experiment again at any time by visiting <a href="<?php echo $_SESSION['root_dir'];?>index.php"><?php echo $_SESSION['root_dir'];?>index.php</a>. 
				</p>
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
