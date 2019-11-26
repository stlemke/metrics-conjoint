<?php
session_start();
include('db/connectdb.php');

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

	$sql = "INSERT INTO choices (Respondent_ID, PubIDs_Order_Displayed, PubIDs_Order_Chosen, Timestamp)
		VALUES ('".$respondent."','".$displayOrder."','".$rankingOrder."','".$dtstring."')";
		$conn->exec($sql);
		
	$_SESSION['tasksSolved']++;
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
				<div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width:90%">
				  90%
				</div>
			</div>
			<form action="p2.php"  method="POST" name="startform" style="width:100%" onsubmit="return validate(this);">
				<h3>Additional Comments</h3>
				<p>
				<?php
				$sql = "SELECT * FROM respondents WHERE Session_ID = '".$session_id."'";
				$result = $conn->query($sql);
				$prevAnswer = "";
				$prevOtherFeatures = "";
				$prevComments = "";
				$prevFavIndicator = "";
				foreach($result as $row) {
					if(isset($row['Features'])) {
						$prevAnswer = $row['Features'];
					}
					if(isset($row['Other_Features'])) {
						$prevOtherFeatures = $row['Other_Features'];
					}
					if(isset($row['Comments'])) {
						$prevComments = $row['Comments'];
					}
					if(isset($row['FavIndicator'])) {
						$prevFavIndicator = $row['FavIndicator'];
					}
				}
				echo "<b>In the beginning of the experiment we asked you <i>'When doing literature research, how do you usually determine which search results to read first? Are there publication features you are looking out for?'.</i><br>You gave us the following answer:</b></p>";
				if($prevAnswer != "") {
					echo "<blockquote style='margin-left:20px;font-size:13px'>".$prevAnswer."</blockquote>";
				} else {
					echo "<blockquote style='margin-left:20px;font-size:13px'>-You previously did not provide an answer.-</blockquote>";
				}
				echo "<p><b>Now after having finished the experiment, would you like to add anything to your previous answer?</b></p>";
				echo "<textarea rows='4' cols='80' maxlength='1000' style='margin-left:20px' name='otherfeatures'>".$prevOtherFeatures."</textarea><br><br>";
				$indlist = array();
				foreach($_SESSION['indicators'] as $ind) {
					$sql = "SELECT * FROM indicators WHERE Indicator_ID = '".$ind."'";
					$result = $conn->query($sql);
					foreach($result as $row) {
						$indlist[] = $row['Indicator_Name'];
					}
				}
				asort($indlist);
				?>				
				<p><b>If you had to choose between the metrics that were presented to you during the previous tasks, which one do you consider most helpful as a tool for deciding which publications to read?*</b>
					<br><select class="form-control" id="sel1" name="FavIndicator" style="width:160px;margin-left:20px">
						<option></option>
						<?php
							foreach($indlist as $ind){
								echo "<option";
								if($ind==$prevFavIndicator) { 
									echo " selected='selected'";
									} else {}
								echo ">".$ind."</option>";
							}
						?>
					</select>
				<br>				
				</p>
				<p>
				<b>Do you have any other comments on the experiment you just participated in?</b></p>
				<textarea rows="4" cols="80" maxlength="1000" style="margin-left:20px" name="comments"><?php echo $prevComments;?></textarea><br><br>
				<hr style="background-color:rgb(42,49,98);height:1px;border:0px;border-radius:10px">
				<div style="width:210px;margin-left:auto;margin-right:auto;margin-bottom:10px">
						<button class="startbutton" type="submit" value="Submit" id="start" style="float:right">Continue</button>
					</div>
					<button type="button" class="deletebutton" onclick="exit()" style="float:left;margin-left:10px">Exit and clear data</button>
			</form>	
		</div>
		
		
		
	<script>
	function validate(form) {

		// validation code here ...
		var x = $("select[name='FavIndicator'] option:selected").val(); 
		if (x == null || x == "") {
			alert("Please answer the question above by selecting an indicator that you consider to be most helpful for deciding which publications to read.");
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
