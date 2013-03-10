<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>	
	<HEAD>
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
		<style type="text/css">
			body{font-family: Calibri, Candara, Segoe, "Segoe UI", Optima, Arial, sans-serif;}
		</style>
		<LINK REL=STYLESHEET HREF="design.css" TYPE="text/CSS">
		<TITLE>CMPUT410 Assignment 3 - Results Page</TITLE>	
		<script language="JavaScript" src="functions.js" ></script>
	
	</HEAD>
	
	<BODY>
		
		
		<table class="shadow" border="0" cellpadding="2" cellspacing="0" width="900px" align="center">					
		<tr>
			<td class="left"> 
				<div id="alert" class="hidden">Please <a href="index.php">register or login</a> before taking the quiz.</div>
				
				<div id="all" class="default">		
					
					<div class="extra-pad">
						<h2><?= $_COOKIE['name']?>'s results</h2>
						
						<?php
						include 'phpfuncs.php';	
						
						$sum = 0;
						for($i = 1; $i < 4; $i++){
							//vars to submit to db
							$username = $_COOKIE['name'];			//name of user that answered question
							$answer = $_POST['q'.$i];				//user's answer to q $i
							$correct = $_COOKIE['q'.$i.'correct'];	//correct asnwer to q $i
							$qid = $_COOKIE['q'.$i.'id'];			//id of q $i
							$hints = $_POST['q'.$i.'hintcount'];	//hint count of q $i
							$timer = $_POST['timer'.$i.'val'];		//timer of q $i
							$stem = $_COOKIE['q'.$i.'stem'];		//stem for q $i
							$score = 0;								//users score for q $i
							
							$skill = $_COOKIE['q'.$i.'skill'];
							
							$prefix = "";
							
							if ($answer == $correct){
								$sum++;
								$score = 1;
							} else {
								$prefix = "in";
							}
							
							echo "<div id=\"q".$i."result\" class=\"".$prefix."correct\">Q".$i.": ".$prefix."correct, " . secsToFormat($timer) ."</div>";
							
							//submit data to db
							$con = openCon();
							
							$query =   "INSERT INTO `a5039311_assign3`.`Submission` VALUES (null, '" . $username . "', '" . $qid . "', '" . $score . "', '" . $timer . "', '" . $hints . "', '" . $stem . "', '" . $answer . "','" . $skill . "')";
							$result = mysql_query($query) or die(" Query failed ");
							
							closeCon($con);
						}
						
						$score = floor($sum/3 * 10000) / 100 . "%";
						echo "<div id='scoreTime'>Total Score: ".$score."<br>Time Taken: ". secsToFormat($_POST['totalTimer']) ."</div>";
						?>
						
						<div id="q1result" class="correct"></div>
						<div id="q2result" class="correct"></div>
						<div id="q3result" class="incorrect"></div><br>
					
					</div>
				
				</div>	
				
			</td>
			
			<!-- RIGHT (nav) section -->
			<td class="right">
			
				<div id="nav">
					<br>
					<button id="bHome" onClick="window.location.href='welcome.php'"> Home </button> 
						
				</div>
			
			</td>
			
		</tr>	
		
		</table>

		
		<script language="Javascript">
		// if user hasn't reigstered, dont show quiz
			if (getCookie("name") == null || getCookie("name") == "") {
				document.getElementById("all").className="hidden";
				document.getElementById("nav").className="hidden";
				document.getElementById("alert").className="default";
			}
		</script>
	</BODY>
</HTML>

