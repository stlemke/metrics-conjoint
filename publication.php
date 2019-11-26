<?php
include('db/connectdb.php');

function getPublicationByID($id, $conn) {
	$sql = "SELECT * FROM publications WHERE Publication_ID = '".$id."'";
	$result = $conn->query($sql);
	if($result->rowCount() > 0) {
		return $result;
	} else {
		return "No publication found for given ID.";
	}
}

function renderPublicationByID($id, $indicators, $i, $conn) {
	$sql = "SELECT * FROM publications WHERE Publication_ID = '".$id."'";
	$result = $conn->query($sql);
	
	//Write publication to array
	$pub = array();
	foreach($result as $row) {
		$pub = $row;
	}
	
	//Show publication with chosen indicators
	$alphabet = ["A","B","C","D","E","F","G"];
	echo "<div id='".$id."' class='ui-widget-content' style='width:390px;font-size:11px'><table style='max-width:500px;height:110px;border:1px solid black;border-radius:20px'><col width='20%'><col width='80%'><tr>
		<td style='padding-left:5px;padding-top:5px'><b>Publication ".$alphabet[$i]."</b><img src='img/pub".$alphabet[$i].".png' alt='publication' height='90px' style='margin:5px 20px 15px 20px'></td>
		<td><table class='cart'><col width='20%'><col width='60%'><col width='20%'>";
	foreach($indicators as $ind) {
		$sql = "SELECT * FROM indicators WHERE Indicator_ID = '".$ind."'";
		$result = $conn->query($sql);
		foreach($result as $row) {
			echo "<tr>";
			//Version without tooltips: echo "<td><img src='".$row['Image_Link']."' alt='logo' width='18px' style='margin-left:8px;margin-right:8px'</td><td style='padding-left:8px;padding-right:8px'>".$row['Indicator_Name']."</td><td style='padding-left:8px;padding-right:8px'>";
			echo "<td><div class='hasTooltip' style='width:20px'><img src='".$row['Image_Link']."' alt='logo' width='18px' style='margin-left:8px;margin-right:8px'><span>".$row['Description']."</span></div></td><td style='padding-left:8px;padding-right:8px'>".$row['Indicator_Name']."</td><td style='padding-left:8px;padding-right:8px'>";
			echo $row['Level'.$pub[$row['Indicator_ID']]]."</td>";
			echo "</tr>";
		}
	}
	echo "</table></td></tr></table></div>";
}

function renderPublicationByID_Demo($id, $indicators, $i, $conn) {
	$sql = "SELECT * FROM publications WHERE Publication_ID = '".$id."'";
	$result = $conn->query($sql);
	
	//Write publication to array
	$pub = array();
	foreach($result as $row) {
		$pub = $row;
	}
	
	//Show publication with chosen indicators
	$alphabet = ["A","B","C","D","E","F","G"];
	echo "<div id='".$id."' class='ui-widget-content' style='width:390px;font-size:11px'><table style='max-width:500px;height:110px;border:1px solid black;border-radius:20px'><col width='20%'><col width='80%'><tr>
		<td style='padding-left:5px;padding-top:5px'><b>Publication ".$alphabet[$i]."</b><img src='img/pub".$alphabet[$i].".png' alt='publication' height='90px' style='margin:5px 20px 15px 20px'></td>
		<td><table style='width:100%'><col width='20%'><col width='60%'><col width='20%'>";
	foreach($indicators as $ind) {
		$sql = "SELECT * FROM indicators WHERE Indicator_ID = '".$ind."'";
		$result = $conn->query($sql);
		foreach($result as $row) {
			echo "<tr>";
			echo "<td><img src='".$row['Image_Link']."' alt='logo' width='18px' style='margin-left:8px;margin-right:8px'></td><td style='padding-left:8px;padding-right:8px'>".$row['Indicator_Name']."</td><td style='padding-left:8px;padding-right:8px'>";
			echo $pub[$row['Indicator_ID']]."</td>";
			echo "</tr>";
		}
	}
	echo "</table></td></tr></table></div>";
}

function createIndicatorSetForSession($indicatorset, $randomize) {
	//Create set of included indicators
	$indicatorset = str_split($indicatorset);
	$i = 0;
	$indicators = array();
	$indicators[] = "Citations_(GS)";
	$indicators[] = "Facebook_Mentions";
	$indicators[] = "Tweets";
	$indicators[] = "Mendeley_Readers";
	$indicators[] = "EconStor_Downloads";
	$indicators[] = "JIF";
	$indicators[] = "PLoS_Views";
	$indicators[] = "Altmetric_Score";
	$indicators[] = "ResearchGate_Score";
	$indicators[] = "H_Index";
	foreach ($indicatorset as $char) {
		if($char=="0") {
			unset($indicators[$i]);
		}
		$i++;
	}
	if($randomize == TRUE) {
		shuffle($indicators);
	}
	$_SESSION['indicators'] = $indicators;
}

function renderPublicationByID_sub($id, $indicators, $i, $conn, $withnumbers) {
	$sql = "SELECT * FROM publications WHERE Publication_ID = '".$id."'";
	$result = $conn->query($sql);
	
	//Write publication to array
	$pub = array();
	foreach($result as $row) {
		$pub = $row;
	}
	
	//Show publication with chosen indicators
	$alphabet = ["A","B","C","D","E","F","G"];
	$n = "";
	if($withnumbers) { 
		$n = "n";
	}
	echo "<div id='".$id."' class='ui-widget-content' style='width:390px;font-size:11px'><table style='max-width:500px;height:110px;border:1px solid black;border-radius:20px'><col width='20%'><col width='80%'><tr>
		<td style='padding-left:5px;padding-top:5px'><b>Publication ".$alphabet[$i]."</b><img src='../img/pub".$alphabet[$i].".png' alt='publication' height='90px' style='margin:5px 20px 15px 20px'></td>
		<td><img src='donuts/".$id.$n.".png' alt='altmetric-badge' height='98px' style='margin:5px'></td></tr></table></div>";
}

?>
