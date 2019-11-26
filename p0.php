<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>*metrics Study on User Perceptions</title>
    <link rel="stylesheet" href="css/style.css">
	<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
  </head>

	<body>
		<div class="maincontainer">
			<?php include('header.php');?>
			<hr style="background-color:rgb(42,49,98);height:1px;border:0px;border-radius:10px;margin-top:10px">
			<div style="margin:12px;margin-top:24px">
				
				
				<div style="border:1px solid black;background-color:rgb(230,230,230);padding:12px;margin-top:12px;margin-bottom:12px">
				<div style="margin-left:0px;font-size:16px"><b>How we handle your data:</b></div>
				<p>All data acquisition in this experiment is done solely for scientific purposes. Answers will be coded anonymously and treated confidentially. 
				Your participation in this experiment is entirely voluntary and you can withdraw from the experiment at any time.<br>
				Data gathered during the experiment will be stored on servers maintained by the University of Kiel in Germany.
				In case you provide us with an email address, it will be stored separately from experimental data and will only be used by us to communicate with you regarding your participation in this experiment.<br>
				To support the Open science movement, the anonymized experimental data will be published on <a href="https://zenodo.org/">Zenodo</a> (which is an open access repository maintained by CERN) so that the scientific community can benefit from it.</p>
				</div>
				<div style="margin-left:0px;font-size:16px"><b>Reward</b></div>
				<p>As a small thank-you for their help, 15 randomly drawn participants will be awarded with a 30€-voucher for Amazon each. To partake in the drawing, all you have to do is to provide us with a valid email address on the last page of this experiment and indicate your willingness to participate by selecting the according checkbox there. At the end of this main experiment you will be given the option to participate in a related, ~5 minute long bonus experiment - by completing that bonus experiment you can earn a second lot for the drawing.</p>
				<div style="margin-left:0px;font-size:16px"><b>Who we are</b></div>
				<p>This experiment is part of the DFG-funded research project <a target="_blank" href="https://metrics-project.net/"><i>*metrics</i></a>, which aims at enabling a better understanding of the manifold metrics used for measuring scientific impact (e.g., citations, usage metrics or altmetrics). 
				We are researchers of the Web Science department at <a target="_blank" href="https://www.zbw.eu/">ZBW - Leibniz Information Centre for Economics</a>. 
				ZBW provides the world's largest research infrastructure for economic literature and conducts research related to the subjects of Science 2.0/Open Science.</p>
				<p>
				<b>Notice: </b>This site uses Javascript for experimental tasks. In case you deactivated Javascript on your machine, please activate it for this site - otherwise you will not be able to participate. Also, we use cookies to process your inputs - by starting the experiment you agree to their usage.
				<br><br><br></p>
			</div>
			<hr style="background-color:rgb(42,49,98);height:1px;border:0px;border-radius:10px">
			<form action="p1.php"  method="POST" name="startform" style="width:100" onsubmit="return validate(this);">
				<div style="margin-left:auto;margin-right:auto;width: 600px;margin-bottom:10px;font-size:13px">
				<label>
				  <input type="checkbox" class="agreement-checkbox" name="agreement-checkbox" value="agree">
				  I read the information given above and agree with my inputs being handled as explained.
				</label>
				</div>
					<div style="width:210px;margin-left:auto;margin-right:auto;margin-bottom:10px">
						<a class="startbutton" href="index.php" style="height:21px;float:left;text-align:center;padding:5px 0px 0px 0px">Back</a>
						<button class="startbutton" type="submit" value="Submit" id="start" style="float:right">Start</button>
					</div>
			</form>	
		</div>
	
	<script>
	
	function validate(form) {
		
		var checkedValue = null; 
			var inputElements = document.getElementsByClassName('agreement-checkbox');
			for(var i=0; inputElements[i]; ++i){
				  if(inputElements[i].checked){
					   checkedValue = inputElements[i].value;
					   break;
				  }
			}
		if (checkedValue != "agree") {
			alert("To be able to start with the experiment, please indicate that you read and agree to our data policy by clicking the checkbox above this button.");
			return false;
		}
	}
	</script>
	</body>
</html>
