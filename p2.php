<?php
session_start();
include('db/connectdb.php');

//PROCESSING INPUTS FROM P1P5
$session_id = session_id();

$sql = "SELECT * FROM respondents WHERE Session_ID = '".$session_id."'";
$result = $conn->query($sql);

if($result->rowCount() > 0) {
	if(isset($_POST['FavIndicator'])) {
		$sql = "UPDATE respondents SET FavIndicator = '".$_POST['FavIndicator']."' WHERE Session_ID = '".$session_id."'";
		$conn->exec($sql);
	}
	if(isset($_POST['otherfeatures'])) {
		$statement = $conn->prepare("UPDATE respondents SET Other_Features = :features WHERE Session_ID = :sessionid");
		$statement->execute(array('features' => $_POST['otherfeatures'], 'sessionid' => $session_id));
	}
	if(isset($_POST['comments'])) {
		$statement = $conn->prepare("UPDATE respondents SET Comments = :comments WHERE Session_ID = :sessionid");
		$statement->execute(array('comments' => $_POST['comments'], 'sessionid' => $session_id));
	}
} else {
	header("Location: ".$_SESSION['root_dir']."index.php");
	die();
}

//CHECK FOR PREVIOUS INPUTS ON THIS PAGE
$prevGender = "";
$prevBirthyear = "";
$prevAE = "";
$prevCountry = "";
foreach($result as $row) {
	if(isset($row['Gender'])) {
		$prevGender = $row['Gender'];
	}
	if(isset($row['Birthyear'])) {
		$prevBirthyear = $row['Birthyear'];
	}
	if(isset($row['Years_of_AE'])) {
		$prevAE = $row['Years_of_AE'];
	}
	if(isset($row['Country'])) {
		$prevCountry = $row['Country'];
	}
}

?>
<!DOCTYPE html>
<html lang="en">

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
				<div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width:95%">
				  95%
				</div>
			</div>
			<form action="thankyou.php"  method="POST" name="startform" style="width:100%;font-size:13px" onsubmit="return validate(this);">
			
				<h3>Demographic Information</h3>
				<p>Finally, please answer the following questions about your demographic properties.</p>
				<div class="form-group" style="margin-left:20px;margin-right:20px">
					<b>4. Please select your gender.*</b><br>
					<?php 
						$genderOptions = array(0 => "I prefer not to answer", 1 => "Female", 2 => "Male", 3 => "Other");
					?>
						<br><select class="form-control" id="sel1" name="Gender" style="width:160px">
							<?php
								foreach($genderOptions as $opt) {
									echo "<option";
									if($opt==$prevGender) {
										echo " selected='selected'";
									}
									echo ">".$opt;
									echo "</option>";
								}
							?>
						</select>
				</div><br>
				
				<div class="form-group" style="margin-left:20px;margin-right:20px">
					<b>5. Please enter your year of birth.*</b><br>
						<br><div class="number"><label><input type="number" name="Year_of_birth" step="1" min="1900" max="2018" style="width:80px" <?php if(isset($prevBirthyear)){echo "value='".$prevBirthyear."'";}?>> Year of Birth</label></div>
				</div><br>	
				
				<div class="form-group" style="margin-left:20px;margin-right:20px">
					<b>6. For how many years have you been doing academic work (after having finished your studies, e.g. with a bachelor's or master's degree)?</b><br>
						<br><div class="number"><label><input type="number" name="Academic_Experience" step="1" min="0" max="70" style="width:80px" <?php if(isset($prevAE)){echo "value='".$prevAE."'";}?>> Years of academic experience</label></div>
				</div><br>	
				
				<div class="form-group" style="margin-left:20px;margin-right:20px">
					<b>7. What is the country of your current (or last) affiliation?*</b><br>
						<br><select class="form-control" id="sel2" name="Country" style="width:320px">
							<option selected="selected"></option>
							<?php 
							include('countrylist.php');
							?>
						</select>
				</div><br>
				
				<br>
					<hr style="background-color:rgb(42,49,98);height:1px;border:0px;border-radius:10px">	
					<div style="width:210px;margin-left:auto;margin-right:auto;margin-bottom:10px">
						<a class="startbutton" href="p1p5.php" style="float:left;text-align:center;padding:5px 0px 0px 0px;height:26px">Back</a>
						<button class="startbutton" type="submit" value="Submit" id="start" style="float:right">Continue</button>
					</div>
					<button type="button" class="deletebutton" onclick="exit()" style="float:left;margin-left:10px">Exit and clear data</button>
			</form>	
			<br><br>
		</div>
	<script>
	function validate(form) {

		// validation code here ...
		var x = $("select[name='Gender'] option:selected").val(); 
		if (x == null || x == "") {
			alert("Please select your gender.");
			return false;
		}
		var x = $("input[name='Year_of_birth']").val(); 
		if (x == null || x == "") {
			alert("Please enter your year of birth.");
			return false;
		}
		var x = $("select[name='Country'] option:selected").val(); 
		if (x == null || x == "") {
			alert("Please select your country of affiliation.");
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
