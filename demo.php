<?php
session_start();
include('db/connectdb.php');
include('publication.php');
$session_id = session_id();

$sql = "SELECT * FROM respondents WHERE Session_ID = '".$session_id."'";
$result = $conn->query($sql);
if($result->rowCount() > 0) {
} else {
	header("Location: ".$_SESSION['root_dir']."index.php");
	die();
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
	<link rel="stylesheet" href="js/jquery-ui-1.12.1.custom/jquery-ui.min.css">
	<script src="js/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
	
	<script>
		$(function() {
			$("#sortable").sortable({
				containment: '#outerbox',
				connectWith: '#sortable2'
			}).disableSelection();
			$("#sortable2").sortable({
				containment: '#outerbox',
				connectWith: '#sortable'
			}).disableSelection();
		});
	</script>
  </head>

	<body>
		<div class="maincontainer" style="min-width:804px">
			<?php include('header.php');?>
			<hr style="background-color:rgb(42,49,98);height:1px;border:0px;border-radius:10px;margin-top:10px">
			<div class="progress">
				<div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width:8%">
				  8%
				</div>
			</div>
			<form action="nexttask.php"  method="POST" name="startform" style="width:100%;font-size:13px" onsubmit="return validate(this);">
				<!--h3>How to Participate (2/2)</h3-->
				<p>
				During the experiment, please imagine the following situation:<br></p>
				<center><b>You are doing literature research for a topic you are not yet familiar with. <br>Your query in the scholarly search engine of your choice reveals 3 potentially relevant publications alongside their impact metrics.<br>Please rank those publications in the order in which you would read them by dragging them to the area on the right.</b> <br>The publication you would read first should afterwards be at the top of the list, the publication you would read last at the bottom.<br></center>
				<div id="outerbox" style="width:100%;height:436px">
				<table style="margin-left:auto;margin-right:auto"><tr><td style="padding:0px;width:400px">
				<?php
					//ADOPTION OF BASIC SETTINGS
					$sql = "UPDATE respondents SET Indicatorset = '".$_SESSION['indicatorset']."' WHERE Session_ID = '".$session_id."'";
					$conn->exec($sql);

					$displayOrder = array();
					$publicationIDs = array();
					$publicationIDs[] = 518;
					$publicationIDs[] = 627;
					$publicationIDs[] = 323;
					$i = 0;
					
					//Create these three publications for demo purposes
					echo "<ul id='sortable'  style='height:408px;padding:1px;margin-top:1px;margin-bottom:1px'>";
					if($_SESSION['randomPubOrder']) {
						shuffle($publicationIDs);
					}
					foreach($publicationIDs as $pid) {
						renderPublicationByID($pid, $_SESSION['indicators'], $i, $conn);
						$i++;
						$displayOrder[] = $pid;
					}
					echo "</ul>";
				?>
					</td><td style="padding:0px;width:400px;background-image:url(img/frame3.png);background-repeat:no-repeat;background-size:400px 410px;">
    				<ul id='sortable2' style="height:408px;padding:4px;margin-top:1px;margin-bottom:1px">
					</ul></td></tr></table>
				</div>
				<p>When you are satisfied with your decision, please click 'Continue' to go on with the actual experiment.</p>
					<hr style="background-color:rgb(42,49,98);height:1px;border:0px;border-radius:10px">	
					<div style="width:210px;margin-left:auto;margin-right:auto;margin-bottom:10px">
						<a class="startbutton" href="explanation.php" style="float:left;text-align:center;padding:5px 0px 0px 0px;height:26px">Back</a>
						<button class="startbutton" type="submit" value="Submit" id="start" style="float:right">Continue</button>
					</div>
					<!--Invisible Div-Element for saving the displayed order:-->
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
	<script>	
	function validate(form) {
		var idsInOrder = $("#sortable2").sortable("toArray");
		var div = document.getElementById("display-order");
		var idsAsShown = div.textContent;
		var arrayLength = idsInOrder.length;
		if (arrayLength != 3) {
			alert("Please rank all publications by dragging them to the area on the right in the order of your preference.");
			return false;
		}

		var parameters = {
		  "ranking[]": idsInOrder,
		  "display[]": idsAsShown,
		};

		$.post(
		  'task.php',
		  parameters
		)
		.done(function(data, statusText) {
			// This block is optional, fires when the ajax call is complete
		});
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
