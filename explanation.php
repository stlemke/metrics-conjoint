<?php
session_start();
include('db/connectdb.php');
include('publication.php');

//-DEFINITION OF BASIC SESSION-VARIABLES-
//WHICH INDICATORS TO SHOW TO THIS USER? 1=SHOW, 0=OMIT
$_SESSION['indicatorset'] = "1011110001";
//RANDOMIZE PUBLICATION ORDER?
$_SESSION['randomPubOrder'] = TRUE;
//HOW MANY TASKS PER USER?
$_SESSION['taskNumber'] = 20;
//SET ROOT DIRECTORY OF THIS EXPERIMENT:
$_SESSION['root_dir'] = "http://metrics-crawl03.zbw.uni-kiel.de/";


$_SESSION['finalTask'] = FALSE;
unset($_SESSION['tasksSolved']);
//PROCESSING USER INPUT FROM P1
$session_id = session_id();

$sql = "SELECT * FROM respondents WHERE Session_ID = '".$session_id."'";
$result = $conn->query($sql);

if($result->rowCount() > 0) {
	if(isset($_POST['Discipline'])) {
		if($_POST['Discipline']=="Other") {
			$_POST['Discipline'] = "Other: ".$_POST['otherprof'];
		}
		$statement = $conn->prepare("UPDATE respondents SET Discipline = :discipline WHERE Session_ID = :sessionid");
		$statement->execute(array('discipline' => $_POST['Discipline'], 'sessionid' => $session_id));
	}
	if(isset($_POST['Econ-Discipline'])) {
		if($_POST['Econ-Discipline']=="Other") {
			$_POST['Econ-Discipline'] = "Other: ".$_POST['othereconprof'];
		}
		$statement = $conn->prepare("UPDATE respondents SET Branch_Economics = :econdiscipline WHERE Session_ID = :sessionid");
		$statement->execute(array('econdiscipline' => $_POST['Econ-Discipline'], 'sessionid' => $session_id));
	}
	if(isset($_POST['SocSci-Discipline'])) {
		if($_POST['SocSci-Discipline']=="Other") {
			$_POST['SocSci-Discipline'] = "Other: ".$_POST['othersocsciprof'];
		}
		$statement = $conn->prepare("UPDATE respondents SET Branch_SocSci = :socscidiscipline WHERE Session_ID = :sessionid");
		$statement->execute(array('socscidiscipline' => $_POST['SocSci-Discipline'], 'sessionid' => $session_id));
	}
	if(isset($_POST['Role'])) {
		if($_POST['Role']=="Other") {
			$_POST['Role'] = "Other: ".$_POST['otherrole'];
		}		
		$statement = $conn->prepare("UPDATE respondents SET Role = :role WHERE Session_ID = :sessionid");
		$statement->execute(array('role' => $_POST['Role'], 'sessionid' => $session_id));
	}
	if(isset($_POST['Workplace'])) {
		if($_POST['Workplace']=="Other") {
			$_POST['Workplace'] = "Other: ".$_POST['otherworkplace'];
		}
		$statement = $conn->prepare("UPDATE respondents SET Workplace = :workplace WHERE Session_ID = :sessionid");
		$statement->execute(array('workplace' => $_POST['Workplace'], 'sessionid' => $session_id));
	}
	if(isset($_POST['Otherfeatures'])) {
		$statement = $conn->prepare("UPDATE respondents SET Features = :features WHERE Session_ID = :sessionid");
		$statement->execute(array('features' => $_POST['Otherfeatures'], 'sessionid' => $session_id));
	}	
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
  </head>

	<body>
		<div class="maincontainer">
			<?php include('header.php');?>
			<hr style="background-color:rgb(42,49,98);height:1px;border:0px;border-radius:10px;margin-top:10px">
			<div class="progress">
				<div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100" style="width:5%">
				  5%
				</div>
			</div>
			<form action="demo.php"  method="POST" name="startform" style="width:100%;font-size:13px" onsubmit="return validate(this);">
				<h3>Explanation of terms</h3>
				<p>
				During the experiment, you will be asked to evaluate the expected relevance of some publications based on various metrics. The following table provides basic explanations of the metrics that might appear during this experiment.<br><br></p>
				<div id="outerbox" style="width:100%;height:436px">
				<?php
					createIndicatorSetForSession($_SESSION['indicatorset'], FALSE);
					$sql = "UPDATE respondents SET Indicatorset = '".$_SESSION['indicatorset']."' WHERE Session_ID = '".$session_id."'";
					$conn->exec($sql);
					
					//Title row of explanations table:
					echo "<table style='margin-left:40px;margin-right:40px'><col width='3%'><col width='13%'><col width='84%'><tr style='border:1px solid grey;background-color:lightgrey'><td align='center'></td><td align='center'><b>Indicator</b></td><td align='center' style='border:1px solid grey'><b>Description</b></td></tr>";
					//Explanation texts for indicators:
					$explanations = array();
					$explanations['Citations_(GS)'] = "The citation count measures the number of publications that contain a reference to the respective target publication. It is a comparably traditional metric for research impact and the basis of various further metrics, e.g., the Journal Impact Factor or the h-index. Several citation indexes exist which can be used to calculate a publications' citation count, prominent examples being those of <i>Scopus</i>, <i>Web of Science</i> and <i>Google Scholar</i>. <a href='http://www.metrics-toolkit.org/citations-articles/' target='_blank'>Link to additional information from the Metrics Toolkit.</a>";
					$explanations['Facebook_Mentions'] = "Facebook mentions reflect interactions with postings of a publication on Facebook, namely Likes, comments and shares of such posts. <a href='http://www.metrics-toolkit.org/facebook-comments-likes-shares/' target='_blank'>Link to additional information from the Metrics Toolkit.</a>";
					$explanations['EconStor_Downloads'] = "The download count measures the number of times a publication has been downloaded from the respective website. Download counts for publications are typically displayed on document servers or research repositories (e.g., <i>EconStor</i> or <i>PLoS</i>). <a href='http://www.metrics-toolkit.org/downloads-articles/' target='_blank'>Link to additional information from the Metrics Toolkit.</a>";
					$explanations['Mendeley_Readers'] = "<i>Mendeley</i> is a free-to-use reference manager and academic social network. The count of Mendeley readers for a publication equals the number of Mendeley users who added a link to the respective publication to their personal library. <a href='http://www.metrics-toolkit.org/mendeley-readers/' target='_blank'>Link to additional information from the Metrics Toolkit.</a>";
					$explanations['JIF'] = "The Journal Impact Factor is calculated on journal-level and a measure reflecting the annual average (mean) number of citations to recent articles published in that journal. Citations are counted for all items in the journal, though  the citations are divided by only the number of 'citable items' within the journal, as defined by the creators of the Journal Citation Report (currently Clarivate Analytics). <a href='http://www.metrics-toolkit.org/journal-impact-factor/' target='_blank'>Link to additional information from the Metrics Toolkit.</a>";
					$explanations['Tweets'] = "The tweet count reflects the number of postings mentioning a respective publication on the microblogging service Twitter. Typically this includes any tweet by a registered user that contains a traceable identifier of that publication, e.g., a DOI or a handle. <a href='http://www.metrics-toolkit.org/twitter-mentions/' target='_blank'>Link to additional information from the Metrics Toolkit.</a>";
					$explanations['H_Index'] = "The h-index is an author-level metric based on the citations to that author's publications. An h-index of x means that the respective author wrote x publications which received at least x citations each.<a href='http://www.metrics-toolkit.org/h-index/' target='_blank'>Link to additional information from the Metrics Toolkit.</a>";
					$explanations['ResearchGate_Score'] = "The ResearchGate-Score is an author-level metric based on the author's activities measured on the academic social network ResearchGate. It aggregates scores for number of publications, postings, and followers, among others. <a href='https://explore.researchgate.net/display/support/RG+Score' target='_blank'>Link to additional information from ResearchGate.net</a>";
					
					$addinfo = array();
					$addinfo['Citations_(GS)'] = "http://www.metrics-toolkit.org/citations-articles/";
					$addinfo['EconStor_Downloads'] = "http://www.metrics-toolkit.org/downloads-articles/";
					$addinfo['Mendeley_Readers'] = "http://www.metrics-toolkit.org/mendeley-readers/";
					$addinfo['JIF'] = "http://www.metrics-toolkit.org/journal-impact-factor/";
					$addinfo['Tweets'] = "http://www.metrics-toolkit.org/twitter-mentions/";
					$addinfo['H_Index'] = "http://www.metrics-toolkit.org/h-index/";
					
					//Table corpus:
					$sortedIndicators = $_SESSION['indicators'];
					asort($sortedIndicators);
					foreach($sortedIndicators as $ind) {
						$sql = "SELECT * FROM indicators WHERE Indicator_ID = '".$ind."'";
						$result1 = $conn->query($sql);
						foreach($result1 as $row1) {
							echo "<tr style='border:1px solid grey'>";
							echo "<td><img src='".$row1['Image_Link']."' alt='logo' width='18px' style='margin-left:8px;margin-right:8px'></td><td style='padding-left:8px;padding-right:8px'><b>".$row1['Indicator_Name']."</b></td><td style='border:1px solid grey;font-size:13px;padding:8px'>".$row1['Description']."<a href='".$addinfo[$row1['Indicator_ID']]."' target='_blank'> Link to additional information from the Metrics Toolkit.</a>"/*Längere Beschreibungen: $explanations[$row1['Indicator_ID']]*/."</td></tr>";
						}
					}
					
				?>
				</table>
				</div>
				<p>After you read the above table's contents, please click 'Continue' to get to the final part of the experiment's explanation.</p>
					<hr style="background-color:rgb(42,49,98);height:1px;border:0px;border-radius:10px">	
					<div style="width:210px;margin-left:auto;margin-right:auto;margin-bottom:10px">
						<a class="startbutton" href="p1.php" style="float:left;text-align:center;padding:5px 0px 0px 0px;height:26px">Back</a>
						<button class="startbutton" type="submit" value="Submit" id="start" style="float:right">Continue</button>
					</div>
					<button type="button" class="deletebutton" onclick="exit()" style="float:left;margin-left:10px;">Exit and clear data</button>
			</form>	
			<br><br>
		</div>
	<script>	
	function exit() {
		var r = confirm("Do you really want to exit the experiment and clear all your previous input? You can restart the experiment later, but you will need to start it from the beginning.");
		if (r == true) {
			window.location.replace($_SESSION['root_dir']."exit.php");
		}
	}
	</script>
	</body>
</html>
