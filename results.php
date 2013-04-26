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
		
		<!-- Add jQuery library -->
		<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>

		<!-- Add mousewheel plugin (this is optional) -->
		<script type="text/javascript" src="/lib/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>

		<!-- Add fancyBox -->
		<link rel="stylesheet" href="/lib/fancybox/source/jquery.fancybox.css?v=2.1.4" type="text/css" media="screen" />
		<script type="text/javascript" src="/lib/fancybox/source/jquery.fancybox.pack.js?v=2.1.4"></script>

		<!-- Optionally add helpers - button, thumbnail and/or media -->
		<link rel="stylesheet" href="/lib/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
		<script type="text/javascript" src="/lib/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
		<script type="text/javascript" src="/lib/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.5"></script>

		<link rel="stylesheet" href="/lib/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
		<script type="text/javascript" src="/lib/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
	
		<script>
			$(document).ready(function() {
				$(".various").fancybox({
					width		: 830,
					fitToView	: false,
					autoSize	: false,
					closeClick	: false,
					openEffect	: 'none',
					closeEffect	: 'none',
					afterLoad: function(){
						// added 50px to avoid scrollbars inside fancybox
						//this.width = ($('.fancybox-iframe').contents().find('body').width())+50;
						this.height = $('.fancybox-iframe').contents().find('#maintable').height()+20;
					}
				});
			});
				
				
		</script>
	
	</HEAD>
	
	<BODY>
		
		
		<table class="shadow" border="0" cellpadding="2" cellspacing="0" width="800px" align="center">					
		<tr>
			<td class="left"> 
				<div id="alert" class="hidden">Please <a href="index">register or login</a> before taking the quiz.</div>
				
				<div id="all" class="results">		
					
					<!--<div class="extra-pad">-->
						<h2 style="margin-left: 0px;margin-top:0px"><?= $_COOKIE['name']?>'s results</h2>
						
						<?php
						include 'phpfuncs.php';	
						$doSubmit = $_COOKIE['doSubmit'];	
						
						$con = openCon();
						
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
							
							// check user logged in
							if ($username != "" && isset($username)){
								// check results havent been submitted yet
								if (isset($doSubmit) && $doSubmit == 1){
									setcookie("doSubmit", 0);
								} else {
									$avgsec = secsToFormat(getAvgQuestionTime($qid));
									echo "<div id=\"q".$i."result\" class=\"".$prefix."correct\"><a class='various' data-fancybox-type='iframe' href='/question.php?qid=$qid&answer=$answer'>Q".$i.": ".$prefix."correct, " . secsToFormat($timer) ."</a> <span style='color:grey'>(Avg: $avgsec)</span></div><br>";
									continue;
								}
								
								//submit data to db
								
								$query =   "INSERT INTO `a5039311_assign3`.`Submission` VALUES (null, '" . $username . "', '" . $qid . "', '" . $score . "', '" . $timer . "', '" . $hints . "', '" . $stem . "', '" . $answer . "','" . $skill . "')";
								$result = mysql_query($query) or die(" Query failed 1");
							}
							
							$avgsec = secsToFormat(getAvgQuestionTime($qid));
							echo "<div id=\"q".$i."result\" class=\"".$prefix."correct\"><a class='various' data-fancybox-type='iframe' href='/question.php?qid=$qid&answer=$answer'>Q".$i.": ".$prefix."correct, " . secsToFormat($timer) ."</a> <span style='color:grey'>(Avg: $avgsec)</span></div><br>";

						}
						
						$score = floor($sum/3 * 10000) / 100;
						
						//submit quiz info to db
						if ($username != "" && isset($username)){
							// check results havent been submitted yet
							if (isset($doSubmit) && $doSubmit == 1){
								setcookie("doSubmit", 0);
								//submit data to db								
								
								$date = date ("Y-m-d H:i:s", time());
								
								$query =   "INSERT INTO `a5039311_assign3`.`Quiz` VALUES (null, '" . $username . "', '" . $_POST['totalTimer'] . "', '" . $score . "', '" . $date . "')";
								$result = mysql_query($query) or die(" Query failed 2");
							}							
						}
						
						echo "<br><div id='scoreTime'>Total Score: ".$score."% <div style='position: relative; color:grey; display:inline-block;' onMouseOver='toggleHiddenGraph(\"scoreGraph\");' onMouseOut='toggleHiddenGraph(\"scoreGraph\");'>(details)";
							//hidden score graph
							echo "<div id='scoreGraph' class='hidden'>\n";
								//hidden graph table
								echo "<table class='admintable' border='0' cellpadding='2' cellspacing='0'>\n";
									$scoreCounts = array(0,0,0,0,0,0,0,0,0,0);
									$greenIndex = 0;
									
									// graph row
									echo "<tr>\n";
									
									$query = "SELECT score FROM Quiz";								
									$result = mysql_query($query);
									if (mysql_errno()) { 
										echo "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>When executing:<br>\n$query\n<br>"; 
										die();
									}									
									
									//get score counts
									while($row = mysql_fetch_array($result)){
										$tmpscore = $row['score'];
										if ($tmpscore == 100){
											$index = 9;
										} else {
											$index = round(floor($tmpscore/10), 0);
										}
										if ($tmpscore == $score) $greenIndex = $index;
										$scoreCounts[$index]++;
									}
									
									//get max count
									$maxcount = 0;					
									for($i = 0; $i < 10; $i++){
										if($scoreCounts[$i] > $maxcount) $maxcount = $scoreCounts[$i];
									}									
									if($maxcount == 0) $maxcount = 1;
									
									for($i = 0; $i < 10; $i++){
										$bgcolor = ($i == $greenIndex) ? "green" : "#ff7100";
										$percent = round($scoreCounts[$i]/$maxcount * 10000)/100;
										$percent = ($percent == 100) ? 83 : ($percent - 2);
										$percentdiff = 100-$percent-17;
										echo "<td class='admintd1'>";
										echo "<center><div style='height:100px;width:23px;'> <div style='background-color:white;height:".$percentdiff."%;'></div>\n";
										echo "<div>$scoreCounts[$i]</div><div class='bar-border' style='background-color:$bgcolor;height:".$percent."%;'></div></div><center>\n</td>\n";
									}
									echo "</tr>\n";	
						
									//labels row
									echo "<tr>\n";
									for($i = 0; $i < 10; $i++){
										$lower = ($i < 1) ? "0" : $i. "0";
										$upper = ($i+1) . "0";
										echo "<td class='admintd1' style='font-size:11'>[$lower-$upper]</td>\n";
									}
									echo "</tr>\n";	
								
								echo "</table>\n";
							echo "</div>";
						echo "</div><br>";
						echo "Total Time: ". secsToFormat($_POST['totalTimer']) . " <div style='position: relative; color:grey; display:inline-block;' onMouseOver='toggleHiddenGraph(\"timeGraph\");' onMouseOut='toggleHiddenGraph(\"timeGraph\");'> (details)";
							//hidden score graph
							echo "<div id='timeGraph' class='hidden' style='position:fixed;top: 205px;'>\n";
								//hidden graph table
								echo "<table class='admintable' border='0' cellpadding='2' cellspacing='0' style='display:inline-block;float:left'>\n";
									$timeCounts = array(0,0,0,0,0,0,0,0,0,0);
									$greenIndex = 0;
									
									//get max time
									$maxtime = 0;
									$query = "SELECT MAX(time) FROM Quiz";								
									$result = mysql_query($query);									
									if($row = mysql_fetch_array($result)){
										$maxtime = $row['MAX(time)'];
									}
									
									$interval = $maxtime/10;
									
									// graph row
									echo "<tr>\n";
									
									$query = "SELECT time FROM Quiz";								
									$result = mysql_query($query);
									
									//get score counts
									while($row = mysql_fetch_array($result)){
										$tmptime = $row['time'];
										if ($tmptime == $maxtime){
											$index = 9;
										} else {
											$index = round(floor($tmptime/$interval), 0);
										}
										$timeCounts[$index]++;
									}
									
									$greenIndex = round(floor($_POST['totalTimer']/$interval), 0) . "<br>";
									
									//get max count
									$maxcount = 0;					
									for($i = 0; $i < 10; $i++){
										if($timeCounts[$i] > $maxcount) $maxcount = $timeCounts[$i];
									}									
									if($maxcount == 0) $maxcount = 1;
									
									for($i = 0; $i < 10; $i++){
										$bgcolor = ($i == $greenIndex) ? "green" : "#ff7100";
										$percent = round($timeCounts[$i]/$maxcount * 10000)/100;
										$percent = ($percent == 100) ? 83 : ($percent - 2);
										$percentdiff = 100-$percent-17;
										echo "<td class='admintd1'>";
										echo "<center><div style='height:100px;width:23px;'> <div style='background-color:white;height:".$percentdiff."%;'></div>\n";
										echo "<div>$timeCounts[$i]</div><div class='bar-border' style='background-color:$bgcolor;height:".$percent."%;'></div></div><center>\n</td>\n";
									}
									echo "</tr>\n";	
						
									//labels row
									echo "<tr>\n";
									for($i = 0; $i < 10; $i++){
										echo "<td class='admintd1' style='font-size:11'>".($i+1)."</td>\n";
									}
									echo "</tr>\n";	
								
								echo "</table>\n";
								
								echo "<div style='display:inline-block;font-size:11;margin-left:8px;float:right'>";
								for($i = 0; $i < 10; $i++){
									$lower = ($i == 0) ? secsToFormat($i * $interval) : secsToFormat(($i * $interval)+1);
									$upper = secsToFormat((($i+1) * $interval));
									echo ($i+1)." : [$lower - $upper]<br>\n";
								}
								echo "</div>";
								
							echo "</div>";
						echo "</div>";
						
						echo "</div>";
						
						closeCon($con);
						?>
						
						
						<!--<div id="q1result" class="correct"></div>
						<div id="q2result" class="correct"></div>
						<div id="q3result" class="incorrect"></div><br><br>-->
					
					<!--</div>-->
				
				</div>	
			</td>
			
			<!-- RIGHT (nav) section -->
			<td class="right">
			
				<div id="nav">
					<button id="bHome" onClick="window.location.href='welcome'"> Home </button> 
						
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
		
		<script type="text/javascript">
	
	
</script>
	</BODY>
</HTML>

