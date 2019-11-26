<?php
session_start();
include('../db/connectdb.php');
include('../publication.php');
//PROCESSING INPUTS FROM DEMO PAGE:
$session_id = session_id();

$sql = "SELECT Respondent_ID FROM respondents WHERE Session_ID = '".$session_id."'";
$result = $conn->query($sql);
foreach($result as $row) {
	$respondent = $row['Respondent_ID'];
}
foreach($_POST['display'] as $item) {
	$displayOrder = $item;
}
$rankingOrder = "";
if(isset($_POST['ranking'])) {
	foreach($_POST['ranking'] as $item) {
		if(is_numeric($item)) {
			if($rankingOrder == "") {
				$rankingOrder = $item;
			} else {
				$rankingOrder = $rankingOrder.",".$item;
			}
		}
	}
}
if(isset($_POST['choice'])) {
	$rankingOrder = $_POST['choice'][0];
}

$dt = new DateTime();
$dtstring = $dt->format('Y-m-d H:i:s');

$sql = "INSERT INTO sub_choices (Respondent_ID, PubIDs_Order_Displayed, PubIDs_Order_Chosen, Timestamp)
	VALUES ('".$respondent."','".$displayOrder."','".$rankingOrder."','".$dtstring."')";
	$conn->exec($sql);
	
$_SESSION['bonusTasksSolved']++;
?>