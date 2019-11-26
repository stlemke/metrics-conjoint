<?php
session_start();
include('db/connectdb.php');
//PROCESSING INPUTS FROM P2
$session_id = session_id();

$sql = "SELECT * FROM respondents WHERE Session_ID = '".$session_id."'";
$result = $conn->query($sql);

if($result->rowCount() > 0) {
	if(isset($_POST['Gender'])) {
		$sql = "UPDATE respondents SET Gender = '".$_POST['Gender']."' WHERE Session_ID = '".$session_id."'";
		$conn->exec($sql);
	}
	if(isset($_POST['Year_of_birth'])) {
		$sql = "UPDATE respondents SET Birthyear = '".$_POST['Year_of_birth']."' WHERE Session_ID = '".$session_id."'";
		$conn->exec($sql);
	}
	if(isset($_POST['Academic_Experience'])) {
		$sql = "UPDATE respondents SET Years_of_AE = '".$_POST['Academic_Experience']."' WHERE Session_ID = '".$session_id."'";
		$conn->exec($sql);
	}
	if(isset($_POST['Country'])) {
		$sql = "UPDATE respondents SET Country = '".$_POST['Country']."' WHERE Session_ID = '".$session_id."'";
		$conn->exec($sql);
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
				<div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width:99%">
				  99%
				</div>
			</div>
			<form action="close.php"  method="POST" name="startform" style="width:100%" onsubmit="return validate(this);">
				<h3>Thank you!</h3>
				<p>
				Thank you very much once more for taking part in this experiment. If you want to enter the aforementioned drawing of 15 Amazon vouchers (30€ each), please enter a valid email address below. If you would like to receive information on this experiment's results, future user studies or our project in general, you can indicate this by selecting the corresponding check boxes below.<br><br> Your email address will be stored separately from your previous inputs and will only be used to contact you for the reasons you select on this page.<br><br>
				</p>
				<label style="margin-left:40px">Email: <input type="text" name="email" style="width:200px;margin-left:21px" maxlength="64"></label><br><br>
				<label>
				  <input type="checkbox" class="agreement-checkbox" name="drawing-checkbox" value="agree" style="margin-left:40px">
				  I would like to enter the prize drawing.
				</label><br>
				<label>
				  <input type="checkbox" class="agreement-checkbox" name="results-checkbox" value="agree" style="margin-left:40px">
				  I would like to be notified about this experiment's results.
				</label><br>
				<label>
				  <input type="checkbox" class="agreement-checkbox" name="generalupdates-checkbox" value="agree" style="margin-left:40px">
				  I would like to receive updates on the *metrics project in general. 
				</label><br>
				<label>
				  <input type="checkbox" class="agreement-checkbox" name="futurestudies-checkbox" value="agree" style="margin-left:40px">
				  I would like to be invited again in the case of future user studies of ZBW's research group. 
				</label>
				<br><br>
				<p><br>On the next page, you will have the option to additionally pariticpate in a short bonus experiment to earn an additional lot for the drawing. <br>If you have any further questions, do not hesitate to contact us via mail to s.lemke@zbw.eu.<br><br><br>
				Best regards <br>
				<i>The *metrics-project team</i><br><br><br>
				<b>Contact:</b><br>
				ZBW - Leibniz Information Centre for Economics<br>
				Steffen Lemke<br>
				Mail: s.lemke@zbw.eu<br>
				https://metrics-project.net/<br><br></p>
				<hr style="background-color:rgb(42,49,98);height:1px;border:0px;border-radius:10px">	
					<div style="width:210px;margin-left:auto;margin-right:auto;margin-bottom:10px">
						<a class="startbutton" href="p2.php" style="float:left;text-align:center;padding:5px 0px 0px 0px;height:26px">Back</a>
						<button class="startbutton" type="submit" value="Submit" id="start" style="margin-left:auto;margin-right:auto">Continue</button>
					</div>
					<button type="button" class="deletebutton" onclick="exit()" style="float:left;margin-left:10px">Exit and clear data</button>
			</form>	
		</div>
	
	<script>
	
	function validate(form) {
		var checkedValue0 = null;
		var checkedValue1 = null; 
		var checkedValue2 = null; 
		var checkedValue3 = null; 

		var inputElements = document.getElementsByName('drawing-checkbox');
		for(var i=0; inputElements[i]; ++i){
			  if(inputElements[i].checked){
				   checkedValue0 = inputElements[i].value;
				   break;
			  }
		}
		var inputElements = document.getElementsByName('results-checkbox');
		for(var i=0; inputElements[i]; ++i){
			  if(inputElements[i].checked){
				   checkedValue1 = inputElements[i].value;
				   break;
			  }
		}
		var inputElements = document.getElementsByName('generalupdates-checkbox');
		for(var i=0; inputElements[i]; ++i){
			  if(inputElements[i].checked){
				   checkedValue2 = inputElements[i].value;
				   break;
			  }
		}
		var inputElements = document.getElementsByName('futurestudies-checkbox');
		for(var i=0; inputElements[i]; ++i){
			  if(inputElements[i].checked){
				   checkedValue3 = inputElements[i].value;
				   break;
			  }
		}
		
		var x = $("input[name='email']").val(); 
		if ((x == null || x == "") && ((checkedValue0 == "agree") || (checkedValue1 == "agree") || (checkedValue2 == "agree") || (checkedValue3 == "agree"))) {
			alert("If you selected one or more of the checkboxes, please also enter a valid email address under which we should contact you.");
			return false;
		}
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
