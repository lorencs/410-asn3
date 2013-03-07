<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>	
	<HEAD>
		<meta http-equiv="Content-type" content="text/html;charset=UTF-8">
		<style type="text/css">
			body{font-family: Calibri, Candara, Segoe, "Segoe UI", Optima, Arial, sans-serif;}
		</style>
		<LINK REL=STYLESHEET HREF="design.css" TYPE="text/CSS">
		<TITLE>CMPUT410 Assignment 3 - Quiz Page</TITLE>
		<script language="JavaScript" src="functions.js" ></script>
		<script language="JavaScript" src="quiz.js" ></script>		
		
		<script language="JavaScript" >
			questionTimers = new Array (new Date(),new Date(),new Date());
			for (var i = 0; i < 3; i++){
				questionTimers[i].setTime(0);
			}
	
			
			var currentQ = 0;
			var answeredQ = new Array(false,false,false);
			//var totalQ;			
		</script>
		
	<?php
	// class to hold each question
	class Question {
		public $correct;
		public $media = array();
		public $stem;
		public $source;
		public $options;
		public $skill = array();
		public $anstype;
		public $id;
		public $hints = array();
	}
 
	//array of questions
	$questions = array();
	
	$file = fopen("data.txt", "r");
	
	
	// generate a random set of 2 to 5 question indices 
	$count = 3;//rand(2,5);
	
	$max = 15;
	$range = range(1, $max);
	$vals = array_rand($range, $count);
	
	foreach($vals as &$val){
		$val = $val+1;
		echo $val . "<br>";
	}
	
	// read in question data
	while (!feof($file)) {
		$line = fgets($file);
		$json = json_decode($line, true);
		
		if (in_array($json['id'], $vals)){
			$question = new Question();
			$question->correct = $json['correct'];
			
			foreach($json['media'] as $key => $value) {
				$question->media[$key] = $value;
			}
			
			$question->stem = $json['stem'];
			$question->source = $json['source'];
			
			foreach($json['options'] as $key => $value) {
				$question->options[$key] = $value;
			}
			
			$question->skill = $json['skill'];
			$question->anstype = $json['anstype'];
			$question->id = $json['id'];
			
			foreach($json['hints'] as $key => $value) {
				$question->hints[$key] = $value;
			}
			
			array_push($questions, $question);
		}
	}
	fclose($file);
		
	
	foreach ($questions as $question){
		echo $question->stem . "<br>";
	}
	
	?>
	
	<script language="Javascript">
		//send number of questions from PHP to javascript
		var totalQ = '<?= $count ?>';
	</script>
	
	</HEAD>
	
	<BODY>
		<table class="shadow" border="0" cellpadding="2" cellspacing="0" width="800px" align="center">		
			<tr>
		<div id="all" class="default">		
			<td class="left"> 
				<div id="alert" class="hidden">Please <a href="index.php">register or login</a> taking the quiz.</div>
				
					
					<div id="results" class="hidden">
						<h3>Results for <script> document.write(getCookie("name"));</script>:<h3>
						<div id="q1result" class="correct"></div>
						<div id="q2result" class="correct"></div>
						<div id="q3result" class="incorrect"></div>
						<div id="scoreTime"></div>
					</div>
					
					<div class="extra-pad">
						<div id="intro" style="vertical-align:middle;"><p> Press the button to begin the quiz</p></div>
					
					<?php 
					
					//print each question
					for($i = 1;$i < $count+1; $i++){
						//div class
						echo "<div id=\"q" .$i . "\" class=\"hidden\"><div style=\"vertical-align: top;\" >";	
						
						//print media
						foreach($questions[$i-1]->media as $media){
							if (preg_match('/avi$/', $media)){
								echo "<embed src=\"" . $media . "\" style=\"max-width:100%;\">";
							} else {
								echo "<img src=\"" . $media . "\" style=\"max-width:100%;\">";
							}
						}
						
						//print question
						echo "<div class=\"qlabel\"> " . $questions[$i-1]->source . "<br><br>" . " " . $i . ". " . $questions[$i-1]->stem . "</div><br><br><br><br></div>";
					
						//print hints
						echo "<div style=\"vertical-align: bottom;\" >";	
						$hintcount = 1;
						foreach($questions[$i-1]->hints as $hint){
							echo "<button onClick=\" toggleHint(" . $hintcount .");\">Hint #" . $hintcount . "</button>";
							echo "<div id=\"hint" . $hintcount . "\" class=\"hidden\">" . $hint . "</div><br>";
							$hintcount++;
						}
						echo "</div>";
					
						echo "</div>";
					}
					
					
					
					?>
					

						<!--<div id="q1" class="hidden">
							<div class="qlabel"> 1. What is sin(2&#960;)? </div>
						</div>
						

						<div id="q2" class="hidden">
							<img src="http://www.ricksmath.com/images/rtriangle5.gif" alt="triangle picture">
							<div class="qlabel"> 2. What is the length of the missing side? </div>										
						</div>
						

						<div id="q3" class="hidden">
							<div class="qlabel"> 3. What is the derivative of x<sup>2</sup>? </div>											
						</div>
					</div>-->
					
				</td>
					
				<td class="middle">
					
				
					<div id="a1" class="hidden">
						<ul class="qlist">
						<li><label for="q1a"><input type="radio" name="q1" id ="q1a" value="a" onClick="increment(1)">0</label></li>
						<li><label for="q1b"><input type="radio" name="q1" id ="q1b" value="b" onClick="increment(1)">2&#960;</label></li>
						<li><label for="q1c"><input type="radio" name="q1" id ="q1c" value="c" onClick="increment(1)">4&#960;</label></li>
						<li><label for="q1d"><input type="radio" name="q1" id ="q1d" value="d" onClick="increment(1)">6&#960;</label></li>
						</ul>											
					</div>
					
					<div id="a2" class="hidden">
						<ul class="qlist">
						<li><label for="q2a"><input type="radio" name="q2" id ="q2a" value="a" onClick="increment(2)">2</label></li>
						<li><label for="q2b"><input type="radio" name="q2" id ="q2b" value="b" onClick="increment(2)">4</label></li>
						<li><label for="q2c"><input type="radio" name="q2" id ="q2c" value="c" onClick="increment(2)">&radic;119</label></li>
						<li><label for="q2d"><input type="radio" name="q2" id ="q2d" value="d" onClick="increment(2)">&radic;167</label></li>
						</ul>											
					</div>
					
					<div id="a3" class="hidden">
						<ul class="qlist">
						<li><label for="q3a"><input type="radio" name="q3" id ="q3a" value="a" onClick="increment(3)">2x</label></li>
						<li><label for="q3b"><input type="radio" name="q3" id ="q3b" value="b" onClick="increment(3)">x<sup>3/3</sup></label></li>
						<li><label for="q3c"><input type="radio" name="q3" id ="q3c" value="c" onClick="increment(3)">2x<sup>2</sup></label></li>
						<li><label for="q3d"><input type="radio" name="q3" id ="q3d" value="d" onClick="increment(3)">2</label></li>
						</ul>											
					</div>
				</td>
				
				<!-- RIGHT (nav) section -->
				<td class="right">
				
	
					<br>
					<button id="bStart" onClick="startQuiz()"> Start Quiz </button> 
					<button id="bPrev" class="hidden" onClick="prevQ()"> prev </button>
					<button id="bNext" class="hidden" onClick="nextQ()"> next </button>
					<button id="bSubmit" class="hidden" onClick="submitQuiz()"> submit </button><br><br>
					
					<div id="timer1">Timer: 0s</div>
					<div id="timer2">Question Timer: 0s</div>
					<div id="qPos">Question: 0/3</div>
					
					<br>
					<div id="progressbar">
						<div id="progressbardiv"></div>
					</div>
							

				
				</td>
			
			</tr>		
		</table>
		
		<script>
		// if user hasn't reigstered, dont show quiz
			if (getCookie("name") == null || getCookie("name") == "") {
				document.getElementById("all").className="hidden";
				document.getElementById("alert").className="default";
			}
		</script>
	</BODY>
</HTML>

