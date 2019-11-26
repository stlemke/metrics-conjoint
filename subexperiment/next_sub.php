<?php
session_start();
include('../db/connectdb.php');
include('../publication.php');
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

	$sql = "SELECT PubIDs_Order_Chosen FROM sub_choices WHERE Respondent_ID = '".$respondent."'";
	$result = $conn->query($sql);
	$result_new = TRUE;
	foreach($result as $row) {
		if ($row['PubIDs_Order_Chosen'] == $rankingOrder) { $result_new = FALSE;}
	}
	if($result_new) {	

		$sql = "INSERT INTO sub_choices (Respondent_ID, PubIDs_Order_Displayed, PubIDs_Order_Chosen, Timestamp)
			VALUES ('".$respondent."','".$displayOrder."','".$rankingOrder."','".$dtstring."')";
			$conn->exec($sql);
		
		$_SESSION['bonusTasksSolved']++;
	}
}

if(isset($_SESSION['bonusTasksSolved'])) {
	$remainingTasks = $_SESSION['bonusTaskNumber']-$_SESSION['bonusTasksSolved'];
	if ($remainingTasks == 1) {
		$_SESSION['finalBonusTask'] = TRUE;
	}
} else {
	$_SESSION['bonusTasksSolved'] = 0; 
}
?>

<!DOCTYPE html>
<html lang="en">

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
	<link rel="stylesheet" href="../js/jquery-ui-1.12.1.custom/jquery-ui.min.css">
	<script src="../js/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
	
	<script>
		$(function() {
			$("#sortable").sortable({
				//handle: '.publication',
				containment: '#outerbox',
				connectWith: '#sortable2'
			}).disableSelection();
			$("#sortable2").sortable({
				//handle: '.publication',
				containment: '#outerbox',
				connectWith: '#sortable'
			}).disableSelection();
		});
	</script>
  </head>

	<body>
	<div class="container-fluid">
		<div class="maincontainer" style="min-width:804px">
			<?php include('header_sub.php');?>
			<hr style="background-color:rgb(42,49,98);height:1px;border:0px;border-radius:10px;margin-top:10px">
			<div class="progress">
				<?php
				$portion = round(80/$_SESSION['bonusTaskNumber']);
				$progress = 10+$portion*$_SESSION['bonusTasksSolved'];
				echo "<div class='progress-bar progress-bar-striped' role='progressbar' aria-valuenow='1' aria-valuemin='0' aria-valuemax='100' style='width:".$progress."%'>";
				echo $progress."%";
				?>
				</div>
			</div>
			<form action="<?php if($_SESSION['finalBonusTask']){echo 'p1p5_sub.php';}else{echo 'next_sub.php';} ?>"  method="POST" name="startform" style="width:100%;font-size:13px" onsubmit="return validate(this);">
				<p>
				Please continue the experiment by ranking the following publications:<br></p>
				<center><b>You are doing literature research for a topic you are not yet familiar with. <br>Your query in the scholarly search engine of your choice reveals 3 potentially relevant publications alongside their impact metrics, visualized as Altmetric badges.<br> The colors of an Altmetric badge signalize the kinds of resonance the article received so far<?php if($_SESSION['withnumbers']) { echo ", the score in its center aggregates its overall volume";} ?>. <br>After your ranking the publication you would read first should be at the top of the list, the publication you would read last at the bottom.</b><br><br></center>
				<div id="outerbox" style="width:100%;height:436px">
				<table style="margin-left:auto;margin-right:auto"><tr><td style="padding:0px;width:400px">
				<?php
					$displayOrder = array();
					$publicationIDs = array();
					$choice_set_id = $_SESSION['bonusTasksSolved']+1;
					$sql = "SELECT * FROM choice_sets WHERE ID =  '".$choice_set_id."'";
					$result = $conn->query($sql);
					
					foreach($result as $row) {
						$publicationIDs[] = $row['Publication1'];
						$publicationIDs[] = $row['Publication2'];
						$publicationIDs[] = $row['Publication3'];
					}
					$i = 0;
					
					echo "<ul id='sortable'  style='height:408px;padding:1px;margin-top:1px;margin-bottom:1px'>";
					if($_SESSION['randomPubOrder']) {
						shuffle($publicationIDs);
					}
					foreach($publicationIDs as $pid) {
						renderPublicationByID_sub($pid, $_SESSION['indicators'], $i, $conn, $_SESSION['withnumbers']);
						$i++;
						$displayOrder[] = $pid;
					}
					echo "</ul>";
				?>
					</td><td style="padding:0px;width:400px;background-image:url(../img/frame3.png);background-repeat:no-repeat;background-size:400px 410px;">
    				<ul id='sortable2' style="height:408px;padding:4px;margin-top:1px;margin-bottom:1px">
					</ul></td></tr></table>
				</div>
				<p>When you are satisfied with your decision, please click 'Continue' to go on to the next task. Please be aware that you won't be able to change previous inputs at a later stage.</p>
					<hr style="background-color:rgb(42,49,98);height:1px;border:0px;border-radius:10px">	
					<div style="width:210px;margin-left:auto;margin-right:auto;margin-bottom:10px">
						<button class="startbutton" type="submit" value="Submit" id="start" style="float:right">Continue</button>
					</div>
					<div id="display-order" style="display: none;">
						<?php
							$output = "";
							foreach($displayOrder as $item) {
								if($output == "") {
									$output = $item;
								} else {
									$output = $output.", ".$item;
								}
							}
							$output = preg_replace('/\s+/', '', $output);
							echo htmlspecialchars($output);
						?>
					</div>
					<button type="button" class="deletebutton" onclick="exit()" style="float:left;margin-left:10px">Exit and clear data</button>
			</form>	
			<br><br>
		</div>
	</div>
	<script>	
	function validate(form) {
		var idsInOrder = $("#sortable2").sortable("toArray");
		var div = document.getElementById("display-order");
		var idsAsShown = div.textContent;
		var arrayLength = idsInOrder.length;
		if (arrayLength != 3) {
			alert("Please rank all publications by dragging them to the area on the right in the order of your preference.");
			return false;
		} else {
			myvar = document.createElement('input');
			myvar.setAttribute('name', 'post-ranking');
			myvar.setAttribute('type', 'hidden');
			myvar.setAttribute('value', idsInOrder);
			form.appendChild(myvar);
			myvar2 = document.createElement('input');
			myvar2.setAttribute('name', 'post-display');
			myvar2.setAttribute('type', 'hidden');
			myvar2.setAttribute('value', idsAsShown);
			form.appendChild(myvar2);
			return true;
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
