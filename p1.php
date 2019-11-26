<?php
session_start();
include('db/connectdb.php');

$session_id = session_id();

$sql = "SELECT * FROM respondents WHERE Session_ID = '".$session_id."'";
$result = $conn->query($sql);

if($result->rowCount() > 0) {
	//echo "User already in database.<br>";		
} else {
	//echo "Writing new user to database.<br>";
	$currenttime = date('Y-m-d H:i:s');
	$ip = $_SERVER['REMOTE_ADDR'];
	$sql2 = "INSERT INTO respondents (Session_ID, Date_Started, Last_Page, IP_Address)
	VALUES ('".$session_id."','".$currenttime."',1,'".$ip."')";
	$conn->exec($sql2);
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
	<div class="container-fluid">
		<div class="maincontainer" style="">
			<?php include('header.php');?>
			<hr style="background-color:rgb(42,49,98);height:1px;border:0px;border-radius:10px;margin-top:10px">
			<div class="progress">
				<div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width:1%">
				  1%
				</div>
			</div>
			<form action="explanation.php"  method="POST" name="startform" style="width:100%;font-size:13px" onsubmit="return validate(this);">
			
				<h3>Information on Professional Background</h3>
				<p>Before we start with the actual experiment, please answer the following questions about your professional background.</p>
				
				<div class="form-group" style="margin-left:20px;margin-right:20px">
					<b>1. What discipline are you primarily working in?*</b><br>
						<div class="radio"><label><input type="radio" id="arts" name="Discipline" value="Arts/Humanities" onclick="showBranches()">Arts/Humanities</label></div>
						<div class="radio"><label><input type="radio" id="econ" name="Discipline" value="Economics" onclick="showBranches('econ')">Economics</label></div>
						<div class="radio"><label><input type="radio" id="engi" name="Discipline" value="Engineering/Technology" onclick="showBranches()">Engineering/Technology</label></div>
						<div class="radio"><label><input type="radio" id="law" name="Discipline" value="Law" onclick="showBranches()">Law</label></div>
						<div class="radio"><label><input type="radio" id="life" name="Discipline" value="Life Sciences" onclick="showBranches()">Life Sciences</label></div>
						<div class="radio"><label><input type="radio" id="medi" name="Discipline" value="Medicine" onclick="showBranches()">Medicine</label></div>
						<div class="radio"><label><input type="radio" id="phys" name="Discipline" value="Physical Sciences" onclick="showBranches()">Physical Sciences</label></div>
						<div class="radio"><label><input type="radio" id="soci" name="Discipline" value="Social Sciences" onclick="showBranches('socsci')">Social Sciences</label></div>
						<div class="radio"><label><input type="radio" id="othe1" name="Discipline" value="Other" onclick="showBranches()">Other:</label><input type="text" id="otherprof" name="otherprof" style="width:130px" maxlength="120"></div>
				</div>	
				
				<div class="form-group" id="Economics" style="margin-left:20px;margin-right:20px;display:none">
					<b>1b. Which branch of Economics are you working in?</b>
						<div class="radio"><label><input type="radio" id="busin" name="Econ-Discipline" value="Business Studies">Business Studies</label></div>
						<div class="radio"><label><input type="radio" id="econo" name="Econ-Discipline" value="Economics">Economics</label></div>
						<div class="radio"><label><input type="radio" id="othe2" name="Econ-Discipline" value="Other">Other:</label><input type="text" id="othereconprof" name="othereconprof" style="width:130px" maxlength="120"></div>
				</div>	
				
				<div class="form-group" id="Social Sciences" style="margin-left:20px;margin-right:20px;display:none">
					<b>1b. Which branch of Social Sciences are you working in?</b>
						<div class="radio"><label><input type="radio" id="demog" name="SocSci-Discipline" value="Demography">Demography</label></div>
						<div class="radio"><label><input type="radio" id="human" name="SocSci-Discipline" value="Human Geography">Human Geography</label></div>
						<div class="radio"><label><input type="radio" id="polit" name="SocSci-Discipline" value="Political Sciences">Political Sciences</label></div>
						<div class="radio"><label><input type="radio" id="psych" name="SocSci-Discipline" value="Psychology">Psychology</label></div>
						<div class="radio"><label><input type="radio" id="socio" name="SocSci-Discipline" value="Sociology">Sociology</label></div>
						<div class="radio"><label><input type="radio" id="othe3" name="SocSci-Discipline" value="Other">Other:</label><input type="text" id="othersocsciprof" name="othersocsciprof" style="width:130px" maxlength="120"></div>
				</div>	
				
				<div class="form-group" style="margin-left:20px;margin-right:20px">
					<b>2. What is your current research role?*</b>
						<div class="radio"><label><input type="radio" id="prof" name="Role" value="Professor">Professor</label></div>
						<div class="radio"><label><input type="radio" id="assopro" name="Role" value="Associate professor">Associate professor</label></div>
						<div class="radio"><label><input type="radio" id="assipro" name="Role" value="Assistant professor">Assistant professor</label></div>
						<div class="radio"><label><input type="radio" id="post" name="Role" value="Postdoc/Senior Researcher">Postdoc/Senior Researcher</label></div>
						<div class="radio"><label><input type="radio" id="raph" name="Role" value="Research assistant + PhD student">Research assistant + PhD student</label></div>
						<div class="radio"><label><input type="radio" id="reas" name="Role" value="Research assistant">Research assistant</label></div>
						<div class="radio"><label><input type="radio" id="phds" name="Role" value="PhD student">PhD student</label></div>
						<div class="radio"><label><input type="radio" id="stud" name="Role" value="Student/Student assistant">Student/Student assistant</label></div>
						<div class="radio"><label><input type="radio" id="othe4" name="Role" value="Other">Other:</label><input type="text" id="otherrole" name="otherrole" style="width:130px" maxlength="120"></div>
				</div>	
				
				<div class="form-group" style="margin-left:20px;margin-right:20px">
					<b>3. Which of the following categories does your current workplace belong to?*</b>
						<div class="radio"><label><input type="radio" id="high" name="Workplace" value="Higher education">Higher education</label></div>
						<div class="radio"><label><input type="radio" id="publ" name="Workplace" value="Publicly funded research institution">Publicly funded research institution</label></div>
						<div class="radio"><label><input type="radio" id="priv" name="Workplace" value="Privately funded research institution">Privately funded research institution</label></div>
						<div class="radio"><label><input type="radio" id="gove" name="Workplace" value="Government">Government</label></div>
						<div class="radio"><label><input type="radio" id="indu" name="Workplace" value="Industry/RnD">Industry/R'n'D</label></div>
						<div class="radio"><label><input type="radio" id="othe5" name="Workplace" value="Other">Other:</label><input type="text" id="otherworkplace" name="otherworkplace" style="width:130px" maxlength="120"></div>
				</div>

				<div class="form-group" style="margin-left:20px;margin-right:20px">
				<p>
				<b>4. When doing literature research, how do you usually determine which search results to read first? Are there publication features you are looking out for?</b></p>
				<textarea rows="6" cols="80" maxlength="1000" style="margin-left:20px" name="Otherfeatures"><?php foreach($result as $row) {if(isset($row['Features'])) { echo $row['Features'];}}?></textarea>				
				</div>
				<br>
					<hr style="background-color:rgb(42,49,98);height:1px;border:0px;border-radius:10px">	
					<div style="width:210px;margin-left:auto;margin-right:auto;margin-bottom:10px">
						<a class="startbutton" href="p0.php" style="float:left;text-align:center;padding:5px 0px 0px 0px;height:26px">Back</a>
						<button class="startbutton" type="submit" value="Submit" id="start" style="float:right">Continue</button>
					</div>
			</form>	
			<br><br>
		</div>
	</div>
	<script>
	$("#Discipline").on("change", function() {
		$("#" + $(this).val()).show().siblings().hide();
	})
	
	function showBranches(y) {
		if (y === "econ") {
			var x = document.getElementById("Economics");
			if (x.style.display === "none") {
				x.style.display = "block";
			} 
			var x = document.getElementById("Social Sciences");
			x.style.display = "none";
		} else if (y === "socsci") {
			var x = document.getElementById("Social Sciences");
			if (x.style.display === "none") {
				x.style.display = "block";
			} 
			var x = document.getElementById("Economics");
			x.style.display = "none";
		} else {
			var x = document.getElementById("Economics");
			x.style.display = "none";
			var x = document.getElementById("Social Sciences");
			x.style.display = "none";
		}
	}
	
	function validate(form) {

		// validation code here ...
		var x = $("input[name='Discipline']:checked").val(); 
		if (x == null || x == "") {
			alert("Please choose a discipline.");
			return false;
		}
		var x = $("input[name='Role']:checked").val(); 
		if (x == null || x == "") {
			alert("Please choose a research role.");
			return false;
		}
		var x = $("input[name='Workplace']:checked").val(); 
		if (x == null || x == "") {
			alert("Please choose a type of workplace.");
			return false;
		}
	}
	</script>
	</body>
</html>
